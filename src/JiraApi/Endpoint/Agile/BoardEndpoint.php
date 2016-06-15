<?php

namespace madmis\JiraApi\Endpoint\Agile;

use HttpLib\Http;
use madmis\JiraApi\Endpoint\AbstractEndpoint;
use madmis\JiraApi\Exception\ClientException;
use madmis\JiraApi\Exception\InvalidArgumentException;

/**
 * Class BoardEndpoint
 * @package madmis\JiraApi\Endpoint\Agile
 */
class BoardEndpoint extends AbstractEndpoint
{
    const TYPE_SCRUM = 'scrum';
    const TYPE_KANBAN = 'kanban';

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

    /**
     * Docs:
     *  - {@link https://docs.atlassian.com/jira-software/REST/cloud/#agile/1.0/board-createBoard}
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/filter-createFilter}
     * @param string $name Must be less than 255 characters.
     * @param string $type Valid values: scrum, kanban
     * @param int $filterId Id of a filter that the user has permissions to view.
     * @throws InvalidArgumentException
     * @return array
     */
    public function createBoard($name, $type, $filterId)
    {
        if (!in_array($type, $this->getTypes(), true)) {
            throw new InvalidArgumentException();
        }

        $options = [
            'name' => $name,
            'type' => $type,
            'filterId' => $filterId,
        ];

        return $this->sendRequest(Http::METHOD_POST, $this->getApiUrn(), ['json' => $options]);
    }

    /**
     * @param int $boardId
     * @return array
     */
    public function getBoard($boardId)
    {
        return $this->sendRequest(Http::METHOD_GET, $this->getApiUrn([$boardId]));
    }

    /**
     * @param int $boardId
     * @return void
     * @throws ClientException if can't delete board
     */
    public function deleteBoard($boardId)
    {
        $this->sendRequest(Http::METHOD_DELETE, $this->getApiUrn([$boardId]));
    }

    /**
     * @return array
     */
    private function getTypes()
    {
        return [self::TYPE_SCRUM, self::TYPE_KANBAN];
    }
}
