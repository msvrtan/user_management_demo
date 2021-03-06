<?php

namespace AppBundle\Behat;

use GuzzleHttp\Client;
use Resources\Behat\DomainContext;

/**
 * Class SecurityContext.
 */
class SecurityContext extends DomainContext
{
    protected $token;
    protected $response;

    /**
     * @Given I am admin user
     */
    public function iAmAdminUser()
    {
        $this->token = '123';
    }

    /**
     * @Given I am regular user
     */
    public function iAmRegularUser()
    {
        $this->token = '987';
    }

    /**
     * @Given I am unauthenticated user
     */
    public function iAmUnauthenticatedUser()
    {
        $this->token = false;
    }

    /**
     * @When I access :url
     *
     * @param $url
     */
    public function iAccess($url)
    {
        $client = $this->getClient();

        if ($this->token) {
            $url .= '?apikey='.$this->token;
        }

        try {
            $this->response = $client->request('GET', $url);
        } catch (\Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Then response body should contain :message
     *
     * @param $message
     */
    public function responseBodyShouldContain($message)
    {
        \PHPUnit_Framework_Assert::assertContains($message, (string) $this->response->getBody());
    }

    /**
     * @Then the response status code should be :code
     *
     * @param $code
     */
    public function theResponseStatusCodeShouldBe($code)
    {
        \PHPUnit_Framework_Assert::assertSame((string) $code, (string) $this->response->getStatusCode());
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        $baseUri = $this->getContainer()->getParameter('test_base_uri');

        return new Client(['base_uri' => $baseUri, 'verify' => false]);
    }
}
