<?php

namespace madmis\JiraApi\Authentication;

/**
 * Interface AuthenticationInterface
 * @package madmis\JiraApi\Authentication
 */
interface AuthenticationInterface
{
    /**
     * @return string
     */
    public function getCredential();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getPassword();
}
