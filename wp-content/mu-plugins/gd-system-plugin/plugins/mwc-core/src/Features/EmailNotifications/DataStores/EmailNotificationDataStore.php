<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailNotificationContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Exceptions\EmailNotificationNotFoundException;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models\NewOrderEmailNotification;

/**
 * Data store for email notifications.
 *
 * @since x.y.z
 */
class EmailNotificationDataStore
{
    /** @var string available email notifications */
    protected $notifications = [
        'new_order' => NewOrderEmailNotification::class,
    ];

    /**
     * Gets an email notification with the given ID.
     *
     * @since x.y.z
     *
     * @param string $id
     * @return EmailNotificationContract
     * @throws EmailNotificationNotFoundException|Exception
     */
    public function read(string $id) : EmailNotificationContract
    {
        /** @var EmailNotificationContract $notification */
        $notification = $this->getOptionsSettingsDataStore($id)->read($this->getNotificationInstance($id));

        $notification = $this->readContentAndTemplate($notification);

        return $notification;
    }

    /**
     * Reads the notification's content & template properties.
     *
     * @since x.y.z
     *
     * @param EmailNotificationContract $notification
     * @return EmailNotificationContract
     */
    protected function readContentAndTemplate(EmailNotificationContract $notification) : EmailNotificationContract
    {
        $notification->setContent($this->getEmailContentDataStore()->read($notification->getId()));

        // we have a single email template available and all email notifications use it
        $notification->setTemplate($this->getEmailTemplateDataStore()->read('default'));

        return $notification;
    }

    /**
     * Gets the notification instance from the given ID.
     *
     * @param string $id
     * @return EmailNotificationContract
     * @throws EmailNotificationNotFoundException|Exception
     */
    protected function getNotificationInstance(string $id) : EmailNotificationContract
    {
        if (! ArrayHelper::exists($this->notifications, $id)) {
            throw new EmailNotificationNotFoundException(sprintf(
                __('No email notification found with the ID %s.', 'mwc-core'),
                $id
            ));
        }

        $class = ArrayHelper::get($this->notifications, $id);

        if (! is_a($class, EmailNotificationContract::class, true)) {
            throw new Exception(sprintf(
                __('The class name for %s must be an instance of EmailNotificationContract', 'mwc-core'),
                $id
            ));
        }

        return (new $class())->setId($id);
    }

    /**
     * Saves the given email notification.
     *
     * @since x.y.z
     *
     * @param EmailNotificationContract $notification
     * @return EmailNotificationContract
     */
    public function save(EmailNotificationContract $notification) : EmailNotificationContract
    {
        $this->getOptionsSettingsDataStore($notification->getId())->save($notification);

        $this->saveContentAndTemplate($notification);

        return $notification;
    }

    /**
     * Saves the notification content and template.
     *
     * @since x.y.z
     *
     * @param EmailNotificationContract $notification
     */
    protected function saveContentAndTemplate(EmailNotificationContract $notification)
    {
        if ($content = $notification->getContent()) {
            $this->getEmailContentDataStore()->save($content);
        }

        if ($template = $notification->getTemplate()) {
            $this->getEmailTemplateDataStore()->save($template);
        }
    }

    /**
     * Gets the email content data store.
     *
     * @since x.y.z
     *
     * @return EmailContentDataStore
     */
    protected function getEmailContentDataStore() : EmailContentDataStore
    {
        return new EmailContentDataStore();
    }

    /**
     * Gets the email template data store.
     *
     * @since x.y.z
     *
     * @return EmailTemplateDataStore
     */
    protected function getEmailTemplateDataStore() : EmailTemplateDataStore
    {
        return new EmailTemplateDataStore();
    }

    /**
     * Gets the options settings data store for the notification settings.
     *
     * @since x.y.z
     *
     * @param string $notificationId
     * @return OptionsSettingsDataStore
     */
    protected function getOptionsSettingsDataStore(string $notificationId) : OptionsSettingsDataStore
    {
        return new OptionsSettingsDataStore($this->getOptionNameTemplate($notificationId));
    }

    /**
     * Gets the option name template.
     *
     * @since x.y.z
     *
     * @param string $notificationId
     * @return string
     */
    protected function getOptionNameTemplate(string $notificationId) : string
    {
        return 'mwc_'.$notificationId.'_email_notification_'.OptionsSettingsDataStore::SETTING_ID_MERGE_TAG;
    }

    /**
     * Returns an array of all available EmailNotificationContract objects.
     *
     * @return EmailNotificationContract[]
     * @throws Exception
     */
    public function all() : array
    {
        $newNotifications = [];

        foreach (array_keys($this->notifications) as $notification) {
            $newNotifications[] = $this->read($notification);
        }

        return $newNotifications;
    }
}
