<?php

namespace madmis\JiraApi\Endpoint;

use GuzzleHttp\Psr7\Request;
use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Model\Project;

/**
 * Class ProjectEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class ProjectEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/project';

    protected $projectClass = 'madmis\JiraApi\Model\Project';

    /**
     * @param bool $mapping mapping response items to objects
     * @return array|Project[]
     */
    public function getProjects($mapping = false)
    {
        $headers = $this->client->getAuthentication()->getHeaders();
        $request = new Request(Http::METHOD_GET, $this->getApiUri(), $headers);

        $response = $this->processResponse(
            $this->client->send($request)
        );

        if ($mapping) {
            $response = $this->deserializeItems($response, $this->projectClass);
        }

        return $response;
    }

    /**
     * @param string $projectIdOrKey
     * @param bool $mapping mapping response to object
     * @return array|Project
     * @throws ClientException
     */
    public function getProject($projectIdOrKey, $mapping = false)
    {
        $headers = $this->client->getAuthentication()->getHeaders();
        $request = new Request(Http::METHOD_GET, $this->getApiUri([$projectIdOrKey]), $headers);

        $response = $this->processResponse(
            $this->client->send($request)
        );

        if ($mapping) {
            $response = $this->deserializeItem($response, $this->projectClass);
        }

        return $response;
    }
}