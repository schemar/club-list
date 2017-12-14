<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="invitation")
 * @ORM\Entity
 */
class Invitation
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=6)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=256)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     */
    private $locale;

    /**
     * When sending invitation be sure to set this value to `true`
     *
     * It can prevent invitations from being sent twice
     *
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $sent = false;

    /**
     * Generates and sets the code
     */
    public function __construct()
    {
        // generate identifier only once, here a 6 characters length code
        $this->code = substr(md5(uniqid(rand(), true)), 0, 6);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return bool
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * Sets this invitation as sent
     */
    public function send()
    {
        $this->sent = true;
    }
}