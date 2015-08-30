<?php

namespace madmis\JiraApi\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class Worklog
 * @package madmis\JiraApi\Model
 *
 * @AccessType("public_method")
 */
class Worklog
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
     * @Type("madmis\JiraApi\Model\User")
     * @var User
     */
    protected $author;

    /**
     * @Type("madmis\JiraApi\Model\User")
     * @SerializedName("updateAuthor")
     * @var User
     */
    protected $updateAuthor;

    /**
     * @Type("string")
     * @var string
     */
    protected $comment;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @var \DateTime
     */
    protected $created;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @var \DateTime
     */
    protected $started;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @var \DateTime
     */
    protected $updated;

    /**
     * @Type("string")
     * @SerializedName("timeSpent")
     * @var string
     */
    protected $timeSpent;

    /**
     * @Type("integer")
     * @SerializedName("timeSpentSeconds")
     * @var int
     */
    protected $timeSpentSeconds;

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
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return User
     */
    public function getUpdateAuthor()
    {
        return $this->updateAuthor;
    }

    /**
     * @param User $updateAuthor
     */
    public function setUpdateAuthor(User $updateAuthor)
    {
        $this->updateAuthor = $updateAuthor;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @param \DateTime $started
     */
    public function setStarted(\DateTime $started)
    {
        $this->started = $started;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /**
     * @param string $timeSpent
     */
    public function setTimeSpent($timeSpent)
    {
        $this->timeSpent = $timeSpent;
    }

    /**
     * @return int
     */
    public function getTimeSpentSeconds()
    {
        return $this->timeSpentSeconds;
    }

    /**
     * @param int $timeSpentSeconds
     */
    public function setTimeSpentSeconds($timeSpentSeconds)
    {
        $this->timeSpentSeconds = $timeSpentSeconds;
    }
}