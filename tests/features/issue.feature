Feature: Issue

  Scenario: Create Issue
    When I create issue with 'PROJ' 'summary' 1
    Then response status code is 200
    And response is not empty

