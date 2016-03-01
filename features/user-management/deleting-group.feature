@user_management @api
Feature: Deleting group
  In order to have list of relevant groups
  As admin
  I need to delete groups

  Scenario: Delete group
    Given I am admin user
    And there is a group with name "gang"
    When I delete group with id "1"
    Then there should be true response

  Scenario: Delete group that doesnt exist
    Given I am admin user
    When I delete group with id "2"
    Then there should be false response

  Scenario: Delete group that has users is not allowed
    Given I am admin user
    And there is a user with name "joe" in "gang" group
    When I delete group with id "1"
    Then there should be false response
