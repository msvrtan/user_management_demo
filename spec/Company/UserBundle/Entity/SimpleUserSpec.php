<?php

namespace spec\Company\UserBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleUserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Company\UserBundle\Entity\SimpleUser');
    }

    public function let()
    {
        $this->beConstructedWith('John');
    }

    public function it_has_id_default_to_null()
    {
        $this->getId()->shouldReturn(null);
    }

    public function it_has_name()
    {
        $this->getName()->shouldReturn('John');
    }
}
