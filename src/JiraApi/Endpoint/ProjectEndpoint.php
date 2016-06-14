<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;
use madmis\JiraApi\Model\Project;

/**
 * Class ProjectEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class ProjectEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/project';

    /**
     * @param string $expand
     * @param bool $mapping mapping response items to objects
     * @return array|Project[]
     */
    public function getProjects($expand = '', $mapping = false)
    {
        $options = ['query' => ['expand' => $expand]];
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUrn(), $options);

        if ($mapping) {
            $response = $this->deserializeItems($response, Project::class);
        }

        return $response;
    }

    /**
     * @param string $projectIdOrKey
     * @param string $expand
     * @param bool $mapping mapping response to object
     * @return array|Project
     */
    public function getProject($projectIdOrKey, $expand = '', $mapping = false)
    {
        $options = ['query' => ['expand' => $expand]];
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$projectIdOrKey]), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response, Project::class);
        }

        return $response;
    }
}
