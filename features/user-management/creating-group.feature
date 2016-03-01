@user_management @api
Feature: Creating group
  In order to group users depending on their roles
  As admin
  I need to create group

  Scenario: Create group
    Given I am admin user
    When I create group with name "cool-crowd"
    Then there should be group with name "cool-crowd"
