<?php

namespace Company\UserBundle\Facade;

use Company\UserBundle\Entity\SimpleUser;
use Company\UserBundle\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManager;

class SimpleUserFacade
{
    private $repository;
    private $em;

    /**
     * UserManagementApiContext constructor.
     *
     * @param $repository
     */
    public function __construct(SimpleUserRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em         = $em;
    }

    /**
     * @param $name
     *
     * @return SimpleUser
     */
    public function createUser($name)
    {
        $user = new SimpleUser($name);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
