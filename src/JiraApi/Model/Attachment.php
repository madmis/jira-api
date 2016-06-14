<?php

namespace madmis\JiraApi\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;

/**
 * Class Attachment
 * @package madmis\JiraApi\Model
 *
 * @AccessType("public_method")
 */
class Attachment
{
    /**
     * @Type("string")
     * @var string
     */
    private $self;

    /**
     * @Type("integer")
     * @var int
     */
    private $id;

    /**
     * @Type("string")
     * @var string
     */
    private $filename;

    /**
     * @Type("madmis\JiraApi\Model\User")
     * @var User
     */
    private $author;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @var \DateTime
     */
    protected $created;

    /**
     * @Type("integer")
     * @var int
     */
    protected $size;

    /**
     * @Type("string")
     * @var string
     */
    protected $mimeType;

    /**
     * @Type("string")
     * @var string
     */
    protected $content;

    /**
     * @Type("string")
     * @var string
     */
    protected $thumbnail;

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
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
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
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }
}
