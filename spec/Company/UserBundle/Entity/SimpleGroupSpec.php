<?php

namespace spec\Company\UserBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleGroupSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Company\UserBundle\Entity\SimpleGroup');
    }

    public function let()
    {
        $this->beConstructedWith('cool-crowd');
    }

    public function it_has_id_default_to_null()
    {
        $this->getId()->shouldReturn(null);
    }

    public function it_has_name()
    {
        $this->getGroupName()->shouldReturn('cool-crowd');
    }
}
