<?php

namespace AppBundle\Mailer;


/**
 * Mail
 */
class Mail
{
    /**
     * @var Recipient[]
     */
    private $recipients;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @param Recipient[] $recipients
     * @param string      $subject
     * @param string      $body
     */
    public function __construct($recipients, $subject, $body)
    {
        $this->recipients = $recipients;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * @return Recipient[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
