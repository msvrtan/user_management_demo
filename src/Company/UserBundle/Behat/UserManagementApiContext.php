<?php

namespace Company\UserBundle\Behat;

use AppBundle\Behat\SecurityContext;
use Company\UserBundle\Repository\SimpleUserRepository;
use GuzzleHttp\Client;
use Resources\Behat\DomainContext;

class UserManagementApiContext extends SecurityContext
{
    /**
     * @When I create user with name :name
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
     * @Then there should be user with name :name
     */
    public function thereShouldBeUserWithName($name)
    {
        $result = json_decode($this->response->getBody(), true);

        \PHPUnit_Framework_Assert::assertSame($name, $result['name']);
        \PHPUnit_Framework_Assert::assertArrayHasKey('id', $result);
    }
}
