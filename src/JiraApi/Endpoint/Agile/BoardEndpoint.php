<?php

namespace madmis\JiraApi\Endpoint\Agile;

use HttpLib\Http;
use madmis\JiraApi\Endpoint\AbstractEndpoint;
use madmis\JiraApi\Exception\ClientException;

/**
 * Class BoardEndpoint
 * @package madmis\JiraApi\Endpoint\Agile
 */
class BoardEndpoint extends AbstractEndpoint
{
    /**
     * @var string
     */
    protected $baseUrn = '/rest/agile/1.0/board';

    /**
     * @param array $params
     * @return string
     */
    public function getApiUrn(array $params = [])
    {
        $path = $params ? implode('/', $params) : '';

        return sprintf('%s/%s', $this->baseUrn, $path);
    }


    /**
     * Docs:
     *  - {@link https://docs.atlassian.com/jira-software/REST/cloud/#agile/1.0/board-getAllBoards}
     * @param int $startAt
     * @param int $maxResults
     * @param string $type Filters results to boards of the specified type. Valid values: scrum, kanban.
     * @param string $name Filters results to boards that match or partially match the specified name.
     * @param string $projectKeyOrId Filters results to boards that are relevant to a project.
     * @return array
     * @throws ClientException
     */
    public function getBoards($startAt = 0, $maxResults = 50, $type = null, $name = null, $projectKeyOrId = null)
    {
        $query = [
            '$startAt' => $startAt,
            '$maxResults' => $maxResults,
        ];
        $type ? $query['type'] = $type : null;
        $name ? $query['name'] = $name : null;
        $projectKeyOrId ? $query['projectKeyOrId'] = $projectKeyOrId : null;

        $response = $this->sendRequest(
            Http::METHOD_GET,
            $this->getApiUrn(),
            ['query' => $query]
        );

        return $response;
    }
}
