<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Traits;

use GoDaddy\WordPress\MWC\Common\Settings\Models\Control;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Setting;
use GoDaddy\WordPress\MWC\Common\Settings\Traits\HasSettingsTrait;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailNotificationWithRecipientsContract;

/**
 * A trait for objects implementing a recipients setting.
 *
 * @see EmailNotificationWithRecipientsContract
 *
 * @since x.y.z
 */
trait HasRecipientsSettingTrait
{
    use HasSettingsTrait;

    /** @var string */
    protected $recipientsSettingId = 'recipients';

    /**
     * Sets the recipients.
     *
     * @since x.y.z
     *
     * @param string[] $value
     * @return self
     */
    public function setRecipients(array $value)
    {
        $this->updateSettingValue($this->recipientsSettingId, $value);

        return $this;
    }

    /**
     * Gets the recipients.
     *
     * @since x.y.z
     *
     * @return string[]
     */
    public function getRecipients() : array
    {
        return $this->getSettingValue($this->recipientsSettingId);
    }

    /**
     * Gets a setting object for recipients.
     *
     * @since x.y.z
     *
     * @return Setting
     */
    public function getRecipientsSettingObject() : Setting
    {
        return (new Setting())
            ->setId($this->recipientsSettingId)
            ->setName($this->recipientsSettingId)
            ->setLabel(__('Recipients', 'mwc-core'))
            ->setType(Setting::TYPE_STRING)
            ->setIsMultivalued(true)
            ->setControl((new Control())
                ->setType(Control::TYPE_TEXT)
            );
    }
}
