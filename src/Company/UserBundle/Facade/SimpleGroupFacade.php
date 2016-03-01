<?php

namespace Company\UserBundle\Facade;

use Company\UserBundle\Entity\SimpleGroup;
use Company\UserBundle\Entity\SimpleUser;
use Company\UserBundle\Repository\SimpleGroupRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class SimpleGroupFacade.
 */
class SimpleGroupFacade
{
    private $repository;
    private $em;

    /**
     * UserManagementApiContext constructor.
     *
     * @param SimpleGroupRepository $repository
     * @param EntityManager         $em
     */
    public function __construct(SimpleGroupRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em         = $em;
    }

    /**
     * @param $name
     *
     * @return SimpleGroup
     */
    public function createGroup($name)
    {
        $group = new SimpleGroup($name);

        $this->em->persist($group);
        $this->em->flush();

        return $group;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteGroup($id)
    {
        $group = $this->repository->find($id);

        if (!$group) {
            return false;
        }

        if (count($group->getUsers()) > 0) {
            return false;
        }

        $this->em->remove($group);
        $this->em->flush();

        return true;
    }

    /**
     * @param SimpleGroup $group
     * @param SimpleUser  $user
     *
     * @return bool
     *
     * @internal param $id
     */
    public function addUserToGroup(SimpleGroup $group, SimpleUser $user)
    {
        if ($group->hasUser($user)) {
            return false;
        }

        $group->addUser($user);

        $this->em->persist($group);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * @param SimpleGroup $group
     * @param SimpleUser  $user
     *
     * @return bool
     */
    public function removeUserFromGroup(SimpleGroup $group, SimpleUser $user)
    {
        if (!$group->hasUser($user)) {
            return false;
        }

        $group->removeUser($user);

        $this->em->persist($group);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }
}
