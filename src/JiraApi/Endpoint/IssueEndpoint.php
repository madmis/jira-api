<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Model\Attachment;
use madmis\JiraApi\Model\Issue;
use madmis\JiraApi\Model\Worklog;
use madmis\JiraApi\Util\Arr;

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
     * Edits an issue
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#d2e2563}
     *  - {@link https://developer.atlassian.com/jiradev/jira-apis/jira-rest-apis/jira-rest-api-tutorials/jira-rest-api-example-edit-issues}
     * @param string $issueIdOrKey
     * @param array $params
     * @return void
     * @throws ClientException
     */
    public function editIssue($issueIdOrKey, array $params)
    {
        $options = ['json' => $params];

        $urn = $this->getApiUrn([$issueIdOrKey]);

        $this->sendRequest(Http::METHOD_PUT, $urn, $options);
    }


    /**
     * Creates an issue or a sub-task
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#d2e2279}
     *  - {@link https://developer.atlassian.com/jiradev/jira-apis/jira-rest-apis/jira-rest-api-tutorials/jira-rest-api-example-create-issue}
     * @param string $projectKey
     * @param string $summary
     * @param int $issueTypeId
     * @param array $options
     * @param bool $mapping mapping response to object
     * @return array|Issue
     * @throws ClientException
     */
    public function createIssue($projectKey, $summary, $issueTypeId, array $options = [], $mapping = false)
    {
        $options = array_merge($options, [
            'fields' => [
                'project' => ['key' => $projectKey],
                'summary' => $summary,
                'issuetype' => ['id' => $issueTypeId]
            ]
        ]);

        $response = $this->sendRequest(Http::METHOD_POST, $this->getApiUrn(), ['json' => $options]);

        if ($mapping) {
            $response = $this->deserializeItem($response, Issue::class);
        }

        return $response;
    }

    /**
     * Get issue worklog
     * @param string $issueIdOrKey
     * @param string $expand
     * @param bool $mapping mapping response to object
     * @return array|Worklog[]
     * @throws ClientException
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
     * @return array
     * @throws \InvalidArgumentException if one of files does not exist
     * @throws ClientException
     */
    public function createAttachment($issueIdOrKey, array $files, array $options = [], $mapping = false)
    {
        $uri = $this->getApiUrn([$issueIdOrKey, 'attachments']);

        $options = array_merge([
            'multipart' => [],
            'headers' => ['X-Atlassian-Token' => 'nocheck'],
        ], $options);
        foreach ($files as $file) {
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


    /**
     * Adds a user to an issue's watcher list.
     * @param string $issueIdOrKey
     * @param string $watcher username
     * @return void
     * @throws ClientException
     */
    public function setWatcher($issueIdOrKey, $watcher)
    {
        $urn = $this->getApiUrn([$issueIdOrKey, 'watchers']);

        $this->sendRequest(Http::METHOD_POST, $urn, ['json' => $watcher]);
    }

    /**
     * Adds a new comment to an issue
     *
     * @param string $issueIdOrKey
     * @param string $comment
     * @param array $visibility Example: ["type" => "role", "value" => "Administrators"]
     * @param string $expand optional flags: renderedBody (provides body rendered in HTML)
     * @return array
     * @throws ClientException
     */
    public function addComment($issueIdOrKey, $comment, array $visibility = [], $expand = '')
    {
        $options = [
            'json' => ['body' => $comment],
            'query' => $expand,
        ];

        if ($visibility) {
            $options['json']['visibility'] = $visibility;
        }

        $urn = $this->getApiUrn([$issueIdOrKey, 'comment']);

        return $this->sendRequest(Http::METHOD_POST, $urn, $options);
    }

    /**
     * Returns the meta data for creating issues.
     * Fields will only be returned if expand=projects.issuetypes.fields.
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/issue-getCreateIssueMeta}
     * @param array $projectIds combined with the projectKeys param, lists the projects with which to filter the results. If empty, all projects are returned.
     * @param array $projectKeys combined with the projectIds param, lists the projects with which to filter the results. If empty, all projects are returned.
     * @param array $issueTypeIds combinded with issueTypeNames, lists the issue types with which to filter the results. If empty, all issue types are returned.
     * @param array $issueTypeNames combinded with issueTypeIds, lists the issue types with which to filter the results. If empty, all issue types are returned.
     * @param string $expand
     * @return array
     * @throws ClientException
     */
    public function getCreateMeta(
        array $projectIds = [],
        array $projectKeys = [],
        array $issueTypeIds = [],
        array $issueTypeNames = [],
        $expand = ''
    ) {

        $query = [
            'expand' => $expand,
        ];

        if ($projectIds) {
            $query['projectIds'] = implode(',', $projectIds);
        }
        if ($projectKeys !== null) {
            $data['projectKeys'] = implode(',', $projectKeys);
        }
        if ($issueTypeIds !== null) {
            $data['issuetypeIds'] = implode(',', $issueTypeIds);
        }
        if ($issueTypeNames !== null) {
            $data['issuetypeNames'] = implode(',', Arr::quoteValues($issueTypeNames));
        }

        return $this->sendRequest(Http::METHOD_GET, $this->getApiUrn(['createmeta']), ['query' => $query]);
    }
}
