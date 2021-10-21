<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingContract;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Control;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Setting;
use GoDaddy\WordPress\MWC\Common\Settings\Traits\HasSettingsTrait;
use GoDaddy\WordPress\MWC\Common\Traits\HasLabelTrait;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\DataProviderContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailContentContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailNotificationContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\EmailTemplateContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataProviders\SiteDataProvider;

/**
 * Model for email notifications.
 *
 * @since 2.15.0
 */
class EmailNotification implements EmailNotificationContract
{
    use HasLabelTrait;
    use HasSettingsTrait;

    /** @var string */
    const SETTING_ID_ENABLED = 'enabled';

    /** @var string */
    const SETTING_ID_SUBJECT = 'subject';

    /** @var string */
    protected $id;

    /** @var string */
    protected $description = '';

    /** @var EmailTemplateContract */
    protected $template;

    /** @var EmailContentContract */
    protected $content;

    /** @var string[] */
    protected $categories = [];

    /** @var bool */
    protected $manual = false;

    /** @var bool */
    protected $sentToAdministrator = false;

    /** @var DataProviderContract[] */
    protected $dataProviders;

    /**
     * Gets the email notification ID.
     *
     * @since 2.15.0
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the email notification description.
     *
     * @since 2.15.0
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Gets the email notification subject.
     *
     * @since 2.15.0
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->getSettingValue(static::SETTING_ID_SUBJECT);
    }

    /**
     * Gets the email notification template.
     *
     * @since 2.15.0
     *
     * @return EmailTemplateContract|null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Gets the email notification content.
     *
     * @since 2.15.0
     *
     * @return EmailContentContract|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Gets the email notification categories.
     *
     * @since 2.15.0
     *
     * @return string[]
     */
    public function getCategories() : array
    {
        return $this->categories;
    }

    /**
     * Gets the email notification structured body.
     *
     * @since 2.15.0
     *
     * @return string
     */
    public function getStructuredBody() : string
    {
        return '';
    }

    /**
     * Gets the email notification plaintext body.
     *
     * @since 2.15.0
     *
     * @return string
     */
    public function getPlainBody() : string
    {
        return '';
    }

    /**
     * Gets the email notification initial settings.
     *
     * @since 2.15.0
     *
     * @return SettingContract[]
     */
    protected function getInitialSettings() : array
    {
        return [
            (new Setting())
                ->setId(static::SETTING_ID_ENABLED)
                ->setName(static::SETTING_ID_ENABLED)
                ->setLabel(__('Enabled', 'mwc-core'))
                ->setType(Setting::TYPE_BOOLEAN)
                ->setControl((new Control())
                    ->setType(Control::TYPE_CHECKBOX)
                ),
            (new Setting())
                ->setId(static::SETTING_ID_SUBJECT)
                ->setName(static::SETTING_ID_SUBJECT)
                ->setLabel(__('Subject', 'mwc-core'))
                ->setType(Setting::TYPE_STRING)
                ->setControl((new Control())
                    ->setType(Control::TYPE_TEXT)
                ),
        ];
    }

    /**
     * Gets data from the registered data providers.
     *
     * @since 2.15.0
     *
     * @return array
     * @throws Exception
     */
    public function getData() : array
    {
        $data = [];

        foreach ($this->getDataProviders() as $dataProvider) {
            $data = ArrayHelper::combine($data, $dataProvider->getData());
        }

        return $data;
    }

    /**
     * Gets placeholders from the registered data providers.
     *
     * @since 2.15.0
     *
     * @return array
     * @throws Exception
     */
    public function getPlaceholders() : array
    {
        $placeholders = [];

        foreach ($this->getDataProviders() as $dataProvider) {
            $placeholders = ArrayHelper::combine($placeholders, $dataProvider->getPlaceholders());
        }

        return $placeholders;
    }

    /**
     * Gets the initial email notification data providers.
     *
     * @return DataProviderContract[] by default this includes an instance of {@see SiteDataProvider}
     */
    protected function getInitialDataProviders() : array
    {
        return [
            new SiteDataProvider(),
        ];
    }

    /**
     * Gets the email notification data providers.
     *
     * @return DataProviderContract[]
     */
    public function getDataProviders() : array
    {
        if (null === $this->dataProviders) {
            $this->dataProviders = $this->getInitialDataProviders();
        }

        return $this->dataProviders;
    }

