<?php

namespace src\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class MailService
{
    /** @var MailService */
    private static $instance;

    /** @var Swift_Mailer */
    private $mailer;

    /**
     * MailService constructor.
     */
    private function __construct()
    {
        $transport = (new Swift_SmtpTransport(getenv('MAIL_HOST'), getenv('MAIL_PORT')))
            ->setUsername(getenv('MAIL_USER'))
            ->setPassword(getenv('MAIL_PASSWORD'));

        $this->mailer = new Swift_Mailer($transport);
    }

    /**
     * @return MailService
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new MailService();
        }

        return self::$instance;
    }

    /**
     * @param $subject
     * @param $body
     * @param $to
     *
     * @return int
     */
    public function sendMail($subject, $body, $to)
    {
        if (!is_array($to)) {
            $to = explode(',', $to);
        }
        $to = array_merge($to, explode(',', getenv('MAIL_ADMIN')));

        $message = (new Swift_Message($subject))
            ->setFrom(['shopapp@sale.com' => 'Shop App'])
            ->setTo($to)
            ->setBody($body);

        return $this->mailer->send($message);
    }
}