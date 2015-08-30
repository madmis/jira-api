Feature: Project

  Scenario: Get project
    When I get project by key 'PROJ'
    Then response status code is 200
    And response should contain 'key' with 'PROJ'
