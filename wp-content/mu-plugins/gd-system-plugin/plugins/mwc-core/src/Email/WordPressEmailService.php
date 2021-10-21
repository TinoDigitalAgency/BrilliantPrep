<?php

namespace GoDaddy\WordPress\MWC\Core\Email;

use GoDaddy\WordPress\MWC\Common\Email\Contracts\EmailContract;
use GoDaddy\WordPress\MWC\Common\Email\Contracts\EmailServiceContract;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use Exception;

/**
 * Email service for sending emails through WordPress.
 */
class WordPressEmailService implements EmailServiceContract {

    /**
     * Sends an email.
     *
     * @param EmailContract $email
     * @throws Exception
     */
    public function send(EmailContract $email)
    {
        // set the content type for this email
        $filter = Register::filter()
            ->setGroup('wp_mail_content_type')
            ->setHandler([$email, 'getContentType'])
            ->setPriority(10)
            ->setArgumentsCount(1);

        $filter->execute();

        wp_mail($email->getTo(), $email->getSubject() ?: '', $email->getBody() ?: '', $email->getHeaders());

        // clear the content type for other emails
        $filter->deregister();
    }
}
