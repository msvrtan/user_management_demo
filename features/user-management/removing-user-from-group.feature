@user_management @api
Feature: Removing user from group
  In order to have users in groups
  As admin
  I need to remove users from groups

  Scenario: Remove user from group that it's already in
    Given I am admin user
    And there is a user with name "joe" in "gang" group
    When I remove "joe" from group "gang"
    Then there should be true response

  Scenario: Remove user from group that it's not in
    Given I am admin user
    And there is a user with name "joe"
    And there is a group with name "gang"
    When I remove "joe" from group "gang"
    Then there should be false response
