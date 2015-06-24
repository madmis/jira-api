<?php

namespace madmis\JiraApi\Authentication;

/**
 * Class Basic
 * @package madmis\JiraApi\Authentication
 */
class Basic implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getCredential()
    {
        return base64_encode("{$this->username}:{$this->password}");
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}