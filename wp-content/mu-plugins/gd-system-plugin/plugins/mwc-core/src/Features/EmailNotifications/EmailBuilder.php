<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications;

use GoDaddy\WordPress\MWC\Common\Email\Email;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\ValidationHelper;

/**
 * A builder for converting email notification definitions into email objects.
 */
class EmailBuilder extends AbstractEmailBuilder
{
    /** @var string */
    protected $fromAddress;

    /** @var string */
    protected $fromName;

    /** @var string[] */
    protected $headers = [];

    /** @var string[] */
    protected $recipients = [];

    /**
     * Sets the email's from address.
     *
     * @param string $value
     * @return $this
     */
    public function setFromAddress(string $value) : EmailBuilder
    {
        $this->fromAddress = $value;

        return $this;
    }

    /**
     * Sets the email's from name.
     *
     * @param string $value
     * @return $this
     */
    public function setFromName(string $value) : EmailBuilder
    {
        $this->fromName = $value;

        return $this;
    }

    /**
     * Sets the email's headers.
     *
     * @param array $value
     * @return $this
     */
    public function setHeaders(array $value) : EmailBuilder
    {
        $this->headers = $value;

        return $this;
    }

    /**
     * Sets the email's recipient addresses.
     *
     * @param array $value
     * @return $this
     */
    public function setRecipients(array $value) : EmailBuilder
    {
        $this->recipients = ArrayHelper::where($value, static function ($address) {
            return ValidationHelper::isEmail($address);
        });

        return $this;
    }

    /**
     * Builds the email object.
     *
     * @return Email
     */
    public function build() : Email
    {
        $email = parent::build();

        return $email->setHeaders($this->getFormattedHeaders())
            ->setSubject($this->emailNotification->getSubject());
    }

    /**
     * Gets the email data.
     *
     * @return array
     */
    protected function getData() : array
    {
        return $this->emailNotification->getData();
    }

    /**
     * Gets a new email instance.
     *
     * @return Email
     */
    protected function getNewInstance() : Email
    {
        return new Email($this->getFormattedRecipients());
    }

    /**
     * Gets the formatted headers, ready for sending.
     *
     * This adds the Reply-to header, derived from $fromName & $fromAddress.
     *
     * @return string[]
     */
    protected function getFormattedHeaders() : array
    {
        $formattedHeaders = [];

        foreach ($this->headers as $name => $value) {
            $formattedHeaders[] = "{$name}: {$value}";
        }

        if ($this->fromAddress && $this->fromName) {
            $formattedHeaders[] = "Reply-to: {$this->fromName} <{$this->fromAddress}>";
        }

        return $formattedHeaders;
    }

    /**
     * Gets the formatted list of recipient addresses.
     *
     * @return string
     */
    protected function getFormattedRecipients() : string
    {
        return implode(',', $this->recipients);
    }
}
