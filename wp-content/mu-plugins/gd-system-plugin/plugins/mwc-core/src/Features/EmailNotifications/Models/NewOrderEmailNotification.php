<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailNotificationWithRecipientsContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\OrderEmailNotificationContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Traits\HasRecipientsSettingTrait;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Traits\IsOrderEmailNotificationTrait;

/**
 * Model for order email notifications.
 */
class NewOrderEmailNotification extends EmailNotification implements EmailNotificationWithRecipientsContract, OrderEmailNotificationContract
{
    use HasRecipientsSettingTrait;
    use IsOrderEmailNotificationTrait;

    /**
     * Gets the email notification initial settings.
     *
     * @return SettingContract[]
     * @throws Exception
     */
    protected function getInitialSettings() : array
    {
        return ArrayHelper::combine(parent::getInitialSettings(), [$this->getRecipientsSettingObject()]);
    }
}
