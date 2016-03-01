<?php

namespace Company\UserBundle\Behat;

use Company\UserBundle\Entity\SimpleUser;
use GuzzleHttp\Client;
use Resources\Behat\DomainContext;

class UserManagementDomainContext extends DomainContext
{
    /**
     * @Given I am admin user
     */
    public function iAmAdminUser()
    {
        //Domain doesnt care if you are admin or not for now ...
    }

    /**
     * @When I create user with name :name
     */
    public function iCreateUserWithName($name)
    {
        $service = $this->getContainer()->get('company_user.facade.simple_user');

        $service->createUser($name);
    }

    /**
     * @Then there should be user with name :name
     */
    public function thereShouldBeUserWithName($name)
    {
        $user = $this->getSimpleUserRepo()->findOneByName($name);

        \PHPUnit_Framework_Assert::assertSame($name, $user->getName());
    }

    private function getSimpleUserRepo()
    {
        return $this->getEntityManager()->getRepository('CompanyUserBundle:SimpleUser');
    }
}
