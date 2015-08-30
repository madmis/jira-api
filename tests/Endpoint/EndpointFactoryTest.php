<?php

use madmis\JiraApi\Client\GuzzleClient;
use madmis\JiraApi\Endpoint\EndpointFactory;

class EndpointFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEndpoint()
    {
        $factory = new EndpointFactory();
        $client = new GuzzleClient('', '', []);

        $issue = $factory->getEndpoint('issue', $client);

        $this->assertInstanceOf('madmis\JiraApi\Endpoint\IssueEndpoint', $issue);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetEndpointError()
    {
        $factory = new EndpointFactory();
        $client = new GuzzleClient('', '', []);

        $factory->getEndpoint('test', $client);
    }
}