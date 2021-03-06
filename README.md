# JIRA REST API PHP Client

[![SensioLabsInsight][sensiolabs-insight-image]][sensiolabs-insight-link]
[![Build Status][testing-image]][testing-link]
[![Coverage Status][coverage-image]][coverage-link]
[![Latest Stable Version][stable-image]][package-link]
[![Total Downloads][downloads-image]][package-link]
[![License][license-image]][license-link]

JIRA provides REST APIs that you can use to interact with JIRA programmatically.
This API client will help you interact with JIRA by REST API. 
 

# License

MIT License

# JIRA REST API Reference

https://docs.atlassian.com/jira/REST/latest/

# Contributing
To create new endpoint - [create issue](https://github.com/madmis/jira-api/issues/new) or [create pull request](https://github.com/madmis/jira-api/compare)

# Install
    
    composer require madmis/jira-api 1.0.*

# Usage
```php
$api = new madmis\JiraApi\JiraApi('http://localhost:8080/', '/rest/api/2');

$auth = new madmis\JiraApi\Authentication\Basic('email@test.com', 'password');
$api->setAuthentication($auth);

$projectList = $api->project()->getProjects();

$project = $api->project()->getProject('MFTP');

$issue = $api->issue()->getIssue('MFTP-4');

// Issue result
array [
  'expand' => "renderedFields,names,schema,transitions,operations,editmeta,changelog"
  'id' => "10003"
  'self' => "http://localhost:8080/rest/api/2/issue/10003"
  'key' => "MFTP-4"
  'fields' => { ... }
]
```

###Create Issue

```php
$api = new madmis\JiraApi\JiraApi('http://localhost:8080/', '/rest/api/2');

$auth = new madmis\JiraApi\Authentication\Basic('email@test.com', 'password');
$api->setAuthentication($auth);

// without mapping
$result = $api->issue()->createIssue('PROJ', 'summary', 1, ['description' => 'description']);

// Issue result
array [
  'id' => "10105"
  'key' => "PROJ-9"
  'self' => "http://127.0.0.1:8080/rest/api/2/issue/10105"
]

// with mapping
$result = $api->issue()->createIssue('PROJ', 'summary', 1, ['description' => 'description'], true);

// Issue result
class madmis\JiraApi\Model\Issue {
  protected $self => "http://127.0.0.1:8080/rest/api/2/issue/10104"
  protected $id => 10104
  protected $key => "PROJ-8"
  protected $labels => []
  protected $description => NULL
  protected $summary => NULL
  protected $updated => NULL
  protected $created => NULL
  protected $issueType => NULL
  protected $project => NULL
  protected $creator => NULL
  protected $reporter => NULL
  protected $assignee => NULL
  protected $status => NULL
}
```

###Tempo worklog (Tempo timesheets)

```php
// This is default options, it is not required to set them.
// Set them only it Tempo REST API has another urn
$options = [
    'tempo_timesheets_urn' => '/rest/tempo-timesheets/3',
];
$api = new madmis\JiraApi\JiraApi('http://localhost:8080/', '/rest/api/2', $options);

$auth = new madmis\JiraApi\Authentication\Basic('email@test.com', 'password');
$api->setAuthentication($auth);

$issue = $api->issue()->getIssue('MFTP-4');

// Tempo worklog result
array [
  array [
    'timeSpentSeconds' => 28800
    'dateStarted' => "2015-08-29T00:00:00.000"
    'comment' => "2323"
    'self' => "http://127.0.0.1:8080/rest/tempo-timesheets/3/worklogs/10000"
    'id' => 10000
    'author' => [ ... ]
    'issue' => [ ... ]
    'worklogAttributes' => [ ... ]
  ]
]
```

###Mapping

```php
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
```

###Error handling
Each client request errors wrapped to custom exception **madmis\JiraApi\Exception\ClientException**  

```php
class madmis\JiraApi\Exception\ClientException {
  private $request => class GuzzleHttp\Psr7\Request
  private $response => NULL
  protected $message => "cURL error 7: Failed to connect to 127.0.0.1 port 8080: Connection refused (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)"
  ...
}
```

**ClientException** contains original **request object** and **response object** if response available

```php
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
```

So, to handle errors use try/catch

```php
try {
    $issue = $api->issue()->getIssue('MFTP-4');
} catch (madmis\JiraApi\Exception\ClientException $ex) {
    // any actions (log error, send email, ...) 
}
```

# Running the tests
To run the tests, you'll need to install [phpunit](https://phpunit.de/) and [behat](https://github.com/Behat/Behat). 
Easiest way to do this is through composer.

    composer install

### Running Unit tests

    php vendor/bin/phpunit -c phpunit.xml.dist

### Running Behat tests

To run Behat test you'll need to install [Jira](https://www.atlassian.com/software/jira/download).
Create config file from example `behat.yml.dist` 

    php vendor/bin/behat -c behat.yml



[testing-link]: https://travis-ci.org/madmis/jira-api
[testing-image]: https://travis-ci.org/madmis/jira-api.svg?branch=master

[sensiolabs-insight-link]: https://insight.sensiolabs.com/projects/7332bbe0-7ecf-4228-afdb-e599c60c9aa0
[sensiolabs-insight-image]: https://insight.sensiolabs.com/projects/7332bbe0-7ecf-4228-afdb-e599c60c9aa0/mini.png

[package-link]: https://packagist.org/packages/madmis/jira-api
[downloads-image]: https://poser.pugx.org/madmis/jira-api/downloads
[stable-image]: https://poser.pugx.org/madmis/jira-api/v/stable
[license-image]: https://poser.pugx.org/madmis/jira-api/license
[license-link]: https://packagist.org/packages/madmis/jira-api

[coverage-link]: https://coveralls.io/github/madmis/jira-api?branch=master
[coverage-image]: https://coveralls.io/repos/github/madmis/jira-api/badge.svg?branch=master
