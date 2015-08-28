<?php

namespace madmis\JiraApi\Endpoint;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use HttpLib\Http;
use madmis\JiraApi\Model\User;

/**
 * Class UserEndpoint
 * @package madmis\JiraApi\Endpoint
 */
class UserEndpoint extends AbstractEndpoint
{
    protected $baseUrn = '/user';

    protected $userClass = 'madmis\JiraApi\Model\User';

    /**
     * @param string $username
     * @param bool $mapping mapping response items to objects
     * @return array|User[]
     */
    public function getUserByName($username, $mapping = false)
    {
        $headers = $this->client->getAuthentication()->getHeaders();
        $request = new Request(Http::METHOD_GET, $this->getApiUri(), $headers);

        $response = $this->processResponse(
            $this->client->send($request, ['query' => ['username' => $username]])
        );

        if ($mapping) {
            $response = $this->deserializeItem($response, $this->userClass);
        }

        return $response;
    }

    /**
     * @param string $userKey
     * @param bool $mapping mapping response items to objects
     * @return array|User[]
     */
    public function getUserByKey($userKey, $mapping = false)
    {
        $headers = $this->client->getAuthentication()->getHeaders();
        $request = new Request(Http::METHOD_GET, $this->getApiUri(), $headers);

        $response = $this->processResponse(
            $this->client->send($request, ['query' => ['key' => $userKey]])
        );

        if ($mapping) {
            $response = $this->deserializeItem($response, $this->userClass);
        }

        return $response;
    }
}