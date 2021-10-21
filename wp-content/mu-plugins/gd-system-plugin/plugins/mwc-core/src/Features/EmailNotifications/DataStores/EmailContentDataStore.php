<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores;

use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailContentContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models\DefaultEmailContent;

/**
 * Data store for email content settings.
 *
 * @since x.y.z
 */
class EmailContentDataStore
{
    /** @var string the base option name to be used for reading the email content settings */
    private $settingsOptionNameBaseTemplate = 'mwc_%s_email_notification_content';

    /**
     * Gets an email content with given ID and reads its settings.
     *
     * @since x.y.z
     *
     * @param string $id
     * @return EmailContentContract
     */
    public function read(string $id) : EmailContentContract
    {
        $content = (new DefaultEmailContent())->setId($id);

        $this->getOptionsSettingsDataStore($this->getSettingsOptionNameTemplate($id))
            ->read($content);

        return $content;
    }

    /**
     * Saves the settings of a given email content object.
     *
     * @since x.y.z
     *
     * @param EmailContentContract $emailContent
     * @return EmailContentContract
     */
    public function save(EmailContentContract $emailContent) : EmailContentContract
    {
        $this->getOptionsSettingsDataStore($this->getSettingsOptionNameTemplate($emailContent->getId()))
            ->save($emailContent);

        return $emailContent;
    }

    /**
     * Deletes the settings of a given email content object.
     *
     * @since x.y.z
     *
     * @param EmailContentContract $emailContent
     * @return EmailContentContract
     */
    public function delete(EmailContentContract $emailContent) : EmailContentContract
    {
        $this->getOptionsSettingsDataStore($this->getSettingsOptionNameTemplate($emailContent->getId()))
            ->delete($emailContent);

        return $emailContent;
    }

    /**
     * Gets the options settings data store for the email content.
     *
     * @since x.y.z
     *
     * @param string $optionNameTemplate
     * @return OptionsSettingsDataStore
     */
    protected function getOptionsSettingsDataStore(string $optionNameTemplate) : OptionsSettingsDataStore
    {
        return new OptionsSettingsDataStore($optionNameTemplate);
    }

    /**
     * Gets the option name template to access an email content's settings.
     *
     * @since x.y.z
     *
     * @param string $emailContentId
     * @return string
     */
    private function getSettingsOptionNameTemplate(string $emailContentId) : string
    {
        return sprintf($this->settingsOptionNameBaseTemplate, $emailContentId).'_'.OptionsSettingsDataStore::SETTING_ID_MERGE_TAG;
    }
}
