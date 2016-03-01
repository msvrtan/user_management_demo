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
}
