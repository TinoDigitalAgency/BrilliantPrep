<?php

namespace GoDaddy\WordPress\MWC\Common\Email;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Email\Contracts\EmailContract;
use GoDaddy\WordPress\MWC\Common\Email\Contracts\EmailServiceContract;
use InvalidArgumentException;

/**
 * Emails class.
 */
class Emails
{
    /**
     * Sends the email based on the EmailService stored in configuration.
     *
     * @param EmailContract $email
     * @throws Exception
     */
    public static function send(EmailContract $email)
    {
        $emailService = static::getEmailServiceForEmail($email);
        $emailService->send($email);
    }

    /**
     * Returns and instantiates an object based on the $email content type.
     *
     * @param EmailContract $email
     * @return EmailServiceContract
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected static function getEmailServiceForEmail(EmailContract $email) : EmailServiceContract
    {
        $contentType = $email->getContentType();

        if (! $contentType) {
            throw new Exception(__('The email does not have content type set', 'mwc-common'));
        }

        $className = Configuration::get('email.services.'.$contentType);

        if (! is_a($className, EmailServiceContract::class, true)) {
            throw new InvalidArgumentException(sprintf(
                __('The class name for %s must be an instance of EmailServiceContract', 'mwc-common'),
                $className
            ));
        }

        return new $className;
    }
}
