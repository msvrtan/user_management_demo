<?php

namespace Company\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SimpleGroup.
 */
class SimpleGroup implements \JsonSerializable
{
    /** @var int */
    private $id;

    /** @var string */
    private $groupName;

    private $users;

    /**
     * SimpleGroup constructor.
     *
     * @param string $groupName
     */
    public function __construct($groupName)
    {
        $this->groupName = $groupName;
        $this->users     = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get groupName.
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param SimpleUser $user
     *
     * @return bool
     */
    public function addUser(SimpleUser $user)
    {
        $this->users[] = $user;
        $user->addToGroup($this);

        return $this;
    }

    /**
     * @param SimpleUser $user
     *
     * @return bool
     */
    public function hasUser(SimpleUser $user)
    {
        foreach ($this->users as $existingUser) {
            if ($existingUser->getId() == $user->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param SimpleUser $user
     *
     * @return bool
     */
    public function removeUser(SimpleUser $user)
    {
        foreach ($this->users as $key => $existingUser) {
            if ($existingUser->getId() == $user->getId()) {
                unset($this->users[$key]);

                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'        => $this->getId(),
            'groupName' => $this->getGroupName(),
        ];
    }
}
