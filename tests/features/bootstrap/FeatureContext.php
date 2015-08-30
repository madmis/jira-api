<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use madmis\JiraApi\Authentication\Basic;
use madmis\JiraApi\JiraApi;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var JiraApi
     */
    private $api;

    /**
     * @var mixed
     */
    private $responseContent;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($jiraBaseUri, $jiraApiUrn, $jiraUsername, $jiraUserPass, array $options = [])
    {
        $this->api = new JiraApi($jiraBaseUri, $jiraApiUrn);
        $this->api->setAuthentication(new Basic($jiraUsername, $jiraUserPass));
    }

    /**
     * @When I get project by key :key
     *
     * @param string $key
     */
    public function iGetProjectByKey($key)
    {
        $this->responseContent = $this->api->project()->getProject($key);
    }

    /**
     * @When I get issue types
     */
    public function iGetIssueTypes()
    {
        $this->responseContent = $this->api->issueType()->getIssueTypes();
    }

    /**
     * @When I create issue with :projectKey :summary :issueTypeId
     *
     * @param $projectKey
     * @param $summary
     * @param $issueTypeId
     */
    public function iCreateIssue($projectKey, $summary, $issueTypeId)
    {
        $this->responseContent = $this->api->issue()->createIssue('PROJ', 'summary', 3);
    }

    /**
     * @Then response status code is :code
     *
     * @param int $code
     */
    public function responseStatusCodeIs($code)
    {
        if (!$this->api->getClient()->getLastResponse()) {
            PHPUnit_Framework_Assert::fail();
        }

        $statusCode = $this->api->getClient()->getLastResponse()->getStatusCode();

        PHPUnit_Framework_Assert::assertEquals($code, $statusCode);
    }

    /**
     * @Then response should contain :key with :value
     *
     * @param string $key
     * @param string|int|bool $value
     */
    public function responseShouldContain($key, $value)
    {
        PHPUnit_Framework_Assert::assertArrayHasKey($key, $this->responseContent);
        PHPUnit_Framework_Assert::assertEquals($value, $this->responseContent[$key]);
    }

    /**
     * @Then response is not empty
     */
    public function responseIsNotEmpty()
    {
        PHPUnit_Framework_Assert::assertNotEmpty($this->responseContent);
    }
}
