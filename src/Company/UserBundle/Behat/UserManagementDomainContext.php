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
}
