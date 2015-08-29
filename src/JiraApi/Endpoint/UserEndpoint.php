<?php

namespace madmis\JiraApi\Endpoint;

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
        return $this->getUser(['username' => $username], $mapping);
    }

    /**
     * @param string $userKey
     * @param bool $mapping mapping response items to objects
     * @return array|User[]
     */
    public function getUserByKey($userKey, $mapping = false)
    {
        return $this->getUser(['key' => $userKey], $mapping);
    }

    /**
     * @param array $params
     * @param bool $mapping
     * @return array|User[]
     */
    private function getUser(array $params, $mapping = false)
    {
        $options = ['query' => $params];
        $response = $this->sendRequest(Http::METHOD_GET, $this->getApiUri(), $options);

        if ($mapping) {
            $response = $this->deserializeItem($response, $this->userClass);
        }

        return $response;
    }
}