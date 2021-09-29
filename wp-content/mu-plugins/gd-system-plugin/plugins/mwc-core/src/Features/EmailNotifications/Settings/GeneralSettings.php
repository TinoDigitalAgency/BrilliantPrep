<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Settings;

use GoDaddy\WordPress\MWC\Common\Settings\Models\AbstractSettingGroup;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Control;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Setting;

/**
 * The general settings group.
 *
 * @since 2.15.0
 */
class GeneralSettings extends AbstractSettingGroup
{
    /** @var string ID of the settings group */
    const GROUP_ID = 'email-notifications';

    /** @var string ID of the "Sender name" setting */
    const SETTING_ID_SENDER_NAME = 'sender_name';

    /** @var string ID of the "Sender address" setting */
    const SETTING_ID_SENDER_ADDRESS = 'sender_address';

    /**
     * GeneralSettings constructor.
     *
     * @since 2.15.0
     */
    public function __construct()
    {
        $this->id = $this->name = static::GROUP_ID;

        $this->label = __('Email Notifications', 'mwc-core');
    }

    /**
     * Gets the initial settings.
     *
     * @since 2.15.0
     *
     * @return Setting[]
     */
    protected function getInitialSettings() : array
    {
        return [
            // "Sender name" setting
            (new Setting())
                ->setId(static::SETTING_ID_SENDER_NAME)
                ->setName(static::SETTING_ID_SENDER_NAME)
                ->setLabel(__('Sender name', 'mwc-core'))
                ->setIsRequired(true)
                ->setType(Setting::TYPE_STRING)
                ->setControl((new Control())
                    ->setType(Control::TYPE_TEXT)
                ),

            // "Sender address" setting
            (new Setting())
                ->setId(static::SETTING_ID_SENDER_ADDRESS)
                ->setName(static::SETTING_ID_SENDER_ADDRESS)
                ->setLabel(__('Sender address', 'mwc-core'))
                ->setIsRequired(true)
                ->setType(Setting::TYPE_EMAIL)
                ->setControl((new Control())
                    ->setType(Control::TYPE_EMAIL)
                ),
        ];
    }
}
