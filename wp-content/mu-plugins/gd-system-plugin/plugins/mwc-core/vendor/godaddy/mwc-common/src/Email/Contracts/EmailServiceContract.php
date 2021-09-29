<?php

namespace GoDaddy\WordPress\MWC\Common\Email\Contracts;

/**
 * An interface for email services.
 */
interface EmailServiceContract
{
    /**
     * Sends an email.
     *
     * @param EmailContract $email
     */
    public function send(EmailContract $email);
}
