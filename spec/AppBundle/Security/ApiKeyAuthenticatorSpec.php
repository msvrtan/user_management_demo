<?php

namespace spec\AppBundle\Security;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiKeyAuthenticatorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Security\ApiKeyAuthenticator');
    }
}
