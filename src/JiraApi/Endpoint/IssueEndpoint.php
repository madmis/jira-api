<?php

namespace madmis\JiraApi\Endpoint;

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
     * <pre>
     * Returns a full representation of the issue for the given issue key.
     * The fields param (which can be specified multiple times) gives a comma-separated list of fields to include in the response.
     * This can be used to retrieve a subset of fields. A particular field can be excluded by prefixing it with a minus.
     *
     * By default, all (*all) fields are returned in this get-issue resource.
     * Note: the default is different when doing a jql search -- the default there is just navigable fields (*navigable).
     *      *all - include all fields
     *      *navigable - include just navigable fields
     *      summary,comment - include just the summary and comments
     *      -comment - include everything except comments (the default is *all for get-issue)
     *      *all,-comment - include everything except comments
     * </pre>
     * @param string $issueIdOrKey
     * @param string $fields
     * @param string $expand
     * @param bool $mapping mapping response to object
     * @return array|Issue
     * @throws ClientException
     */
    public function getIssue($issueIdOrKey, $fields = '*all', $expand = '', $mapping = false)
    {
        $options = [
            'query' => [
                'expand' => $expand,
                'fields' => $fields,
            ]
        ];
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUri([$issueIdOrKey]), $options);

        if ($mapping) {
            $issue = array_merge($response['fields'], $response);
            $response = $this->deserializeItem($issue, $this->issueClass);
        }

        return $response;
    }
}