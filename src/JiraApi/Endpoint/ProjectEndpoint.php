<?php

namespace madmis\JiraApi\Endpoint;

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

    /**
     * @param string $expand
     * @param bool $mapping mapping response items to objects
     * @return array|Project[]
     * @throws ClientException
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
     * @throws ClientException
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

    /**
     * Returns all roles in the given project Id or key, with links to full details on each role.
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/project/{projectIdOrKey}/role-getProjectRoles}
     * @param string $projectIdOrKey
     * @return array
     * @throws ClientException
     */
    public function getRoles($projectIdOrKey)
    {
        return $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$projectIdOrKey, 'role']));
    }

    /**
     * Returns the details for a given project role in a project.
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/project/{projectIdOrKey}/role-getProjectRole}
     * @param string $projectIdOrKey
     * @param int $roleId
     * @return array
     * @throws ClientException
     */
    public function getRoleDetails($projectIdOrKey, $roleId)
    {
        return $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$projectIdOrKey, 'role', $roleId]));
    }

    /**
     * Contains a full representation of a the specified project's versions.
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/project-getProjectVersions}
     * @param string $projectIdOrKey
     * @param string $expand
     * @return array
     * @throws ClientException
     */
    public function getVersions($projectIdOrKey, $expand = '')
    {
        $query = [
            'expand' => $expand,
        ];

        return $this->sendRequest(
            Http::METHOD_GET,
            $this->getApiUrn([$projectIdOrKey, 'versions']),
            ['query' => $query]
        );
    }
}
