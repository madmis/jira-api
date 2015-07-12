<?php

namespace madmis\JiraApi\Endpoint;

use GuzzleHttp\Psr7\Request;
use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Model\Issue;

/**
 * Class IssueEndpoint
 * @package madmis\JiraApi\Endpoint
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