    /**
     * Determines whether the email notification is enabled.
     *
     * @since 2.15.0
     *
     * @return bool
     */
    public function isEnabled() : bool
    {
        return (bool) $this->getSettingValue(static::SETTING_ID_ENABLED);
    }

    /**
     * Determines whether the email notification is manually handled.
     *
     * @since 2.15.0
     *
     * @return bool|null
     */
    public function isManual()
    {
        return $this->manual;
    }

    /**
     * Determines whether the email notification should be sent to an administrator.
     *
     * @since 2.15.0
     *
     * @return bool|null
     */
    public function isSentToAdministrator()
    {
        return $this->sentToAdministrator;
    }

    /**
     * Sets the email notification ID.
     *
     * @since 2.15.0
     *
     * @param string $value
     * @return self
     */
    public function setId(string $value) : EmailNotification
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Sets the email notification description.
     *
     * @since 2.15.0
     *
     * @param string $value
     * @return self
     */
    public function setDescription(string $value) : EmailNotification
    {
        $this->description = $value;

        return $this;
    }

    /**
     * Sets the email notification enabled status.
     *
     * @since 2.15.0
     *
     * @param bool $value
     * @return self
     */
    public function setEnabled(bool $value) : EmailNotification
    {
        $this->updateSettingValue(self::SETTING_ID_ENABLED, $value);

        return $this;
    }

    /**
     * Sets the email notification subject.
     *
     * @since 2.15.0
     *
     * @param string $value
     * @return self
     */
    public function setSubject(string $value) : EmailNotification
    {
        $this->updateSettingValue(self::SETTING_ID_SUBJECT, $value);

        return $this;
    }

    /**
     * Sets the email notification template.
     *
     * @since 2.15.0
     *
     * @param EmailTemplateContract $value
     * @return self
     */
    public function setTemplate(EmailTemplateContract $value) : EmailNotification
    {
        $this->template = $value;

        return $this;
    }

    /**
     * Sets the email notification content.
     *
     * @since 2.15.0
     *
     * @param EmailContentContract $value
     * @return self
     */
    public function setContent(EmailContentContract $value) : EmailNotification
    {
        $this->content = $value;

        return $this;
    }

    /**
     * Sets the email notification categories;.
     *
     * @since 2.15.0
     *
     * @param array $value
     * @return self
     */
    public function setCategories(array $value) : EmailNotification
    {
        $this->categories = $value;

        return $this;
    }

    /**
     * Sets whether the email notification should be handled manually.
     *
     * @since 2.15.0
     *
     * @param bool $value
     * @return self
     */
    public function setManual(bool $value) : EmailNotification
    {
        $this->manual = $value;

        return $this;
    }

    /**
     * Sets whether the email notification should be sent to an administrator.
     *
     * @since 2.15.0
     *
     * @param bool $value
     * @return self
     */
    public function setSentToAdministrator(bool $value) : EmailNotification
    {
        $this->sentToAdministrator = $value;

        return $this;
    }

    /**
     * Sets the email notification data providers.
     *
     * @since 2.15.0
     *
     * @param DataProviderContract[] $value
     * @return self
     */
    public function setDataProviders(array $value) : EmailNotification
    {
        $this->dataProviders = [];

        foreach ($value as $dataProvider) {
            $this->dataProviders[get_class($dataProvider)] = $dataProvider;
        }

        return $this;
    }

    /**
     * Adds a data provider to the email notification's list of providers.
     *
     * @since 2.15.0
     *
     * @param DataProviderContract $dataProvider
     * @return self
     */
    public function addDataProvider(DataProviderContract $dataProvider) : EmailNotification
    {
        $this->dataProviders[get_class($dataProvider)] = $dataProvider;

        return $this;
    }

    /**
     * Removes a data provider from the email notification's list of providers.
     *
     * @since 2.15.0
     *
     * @param DataProviderContract $dataProvider
     * @return self
     */
    public function removeDataProvider(DataProviderContract $dataProvider) : EmailNotification
    {
        ArrayHelper::remove($this->dataProviders, get_class($dataProvider));

        return $this;
    }
}
