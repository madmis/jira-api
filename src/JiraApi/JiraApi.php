<?php

namespace madmis\JiraApi;

use madmis\JiraApi\Authentication\AuthenticationInterface;

class JiraApi
{
    /**
     * @var string
     */
    private $jiraBaseUri;

    /** @var AuthenticationInterface */
    protected $authentication;

    /**
     * @param string $jiraBaseUri
     * @param AuthenticationInterface $authentication
     */
    public function __construct($jiraBaseUri, AuthenticationInterface $authentication)
    {
        $this->jiraBaseUri = trim($jiraBaseUri, '/');
        $this->authentication = $authentication;
    }
}
