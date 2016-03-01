@user_management @api
Feature: Creating used
  In order to have users
  As admin
  I need to create users

  Scenario: Create user
    Given I am admin user
    When I create user with name "joe"
    Then there should be user with name "joe"
