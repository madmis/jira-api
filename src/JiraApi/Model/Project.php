<?php

namespace madmis\JiraApi\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\PostDeserialize;

/**
 * Class Project
 * @package madmis\JiraApi\Model
 *
 * @AccessType("public_method")
 */
class Project
{
    /**
     * @Type("string")
     * @var string
     */
    protected $self;

    /**
     * @Type("integer")
     * @var int
     */
    protected $id;

    /**
     * @Type("string")
     * @var string
     */
    protected $key;

    /**
     * @Type("string")
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     * @param string $self
     */
    public function setSelf($self)
    {
        $this->self = $self;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @PostDeserialize
     */
    public function postDeserialize()
    {
    }
}