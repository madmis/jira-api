<?php


namespace madmis\JiraApi\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class Issue
 * @package madmis\JiraApi\Model
 *
 * @AccessType("public_method")
 */
class Issue
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
     * @Type("array")
     * @var array
     */
    protected $labels = [];

    /**
     * @Type("string")
     * @var string
     */
    protected $description;

    /**
     * @Type("string")
     * @var string
     */
    protected $summary;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @var \DateTime
     */
    protected $updated;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @var \DateTime
     */
    protected $created;

    /**
     * @Type("madmis\JiraApi\Model\IssueType")
     * @SerializedName("issuetype")
     * @var IssueType
     */
    protected $issueType;

    /**
     * @Type("madmis\JiraApi\Model\Project")
     * @var Project
     */
    protected $project;

    /**
     * @Type("madmis\JiraApi\Model\User")
     * @var User
     */
    protected $creator;

    /**
     * @Type("madmis\JiraApi\Model\User")
     * @var User
     */
    protected $reporter;

    /**
     * @Type("madmis\JiraApi\Model\User")
     * @var User
     */
    protected $assignee;

    /**
     * @Type("madmis\JiraApi\Model\IssueStatus")
     * @var IssueStatus
     */
    protected $status;

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
     * @return IssueType
     */
    public function getIssueType()
    {
        return $this->issueType;
    }

    /**
     * @param IssueType $issueType
     */
    public function setIssueType(IssueType $issueType)
    {
        $this->issueType = $issueType;
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
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param string $labels
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     */
    public function setReporter(User $reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param User $assignee
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @return IssueStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param IssueStatus $status
     */
    public function setStatus(IssueStatus $status)
    {
        $this->status = $status;
    }
}