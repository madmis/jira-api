# JIRA REST API PHP Client

[![Build Status](https://secure.travis-ci.org/madmis/jira-api.png)](http://travis-ci.org/madmis/jira-api)

JIRA provides REST APIs that you can use to interact with JIRA programmatically.
This API client will help you interact with JIRA by REST API. 
 

# License

MIT License

# JIRA REST API Reference

https://docs.atlassian.com/jira/REST/latest/

# Usage

composer.json

```
composer require madmis/jira-api 1.0.*
```

````php

<?php
$auth = new madmis\JiraApi\Authentication\Basic('email@test.com', 'password');
$api = new madmis\JiraApi\JiraApi('http://localhost:8080/', $auth);

$projectList = $api->project()->getProjects();

$project = $api->project()->getProject('MFTP');

$issue = $api->issue()->getIssue('MFTP-4');

// Result
array [
  'expand' => "renderedFields,names,schema,transitions,operations,editmeta,changelog"
  'id' => "10003"
  'self' => "http://localhost:8080/rest/api/2/issue/10003"
  'key' => "MFTP-4"
  'fields' => { ... }
]

````

###Mapping
````php
$issue = $api->issue()->getIssue('MFTP-4', '*all', '', true);

// Result
class madmis\JiraApi\Model\Issue {
    protected $self => "http://localhost:8080/rest/api/2/issue/10003"
    protected $id => 10003
    protected $key => "MFTP-4"
    protected $updated => class DateTime
    protected $issueType => class madmis\JiraApi\Model\IssueType
    protected $project => class madmis\JiraApi\Model\Project
    protected $creator => class madmis\JiraApi\Model\User
    protected $reporter => class madmis\JiraApi\Model\User
    protected $assignee => class madmis\JiraApi\Model\User
    protected $status => class madmis\JiraApi\Model\IssueStatus
  }

````
###Error handling
When send request by client - all erros wrapped to custom exception **madmis\JiraApi\Exception\ClientException**  

````php
class madmis\JiraApi\Exception\ClientException {
  private $request => class GuzzleHttp\Psr7\Request
  private $response => NULL
  protected $message => "cURL error 7: Failed to connect to 127.0.0.1 port 8080: Connection refused (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)"
  ...
}
````

**ClientException** contain original **request object** and **response object** if response available
 
````php
class madmis\JiraApi\Exception\ClientException {
  private $request => class GuzzleHttp\Psr7\Request 
  private $response => class GuzzleHttp\Psr7\Response {
    private $reasonPhrase => "Unauthorized"
    private $statusCode => 401
    ...
  }
  protected $message => "Client error: 401"
  ...  
}
````

So, to handle errors use try/catch

````php
try {
    $issue = $api->issue()->getIssue('MFTP-4');
} catch (madmis\JiraApi\Exception\ClientException $ex) {
    // any actions (log error, send email, ...) 
}
````