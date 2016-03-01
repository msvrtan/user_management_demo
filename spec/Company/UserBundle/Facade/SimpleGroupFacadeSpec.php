<?php

namespace spec\Company\UserBundle\Facade;

use Company\UserBundle\Entity\SimpleGroup;
use Company\UserBundle\Entity\SimpleUser;
use Company\UserBundle\Repository\SimpleGroupRepository;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleGroupFacadeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Company\UserBundle\Facade\SimpleGroupFacade');
    }

    public function let(SimpleGroupRepository $repository, EntityManager $em)
    {
        $this->beConstructedWith($repository, $em);
    }

    public function it_will_create_new_group_from_given_name($em, $name)
    {
        $em->persist(Argument::type('Company\UserBundle\Entity\SimpleGroup'))->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->createGroup($name)->shouldReturnAnInstanceOf('Company\UserBundle\Entity\SimpleGroup');
    }

    public function it_can_delete_group_using_id($repository, $em, $id, SimpleGroup $group)
    {
        $repository->find($id)->willReturn($group);
        $em->remove($group)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->deleteGroup($id)->shouldReturn(true);
    }

    public function it_returns_false_on_deleting_group_that_doesnt_exist($repository, $em, $id, SimpleGroup $group)
    {
        $repository->find($id)->willReturn(null);

        $this->deleteGroup($id)->shouldReturn(false);
    }

    public function it_adds_user_to_group($em, SimpleGroup $group, SimpleUser $user)
    {
        $group->hasUser($user)->willReturn(false);
        $group->addUser($user)->shouldBeCalled();

        $em->persist($group)->shouldBeCalled();
        $em->persist($user)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->addUserToGroup($group, $user)->shouldReturn(true);
    }

    public function it_donest_add_user_to_group_since_user_already_there(SimpleGroup $group, SimpleUser $user)
    {
        $group->hasUser($user)->willReturn(true);
        $this->addUserToGroup($group, $user)->shouldReturn(false);
    }

    public function it_removes_user_from_group($em, SimpleGroup $group, SimpleUser $user)
    {
        $group->hasUser($user)->willReturn(true);
        $group->removeUser($user)->shouldBeCalled();

        $em->persist($group)->shouldBeCalled();
        $em->persist($user)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $this->removeUserFromGroup($group, $user)->shouldReturn(true);
    }

    public function it_doesnt_remove_user_from_group_since_user_not_there(SimpleGroup $group, SimpleUser $user)
    {
        $group->hasUser($user)->willReturn(false);
        $this->removeUserFromGroup($group, $user)->shouldReturn(false);
    }
}
