<?php

namespace madmis\JiraApi\Endpoint;

use HttpLib\Http;

/**
 * Class SearchEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class SearchEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/search';

    /**
     * Sorting the jql parameter is a full JQL expression, and includes an ORDER BY clause.
     *
     * The fields param (which can be specified multiple times) gives a comma-separated list
     * of fields to include in the response. This can be used to retrieve a subset of fields.
     * A particular field can be excluded by prefixing it with a minus.
     *
     * By default, only navigable (*navigable) fields are returned in this search resource.
     * Note: the default is different in the get-issue resource -- the default there all fields (*all).
     *  - *all - include all fields
     *  - *navigable - include just navigable fields
     *  - summary,comment - include just the summary and comments
     *  - -description - include navigable fields except the description (the default is *navigable for search)
     *  - *all,-comment - include everything except comments
     *
     * Expanding Issues in the Search Result:
     *
     * It is possible to expand the issues returned by directly specifying the expansion on the expand parameter passed in to this resources.
     * For instance, to expand the "changelog" for all the issues on the search result,
     * it is neccesary to specify "changelog" as one of the values to expand.
     *
     * @param string $JQL a JQL query string
     * @param int $startAt the index of the first issue to return (0-based)
     * @param int $maxResult the maximum number of issues to return (defaults to 50)
     * @param bool $validateQuery whether to validate the JQL query
     * @param string $fields the list of fields to return for each issue. By default, all navigable fields are returned.
     * @param string $expand A comma-separated list of the parameters to expand.
     * @return array
     */
    public function search($JQL, $startAt = 0, $maxResult = 50, $validateQuery = false,  $fields = '*navigable', $expand = '')
    {
        $options = [
            'query' => [
                'jql' => $JQL,
                'startAt' => $startAt,
                'maxResults' => $maxResult,
                'validateQuery' => $validateQuery,
                'fields' => $fields,
                'expand' => $expand,
            ]
        ];
        return $this->sendRequest(Http::METHOD_GET, $this->getApiUrn(), $options);
    }

    /**
     * Get issues by keys
     * @param array $keys issue keys
     * @param string $fields the list of fields to return for each issue. By default, all navigable fields are returned.
     * @return array
     */
    public function issuesByKeys(array $keys, $fields = '*navigable')
    {
        return $this->search(
            sprintf('key IN (%s)', implode(',', $keys)),
            0,
            count($keys),
            false,
            $fields
        );
    }
}
