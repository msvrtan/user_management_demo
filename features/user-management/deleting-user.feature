@user_management @api
Feature: Deleting user
  In order to have active list of users
  As admin
  I need to delete users

  Scenario: Delete user
    Given I am admin user
    And there is a user with name "joe"
    When I delete user with id "1"
    Then there should be true response

  Scenario: Delete user that doesnt exist
    Given I am admin user
    When I delete user with id "2"
    Then there should be false response
