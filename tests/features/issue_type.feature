Feature: Issue Type

  Scenario: Get issue types
    When I get issue types
    Then response status code is 200
    And response is not empty
