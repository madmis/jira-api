<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Model\Attachment;
use madmis\JiraApi\Model\Issue;
use madmis\JiraApi\Model\Worklog;

/**
 * Class IssueEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class IssueEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/issue';

    /**
     * Returns a full representation of the issue for the given issue key.
     *
     * The fields param (which can be specified multiple times) gives a
     * comma-separated list of fields to include in the response.
     * This can be used to retrieve a subset of fields.
     * A particular field can be excluded by prefixing it with a minus.
     *
     * By default, all (*all) fields are returned in this get-issue resource.
     *
     * Note: the default is different when doing a jql search -- the default
     * there is just navigable fields (*navigable).
     *
     * - *all - include all fields
     * - *navigable - include just navigable fields
     * - summary,comment - include just the summary and comments
     * - -comment - include everything except comments (the default is *all for get-issue)
     * - *all,-comment - include everything except comments
     *
     * @param string $issueIdOrKey
     * @param string $fields
     * @param string $expand
     * @param bool $mapping mapping response to object
     * @return array|Issue
     * @throws ClientException
     */
    public function getIssue($issueIdOrKey, $fields = '*all', $expand = '', $mapping = false)
    {
        $options = [
            'query' => [
                'expand' => $expand,
                'fields' => $fields,
            ]
        ];
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$issueIdOrKey]), $options);

        if ($mapping) {
            $issue = array_merge($response['fields'], $response);
            $response = $this->deserializeItem($issue, Issue::class);
        }

        return $response;
    }

    /**
     * Get issue worklog
     * @param string $issueIdOrKey
     * @param string $expand
     * @param bool $mapping mapping response to object
     * @return array|Worklog[]
     */
    public function getWorklog($issueIdOrKey, $expand = '', $mapping = false)
    {
        $options = [
            'query' => [
                'expand' => $expand,
            ]
        ];
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$issueIdOrKey, 'worklog']), $options);

        if ($mapping) {
            $response = $this->deserializeItems($response['worklogs'], Worklog::class);
        }

        return $response;
    }

    /**
     * create JIRA Attachment
     * @param string $issueIdOrKey
     * @param array $files files path
     * @param array $options
     * @param bool $mapping mapping response to object
     * @throws \InvalidArgumentException if one of files does not exist
     * @return array
     */
    public function createAttachment($issueIdOrKey, array $files, $options = [], $mapping = false)
    {
        $uri = $this->getApiUrn([$issueIdOrKey, 'attachments']);

        $options = array_merge([
            'multipart' => [],
            'headers' => ['X-Atlassian-Token' => 'nocheck'],
        ], $options);
        foreach($files as $file) {
            if (!file_exists($file)) {
                throw new \InvalidArgumentException("File {$file} does not exist");
            }

            $options['multipart'][] = [
                'name' => 'file',
                'contents' => fopen($file, 'r')
            ];
        }


        $response = $this->sendRequest(Http::METHOD_POST, $uri, $options);

        if ($mapping) {
            $response = $this->deserializeItems($response, Attachment::class);
        }

        return $response;
    }

    public function editIssue($issueKey, $params)
    {
        return $this->api(self::REQUEST_PUT, sprintf("/rest/api/2/issue/%s", $issueKey), $params);
    }

    /**
     * add a comment to a ticket
     *
     * issue key should be YOURPROJ-221
     *
     * @param $issueKey
     * @param $params
     * @return mixed
     */
    public function addComment($issueKey, $params)
    {
        if (is_string($params)) {
            // if $params is scalar string value -> wrapping it properly
            $params = array(
                'body' => $params
            );
        }
        return $this->api(self::REQUEST_POST, sprintf("/rest/api/2/issue/%s/comment", $issueKey), $params);
    }

    /**
     * create an issue.
     *
     * @param $projectKey
     * @param $summary
     * @param $issueType
     * @param array $options
     * @return mixed
     */
    public function createIssue($projectKey, $summary, $issueType, $options = array())
    {
        $default = array(
            "project" => array(
                "key" => $projectKey,
            ),
            "summary" => $summary,
            "issuetype" => array(
                "id" => $issueType,
            )
        );
        $default = array_merge($default, $options);
        $result = $this->api(
            self::REQUEST_POST,
            "/rest/api/2/issue/",
            array(
                "fields" => $default
            )
        );
        return $result;
    }

    /**
     * TODO: new endpoint
     * query issues
     *
     * @param $jql
     * @param $startAt
     * @param $maxResult
     * @param string $fields
     *
     * @return Jira_API_Result
     */
    public function search($jql, $startAt = 0, $maxResult = 20, $fields = '*navigable')
    {
        $result = $this->api(
            self::REQUEST_GET,
            "/rest/api/2/search",
            array(
                "jql" => $jql,
                "startAt" => $startAt,
                "maxResults" => $maxResult,
                "fields" => $fields,
            )
        );
        return $result;
    }

    /**
     * set watchers in a ticket
     *
     * @param $issueKey
     * @param $watchers
     * @return mixed
     */
    public function setWatchers($issueKey, $watchers)
    {
        $result = array();
        foreach ($watchers as $w) {
            $result[] = $this->api(self::REQUEST_POST, sprintf("/rest/api/2/issue/%s/watchers", $issueKey), $w);
        }
        return $result;
    }
}