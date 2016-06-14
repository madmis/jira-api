<?php

namespace madmis\JiraApi\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class IssueType
 * @package madmis\JiraApi\Model
 *
 * @AccessType("public_method")
 */
class IssueType
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
    protected $description;

    /**
     * @Type("string")
     * @SerializedName("iconUrl")
     * @var string
     */
    protected $iconUrl;

    /**
     * @Type("string")
     * @var string
     */
    protected $name;

    /**
     * @Type("boolean")
     * @var bool
     */
    protected $subtask;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    /**
     * @param string $iconUrl
     */
    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;
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
     * @return boolean
     */
    public function isSubtask()
    {
        return $this->subtask;
    }

    /**
     * @param boolean $subtask
     */
    public function setSubtask($subtask)
    {
        $this->subtask = $subtask;
    }
}
