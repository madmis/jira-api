<?php

namespace madmis\JiraApi\Client;

use GuzzleHttp\Client;
use madmis\JiraApi\Authentication\AuthenticationInterface;
use madmis\JiraApi\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient extends Client implements ClientInterface
{
    /**
     * @var string
     */
    private $apiUri;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @param AuthenticationInterface $authentication
     * @param string $apiUri
     */
    public function __construct(AuthenticationInterface $authentication, $apiUri)
    {
        $this->authentication = $authentication;
        $this->apiUri = $apiUri;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        try {
            /** @var ResponseInterface $response */
            $response = parent::send($request, $options);
        } catch (\GuzzleHttp\Exception\GuzzleException $ex) {
            throw new ClientException($ex->getMessage(), $ex->getCode(), $ex);
        }

        return $response;
    }

    /**
     * Get jira api uri
     * @return string
     */
    public function getApiUri()
    {
        return $this->apiUri;
    }

    /**
     * @return AuthenticationInterface
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }
}