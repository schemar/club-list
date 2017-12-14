<?php

namespace AppBundle\Mailer;


/**
 * Mailer
 */
class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * @var string
     */
    private $from;

    /**
     * @param \Swift_Mailer $swiftMailer
     * @param string        $from
     */
    public function __construct(\Swift_Mailer $swiftMailer, $from)
    {
        $this->swiftMailer = $swiftMailer;
        $this->from = $from;
    }

    /**
     * @param Mail $mail
     * @return bool Whether sending was successful for all recipients
     */
    public function send(Mail $mail)
    {
        $message = \Swift_Message::newInstance($mail->getSubject(), $mail->getBody());
        $message->setFrom($this->from);

        $recipients = [];
        foreach ($mail->getRecipients() as $recipient) {
            $recipients[$recipient->getAddress()] = $recipient->getName();
        }
        $message->setTo($recipients);

        $successfulRecipients = $this->swiftMailer->send($message);

        if ($successfulRecipients != count($recipients)) {
            return false;
        }

        return true;
    }
}
