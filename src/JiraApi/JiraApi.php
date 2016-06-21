<?php

namespace madmis\JiraApi;

use Doctrine\Common\Annotations\AnnotationRegistry;
use madmis\JiraApi\Authentication\AuthenticationInterface;
use madmis\JiraApi\Client\ClientInterface;
use madmis\JiraApi\Client\GuzzleClient;
use madmis\JiraApi\Endpoint\Agile\BoardEndpoint;
use madmis\JiraApi\Endpoint\AttachmentEndpoint;
use madmis\JiraApi\Endpoint\EndpointFactory;
use madmis\JiraApi\Endpoint\IssueEndpoint;
use madmis\JiraApi\Endpoint\IssueTypeEndpoint;
use madmis\JiraApi\Endpoint\ProjectEndpoint;
use madmis\JiraApi\Endpoint\SearchEndpoint;
use madmis\JiraApi\Endpoint\TempoEndpoint;
use madmis\JiraApi\Endpoint\UserEndpoint;
use madmis\JiraApi\Endpoint\VersionEndpoint;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class JiraApi
 * @package madmis\JiraApi
 */
class JiraApi
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var EndpointFactory
     */
    private $endpointFactory;

    /**
     * @param string $jiraBaseUri example: http://localhost:8080
     * @param string $jiraApiUrn example: /rest/api/2
     * @param array $options extra parameters
     * @throws AccessException
     */
    public function __construct($jiraBaseUri, $jiraApiUrn, array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->client = new GuzzleClient($jiraBaseUri, $jiraApiUrn, $resolver->resolve($options));
        $this->endpointFactory = new EndpointFactory();
    }

    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'tempo_timesheets_urn' => '/rest/tempo-timesheets/3',
        ]);
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param AuthenticationInterface $authentication
     */
    public function setAuthentication(AuthenticationInterface $authentication)
    {
        $this->client->setAuthentication($authentication);
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

    /**
     * @return IssueEndpoint
     */
    public function issue()
    {
        return $this->endpointFactory->getEndpoint('issue', $this->client);
    }

    /**
     * @return AttachmentEndpoint
     */
    public function attachment()
    {
        return $this->endpointFactory->getEndpoint('attachment', $this->client);
    }

    /**
     * @return IssueTypeEndpoint
     */
    public function issueType()
    {
        return $this->endpointFactory->getEndpoint('issueType', $this->client);
    }

    /**
     * @return SearchEndpoint
     */
    public function search()
    {
        return $this->endpointFactory->getEndpoint('search', $this->client);
    }

    /**
     * @return TempoEndpoint
     */
    public function tempo()
    {
        return $this->endpointFactory->getEndpoint('tempo', $this->client);
    }

    /**
     * @return BoardEndpoint
     */
    public function aglieBoard()
    {
        return $this->endpointFactory->getEndpoint(BoardEndpoint::class, $this->client);
    }

    /**
     * @return VersionEndpoint
     */
    public function version()
    {
        return $this->endpointFactory->getEndpoint(VersionEndpoint::class, $this->client);
    }
}

AnnotationRegistry::registerLoader('class_exists');
