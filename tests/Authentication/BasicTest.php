<?php

use madmis\JiraApi\Authentication\Basic;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicAuthentication()
    {
        $username = 'user';
        $password = 'pass';
        $credential = base64_encode("{$username}:{$password}");

        $auth = new Basic($username, $password);

        $this->assertEquals($username, $auth->getUsername());
        $this->assertEquals($password, $auth->getPassword());
        $this->assertEquals($credential, $auth->getCredential());
        $this->assertEquals(['Authorization' => 'Basic ' . $credential], $auth->getHeaders());
    }
}