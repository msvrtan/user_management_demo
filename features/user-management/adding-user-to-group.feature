@user_management @api
Feature: Adding user to group
  In order to have users in groups
  As admin
  I need to add users into groups

  Scenario: Add user to group
    Given I am admin user
    And there is a user with name "joe"
    And there is a group with name "gang"
    When I add "joe" to group "gang"
    Then there should be true response

  Scenario: Add user to group that it's already in
    Given I am admin user
    And there is a user with name "joe" in "gang" group
    When I add "joe" to group "gang"
    Then there should be false response
