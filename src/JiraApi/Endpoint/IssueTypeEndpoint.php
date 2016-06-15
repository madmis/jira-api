<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Model\IssueType;

/**
 * Class IssueTypeEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class IssueTypeEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/issuetype';

    /**
     * Returns a list of all issue types visible to the user
     * @param bool $mapping mapping response to object
     * @return array|IssueType[]
     * @throws ClientException
     */
    public function getIssueTypes($mapping = false)
    {
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUrn());

        if ($mapping) {
            $response = $this->deserializeItems($response, IssueType::class);
        }

        return $response;
    }
}
