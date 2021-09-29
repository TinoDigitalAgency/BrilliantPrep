<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications;

use GoDaddy\WordPress\MWC\Common\Email\Email;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailNotificationContract;

/**
 * A base builder for converting email notification definitions into email objects.
 */
abstract class AbstractEmailBuilder
{
    /** @var EmailNotificationContract */
    protected $emailNotification;

    /**
     * Constructor.
     *
     * @param EmailNotificationContract $emailNotification
     */
    public function __construct(EmailNotificationContract $emailNotification)
    {
        $this->emailNotification = $emailNotification;
    }

    /**
     * Builds the email object.
     *
     * @return Email
     */
    public function build() : Email
    {
        return $this->getNewInstance()
            ->setBody($this->getFormattedBody());
    }

    /**
     * Gets the email data.
     *
     * @return array
     */
    abstract protected function getData() : array;

    /**
     * Gets the formatted body with custom component placeholders replaced.
     *
     * @return string
     */
    protected function getFormattedBody() : string
    {
        $structuredBody = $this->emailNotification->getStructuredBody();

        foreach (ArrayHelper::get($this->getData(), 'internal.custom_components', []) as $componentKey => $componentContent) {
            $structuredBody = str_replace('<mj-'.str_replace('_', '-', $componentKey).'>', $componentContent, $structuredBody);
        }

        return $structuredBody;
    }

    /**
     * Gets a new email instance.
     *
     * @return Email
     */
    abstract protected function getNewInstance() : Email;
}
