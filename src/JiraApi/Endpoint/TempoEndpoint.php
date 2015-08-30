<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;

/**
 * Tempo - this is jira plugin for timesheets.
 * https://tempoplugin.jira.com/wiki/display/JTS/Tempo+REST+APIs
 *
 * Class TempoEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class TempoEndpoint extends AbstractEndpoint
{
    /**
     * @param array $params
     * @return string
     */
    public function getApiUrn(array $params = [])
    {
        $path = $params ? implode('/', $params) : '';

        return sprintf(
            '%s/%s',
            $this->client->getOption('tempo_timesheets_urn'),
            $path
        );
    }

    /**
     * Get worklog by Tempo plugin REST API
     * @param string $projectKey key of a project you wish to get the worklogs for
     * @param string $dateFrom Y-m-d
     * @param string $dateTo Y-m-d
     * @param string $userName name of the user you wish to get the worklogs for
     * @return array
     */
    public function getTempoWorklog($projectKey, $dateFrom, $dateTo, $userName = null)
    {
        $options = [
            'query' => [
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'projectKey' => $projectKey,
            ]
        ];
        if ($userName) {
            $options['query']['username'] = $userName;
        }

        $urn = $this->getApiUrn(['worklogs']);
        $response = $this->sendRequest(Http::METHOD_GET, $urn, $options);

        return $response;
    }
}