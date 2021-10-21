<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models;

use GoDaddy\WordPress\MWC\Common\Settings\Models\Control;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Setting;

/**
 * This class will load the structured content from a MJML template file.
 *
 * @since 2.15.0
 */
class DefaultEmailContent extends AbstractFileEmailContent
{
    /** @var string */
    const SETTING_ID_HEADING = 'heading';

    /** @var string */
    const SETTING_ID_ADDITIONAL_CONTENT = 'additional_content';

    /**
     * Gets the structured content.
     *
     * @since 2.15.0
     *
     * @return string
     */
    public function getStructuredContent() : string
    {
        return $this->getContentFromFile();
    }

    /**
     * Gets the initial settings.
     *
     * @since 2.15.0
     *
     * @return Setting[]
     */
    public function getInitialSettings() : array
    {
        return [
            (new Setting())
                ->setId(static::SETTING_ID_HEADING)
                ->setName(static::SETTING_ID_HEADING)
                ->setLabel(__('Heading', 'mwc-core'))
                ->setType(Setting::TYPE_STRING)
                ->setControl((new Control())
                    ->setType(Control::TYPE_TEXT)
                ),
            (new Setting())
                ->setId(static::SETTING_ID_ADDITIONAL_CONTENT)
                ->setName(static::SETTING_ID_ADDITIONAL_CONTENT)
                ->setLabel(__('Additional content', 'mwc-core'))
                ->setType(Setting::TYPE_STRING)
                ->setControl((new Control())
                    ->setType(Control::TYPE_TEXTAREA)
                ),
        ];
    }
}
