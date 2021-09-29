<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailTemplateContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Exceptions\EmailTemplateNotFoundException;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models\DefaultEmailTemplate;

/**
 * Data store for email notifications template settings.
 *
 * @since 2.15.0
 */
class EmailTemplateDataStore
{
    /** @var string the base option name to be used for reading the email template settings */
    private $settingsOptionNameBaseTemplate = 'mwc_%s_email_notification_template';

    protected $templates = [
        'default' => DefaultEmailTemplate::class,
    ];

    /**
     * Gets an email template with given ID and reads its settings.
     *
     * @since 2.15.0
     *
     * @param string $id
     * @return EmailTemplateContract
     * @throws EmailTemplateNotFoundException
     */
    public function read(string $id) : EmailTemplateContract
    {
        /** @var DefaultEmailTemplate */
        $template = $this->getTemplateInstance($id);

        $this->getOptionsSettingsDataStore($this->getSettingsOptionNameTemplate($id))
            ->read($template);

        return $template;
    }

    /**
     * Gets the email notification template instance from the given ID.
     *
     * @param string $id
     * @return EmailTemplateContract
     * @throws EmailTemplateNotFoundException
     */
    protected function getTemplateInstance(string $id) : EmailTemplateContract
    {
        if (! ArrayHelper::exists($this->templates, $id)) {
            throw new EmailTemplateNotFoundException(sprintf(
                __('No email notification template found with the ID %s.', 'mwc-core'),
                $id
            ));
        }

        $class = ArrayHelper::get($this->templates, $id);

        if (! is_a($class, EmailTemplateContract::class, true)) {
            throw new Exception(sprintf(
                __('The class name for %s must be an instance of EmailTemplateContract', 'mwc-core'),
                $id
            ));
        }

        return (new $class())->setId($id);
    }

    /**
     * Saves the settings of a given email template object.
     *
     * @since 2.15.0
     *
     * @param EmailTemplateContract $emailTemplate
     * @return EmailTemplateContract
     */
    public function save(EmailTemplateContract $emailTemplate) : EmailTemplateContract
    {
        $this->getOptionsSettingsDataStore($this->getSettingsOptionNameTemplate($emailTemplate->getId()))
            ->save($emailTemplate);

        return $emailTemplate;
    }

    /**
     * Deletes the settings of a given email template object.
     *
     * @since 2.15.0
     *
     * @param EmailTemplateContract $emailTemplate
     * @return EmailTemplateContract
     */
    public function delete(EmailTemplateContract $emailTemplate) : EmailTemplateContract
    {
        $this->getOptionsSettingsDataStore($this->getSettingsOptionNameTemplate($emailTemplate->getId()))
            ->delete($emailTemplate);

        return $emailTemplate;
    }

    /**
     * Gets the options settings data store for the email template.
     *
     * @since 2.15.0
     *
     * @param string $optionNameTemplate
     * @return OptionsSettingsDataStore
     */
    protected function getOptionsSettingsDataStore(string $optionNameTemplate) : OptionsSettingsDataStore
    {
        return new OptionsSettingsDataStore($optionNameTemplate);
    }

    /**
     * Gets the option name template to access an email template's settings.
     *
     * @since 2.15.0
     *
     * @param string $emailTemplateId
     * @return string
     */
    private function getSettingsOptionNameTemplate(string $emailTemplateId) : string
    {
        return sprintf($this->settingsOptionNameBaseTemplate, $emailTemplateId).'_'.OptionsSettingsDataStore::SETTING_ID_MERGE_TAG;
    }
}
