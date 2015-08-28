<?php

use madmis\JiraApi\Authentication\Basic;
use madmis\JiraApi\JiraApi;

class IssueEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testGetApiUri()
    {
        $api = new JiraApi(
            'http://localhost:8080',
            new Basic('user', 'password')
        );

        $this->assertEquals($api->issue()->getApiUri(), 'http://localhost:8080/rest/api/2/issue/');
    }
}