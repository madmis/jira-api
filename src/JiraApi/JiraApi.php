<?php

namespace madmis\JiraApi;

use madmis\JiraApi\Authentication\AuthenticationInterface;
use madmis\JiraApi\Client\ClientInterface;
use madmis\JiraApi\Client\GuzzleClient;

class JiraApi
{
    /**
     * @var string
     */
    private $jiraBaseUri;

    /** @var AuthenticationInterface */
    protected $authentication;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param string $jiraBaseUri
     * @param AuthenticationInterface $authentication
     */
    public function __construct($jiraBaseUri, AuthenticationInterface $authentication)
    {
        $this->jiraBaseUri = trim($jiraBaseUri, '/');
        $this->authentication = $authentication;

        $this->client = new GuzzleClient();
    }
}
