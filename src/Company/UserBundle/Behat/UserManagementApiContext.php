<?php

namespace Company\UserBundle\Behat;

use AppBundle\Behat\SecurityContext;

/**
 * Class UserManagementApiContext.
 */
class UserManagementApiContext extends SecurityContext
{
    /**
     * @Given there is a user with name :name
     * @When  I create user with name :name
     *
     * @param $name
     */
    public function iCreateUserWithName($name)
    {
        $url    = 'admin/api/v1/user/create';
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        $data = ['json' => ['name' => $name]];

        try {
            $this->response = $client->post($url, $data);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Given there is a group with name :name
     * @When  I create group with name :name
     *
     * @param $name
     */
    public function iCreateGroupWithName($name)
    {
        $url    = 'admin/api/v1/group/create';
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        $data = ['json' => ['groupName' => $name]];

        try {
            $this->response = $client->post($url, $data);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
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
        $url    = 'admin/api/v1/user/'.$id;
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        try {
            $this->response = $client->delete($url);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @When I delete group with id :id
     *
     * @param $id
     */
    public function iDeleteGroupWithId($id)
    {
        $url    = 'admin/api/v1/group/'.$id;
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        try {
            $this->response = $client->delete($url);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @When I add :name to group :groupName
     *
     * @param $name
     * @param $groupName
     */
    public function iAddToGroup($name, $groupName)
    {
        $user  = $this->getSimpleUserRepo()->findOneByName($name);
        $group = $this->getSimpleGroupRepo()->findOneByGroupName($groupName);

        $url    = 'admin/api/v1/group/'.$group->getId().'/add-user/'.$user->getId();
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        try {
            $this->response = $client->post($url);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @When I remove :name from group :groupName
     *
     * @param $name
     * @param $groupName
     */
    public function iRemoveFromGroup($name, $groupName)
    {
        $user  = $this->getSimpleUserRepo()->findOneByName($name);
        $group = $this->getSimpleGroupRepo()->findOneByGroupName($groupName);

        $url    = 'admin/api/v1/group/'.$group->getId().'/remove-user/'.$user->getId();
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        try {
            $this->response = $client->post($url);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Then there should be user with name :name
     *
     * @param $name
     */
    public function thereShouldBeUserWithName($name)
    {
        $result = json_decode($this->response->getBody(), true);

        \PHPUnit_Framework_Assert::assertSame($name, $result['name']);
        \PHPUnit_Framework_Assert::assertArrayHasKey('id', $result);
    }

    /**
     * @Then there should be group with name :name
     *
     * @param $name
     */
    public function thereShouldBeGroupWithName($name)
    {
        $result = json_decode($this->response->getBody(), true);

        \PHPUnit_Framework_Assert::assertSame($name, $result['groupName']);
        \PHPUnit_Framework_Assert::assertArrayHasKey('id', $result);
    }

    /**
     * @Then there should be true response
     */
    public function thereShouldBeTrueResponse()
    {
        $result = json_decode($this->response->getBody(), true);
        \PHPUnit_Framework_Assert::assertTrue($result);
    }

    /**
     * @Then there should be false response
     */
    public function thereShouldBeFalseResponse()
    {
        $result = json_decode($this->response->getBody(), true);
        \PHPUnit_Framework_Assert::assertFalse($result);
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
