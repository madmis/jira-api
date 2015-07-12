<?php

namespace madmis\JiraApi\Endpoint;

use GuzzleHttp\Psr7\Request;
use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Model\Issue;

/**
 * Class IssueEndpoint
 * @package madmis\JiraApi\Endpoint
 *
 * http://example.com:8080/jira/rest/api/2/issue [POST]
 * http://example.com:8080/jira/rest/api/2/issue/bulk [POST]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey} [GET, DELETE, PUT]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/assignee [PUT]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/comment [GET, POST]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/comment/{id} [GET, PUT, DELETE]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/editmeta [GET]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/notify [POST]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/remotelink [GET, POST, DELETE]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/remotelink/{linkId} [GET, PUT, DELETE]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/transitions [GET, POST]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/votes [DELETE, POST, GET]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/watchers [GET, POST, DELETE]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/worklog [GET, POST]
 * http://example.com:8080/jira/rest/api/2/issue/{issueIdOrKey}/worklog/{id} [GET, PUT, DELETE]
 * http://example.com:8080/jira/rest/api/2/issue/createmeta [GET]
 * http://example.com:8080/jira/rest/api/2/issue/picker [GET]
 */
class IssueEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/issue';

    protected $issueClass = 'madmis\JiraApi\Model\Issue';

    /**
     * @param string $issueIdOrKey
     * @param bool $mapping mapping response to object
     * @return array|Issue
     * @throws ClientException
     */
    public function getIssue($issueIdOrKey, $mapping = false)
    {
        $headers = $this->client->getAuthentication()->getHeaders();
        $request = new Request(Http::METHOD_GET, $this->getApiUri([$issueIdOrKey]), $headers);

        $response = $this->processResponse(
            $this->client->send($request)
        );

        if ($mapping) {
            $issue = array_merge($response['fields'], $response);
            $response = $this->deserializeItem($issue, $this->issueClass);
        }

        return $response;
    }
}