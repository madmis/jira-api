<?php

namespace madmis\JiraApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use madmis\JiraApi\Authentication\AuthenticationInterface;
use madmis\JiraApi\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleClient
 * @package madmis\JiraApi\Client
 */
class GuzzleClient extends Client implements ClientInterface
{
    /**
     * @var string
     */
    private $jiraApiUrn;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @var array
     */
    private $options;

    /**
     * @var RequestInterface
     */
    private $lastRequest;

    /**
     * @var ResponseInterface
     */
    private $lastResponse;

    /**
     * @param string $jiraBaseUri example: http://localhost:8080
     * @param string $jiraApiUrn example: /rest/api/2
     * @param array $options extra parameters
     */
    public function __construct($jiraBaseUri, $jiraApiUrn, array $options)
    {
        parent::__construct([
            'base_uri' => trim($jiraBaseUri, '/')
        ]);
        $this->jiraApiUrn = $jiraApiUrn;
        $this->options = $options;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     * @throws ClientException
     */
    public function send(RequestInterface $request, array $options = [])
    {
        try {
            /** @var ResponseInterface $response */

            $response = parent::send($request, $options);
        } catch (RequestException $ex) {
            $this->lastRequest = $ex->getRequest();
            $this->lastResponse = $ex->getResponse();
            $exception = new ClientException($ex, $ex->getRequest(), $ex->getResponse());
            throw $exception;
        }
        $this->lastRequest = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * Get jira api urn (example: /rest/api/2)
     * @return string
     */
    public function getApiUrn()
    {
        return $this->jiraApiUrn;
    }

    /**
     * @return AuthenticationInterface|null
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * @param AuthenticationInterface $authentication
     */
    public function setAuthentication(AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param string $name
     * @return mixed null if option doesn't exists
     */
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * @return RequestInterface
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }
}
