@security
Feature: Check api security
  In order to secure user management API
  As a system
  I need to verify only admin's can access it

  Scenario: Check that admin can access API
    Given I am admin user
    When I access "admin/foo"
    Then response body should contain "Hello World!"

  Scenario: Check that user gets 403
    Given I am regular user
    When I access "admin/foo"
    Then the response status code should be 403

  Scenario: Check that unauthenticated user gets 500
    Given I am unauthenticated user
    When I access "admin/foo"
    Then the response status code should be 500

