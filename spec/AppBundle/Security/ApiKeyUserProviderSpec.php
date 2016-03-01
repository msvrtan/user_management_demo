<?php

namespace spec\AppBundle\Security;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiKeyUserProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Security\ApiKeyUserProvider');
    }

    public function it_will_return_username_based_on_api_key()
    {
        $this->getUsernameForApiKey('123')->shouldReturn('admin');
        $this->getUsernameForApiKey('987')->shouldReturn('visitor');
    }

    public function it_will_return_false_for_unrecognized_api_key()
    {
        $this->getUsernameForApiKey('unrecognized-api-key')->shouldReturn(false);
    }

    public function it_will_load_admin_user_with_admin_privileges()
    {
        $result = $this->loadUserByUsername('admin');

        $result->getRoles()->shouldReturn(['ROLE_ADMIN']);
    }

    public function it_will_load_visitor_user_with_user_privileges()
    {
        $result = $this->loadUserByUsername('visitor');

        $result->getRoles()->shouldReturn(['ROLE_USER']);
    }

    public function it_will_throw_exception_if_trying_to_load_by_unknown_user()
    {
        $this->shouldThrow(new \Exception('Cant find user'))->duringLoadUserByUsername(false);
        $this->shouldThrow(new \Exception('Cant find user'))->duringLoadUserByUsername('unknownusername');
    }
}
