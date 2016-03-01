<?php

namespace Company\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SimpleUser.
 */
class SimpleUser implements \JsonSerializable
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    private $groups;

    /**
     * SimpleUser constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name   = $name;
        $this->groups = new ArrayCollection();
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param SimpleGroup $simpleGroup
     *
     * @return $this
     */
    public function addToGroup(SimpleGroup $simpleGroup)
    {
        $this->groups[] = $simpleGroup;

        return $this;
    }

    /**
     * @param SimpleGroup $simpleGroup
     *
     * @return bool
     */
    public function removeFromGroup(SimpleGroup $simpleGroup)
    {
        foreach ($this->groups as $key => $existingGroup) {
            if ($existingGroup->getId() === $simpleGroup->getId()) {
                unset($this->groups[$key]);

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
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
