<?php

namespace Company\UserBundle\Behat;

use Resources\Behat\DomainContext;

/**
 * Class UserManagementDomainContext.
 */
class UserManagementDomainContext extends DomainContext
{
    private $result;

    /**
     * @Given I am admin user
     */
    public function iAmAdminUser()
    {
        //Domain doesnt care if you are admin or not for now ...
    }

    /**
     * @Given there is a user with name :name
     * @When  I create user with name :name
     *
     * @param $name
     */
    public function iCreateUserWithName($name)
    {
        $service = $this->getContainer()->get('company_user.facade.simple_user');

        $service->createUser($name);
    }

    /**
     * @Given there is a group with name :name
     * @When  I create group with name :name
     *
     * @param $name
     */
    public function iCreateGroupWithName($name)
    {
        $service = $this->getContainer()->get('company_user.facade.simple_group');

        $service->createGroup($name);
    }

    /**
     * @Given there is a user with name :name in :groupName group
     *
     * @param $name
     * @param $groupName
     */
    public function thereIsUserWithNameInGroup($name, $groupName)
    {
        $service = $this->getContainer()->get('company_user.facade.simple_user');

        $user         = $service->createUser($name);
        $serviceGroup = $this->getContainer()->get('company_user.facade.simple_group');

        $group = $serviceGroup->createGroup($groupName);

        return $serviceGroup->addUserToGroup($group, $user);
    }

    /**
     * @When I delete user with id :id
     *
     * @param $id
     */
    public function iDeleteUserWithId($id)
    {
        $service = $this->getContainer()->get('company_user.facade.simple_user');

        $this->result = $service->deleteUser($id);
    }

    /**
     * @When I delete group with id :id
     *
     * @param $id
     */
    public function iDeleteGroupWithId($id)
    {
        $service = $this->getContainer()->get('company_user.facade.simple_group');

        $this->result = $service->deleteGroup($id);
    }

    /**
     * @When I add :name to group :groupName
     *
     * @param $name
     * @param $groupName
     */
    public function iAddToGroup($name, $groupName)
    {
        $user         = $this->getSimpleUserRepo()->findOneByName($name);
        $group        = $this->getSimpleGroupRepo()->findOneByGroupName($groupName);
        $serviceGroup = $this->getContainer()->get('company_user.facade.simple_group');

        $this->result = $serviceGroup->addUserToGroup($group, $user);
    }

    /**
     * @When I remove :name from group :groupName
     *
     * @param $name
     * @param $groupName
     */
    public function iRemoveFromGroup($name, $groupName)
    {
        $user         = $this->getSimpleUserRepo()->findOneByName($name);
        $group        = $this->getSimpleGroupRepo()->findOneByGroupName($groupName);
        $serviceGroup = $this->getContainer()->get('company_user.facade.simple_group');

        $this->result = $serviceGroup->removeUserFromGroup($group, $user);
    }

    /**
     * @Then there should be user with name :name
     *
     * @param $name
     */
    public function thereShouldBeUserWithName($name)
    {
        $user = $this->getSimpleUserRepo()->findOneByName($name);

        \PHPUnit_Framework_Assert::assertSame($name, $user->getName());
    }

    /**
     * @Then there should be group with name :name
     *
     * @param $name
     */
    public function thereShouldBeGroupWithName($name)
    {
        $group = $this->getSimpleGroupRepo()->findOneByGroupName($name);

        \PHPUnit_Framework_Assert::assertSame($name, $group->getGroupName());
    }

    /**
     * @Then there should be true response
     */
    public function thereShouldBeTrueResponse()
    {
        \PHPUnit_Framework_Assert::assertTrue($this->result);
    }

    /**
     * @Then there should be false response
     */
    public function thereShouldBeFalseResponse()
    {
        \PHPUnit_Framework_Assert::assertFalse($this->result);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getSimpleUserRepo()
    {
        return $this->getEntityManager()->getRepository('CompanyUserBundle:SimpleUser');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getSimpleGroupRepo()
    {
        return $this->getEntityManager()->getRepository('CompanyUserBundle:SimpleGroup');
    }
}
