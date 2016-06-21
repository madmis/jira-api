<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;
use madmis\JiraApi\Exception\ClientException;

/**
 * Class VersionEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class VersionEndpoint extends AbstractEndpoint
{
    /**
     * @var string
     */
    protected $baseUrn = '/version';

    /**
     * Returns a bean containing the number of fixed in and affected issues for the given version.
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/version-getVersionRelatedIssues}
     * @param int $versionId
     * @return array
     * @throws ClientException
     */
    public function getRelatedIssues($versionId)
    {
        return $this->sendRequest(
            Http::METHOD_GET,
            $this->getApiUrn([$versionId, 'relatedIssueCounts'])
        );
    }

    /**
     * Returns the number of unresolved issues for the given version
     * Docs:
     *  - {@link https://docs.atlassian.com/jira/REST/latest/#api/2/version-getVersionUnresolvedIssues}
     * @param int $versionId
     * @return array
     * @throws ClientException
     */
    public function getUnresolvedIssuesCount($versionId)
    {
        return $this->sendRequest(
            Http::METHOD_GET,
            $this->getApiUrn([$versionId, 'unresolvedIssueCount'])
        );
    }
}
