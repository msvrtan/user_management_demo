<?php

namespace Company\UserBundle\Facade;

use Company\UserBundle\Entity\SimpleUser;
use Company\UserBundle\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class SimpleUserFacade.
 */
class SimpleUserFacade
{
    private $repository;
    private $em;

    /**
     * UserManagementApiContext constructor.
     *
     * @param SimpleUserRepository $repository
     * @param EntityManager        $em
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

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteUser($id)
    {
        $user = $this->repository->find($id);

        if (!$user) {
            return false;
        }

        $this->em->remove($user);
        $this->em->flush();

        return true;
    }
}
