<?php

namespace spec\Company\UserBundle\Facade;

use Company\UserBundle\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleUserFacadeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Company\UserBundle\Facade\SimpleUserFacade');
    }

    public function let(SimpleUserRepository $repository, EntityManager $em)
    {
        $this->beConstructedWith($repository, $em);
    }

    public function it_will_create_new_user_from_given_name($em, $name)
    {
        $em->persist(Argument::type('Company\UserBundle\Entity\SimpleUser'))->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->createUser($name)->shouldReturnAnInstanceOf('Company\UserBundle\Entity\SimpleUser');
    }
}
