<?php

namespace madmis\JiraApi;

use Doctrine\Common\Annotations\AnnotationRegistry;
use madmis\JiraApi\Authentication\AuthenticationInterface;
use madmis\JiraApi\Client\ClientInterface;
use madmis\JiraApi\Client\GuzzleClient;
use madmis\JiraApi\Endpoint\EndpointFactory;
use madmis\JiraApi\Endpoint\IssueEndpoint;
use madmis\JiraApi\Endpoint\ProjectEndpoint;
use madmis\JiraApi\Endpoint\UserEndpoint;

/**
 * Class JiraApi
 * @package madmis\JiraApi
 */
class JiraApi
{
    /**
     * @var string
     */
    private $jiraBaseUrl;

    /**
     * @var string
     */
    private $jiraApiUrn = '/rest/api/2';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var EndpointFactory
     */
    private $endpointFactory;

    /**
     * @param string $jiraBaseUrl
     * @param AuthenticationInterface $authentication
     */
    public function __construct($jiraBaseUrl, AuthenticationInterface $authentication)
    {
        $this->jiraBaseUrl = trim($jiraBaseUrl, '/');
        $this->client = new GuzzleClient($authentication, $this->getApiUri());

        $this->endpointFactory = new EndpointFactory();
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    private function getApiUri()
    {
        return sprintf('%s%s', $this->jiraBaseUrl, $this->jiraApiUrn);
    }

    /**
     * @return IssueEndpoint
     */
    public function issue()
    {
        return $this->endpointFactory->getEndpoint('issue', $this->client);
    }

    /**
     * @return ProjectEndpoint
     */
    public function project()
    {
        return $this->endpointFactory->getEndpoint('project', $this->client);
    }

    /**
     * @return UserEndpoint
     */
    public function user()
    {
        return $this->endpointFactory->getEndpoint('user', $this->client);
    }
}

AnnotationRegistry::registerLoader('class_exists');