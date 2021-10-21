<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingGroupContract;
use GoDaddy\WordPress\MWC\Common\Settings\Models\AbstractSettingGroup;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Models\EmailNotification;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Settings\GeneralSettings;
use InvalidArgumentException;

/**
 * Data store for settings.
 */
class SettingsDataStore
{
    protected $dataStore;

    protected $settings = [
        'email-notifications' => GeneralSettings::class,
    ];

    /**
     * Options settings data store constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->dataStore = $value;
    }

    /**
     * Reads the values of the settings from database.
     *
     * @param string $id
     * @return SettingGroupContract
     * @throws Exception
     */
    public function read(string $id) : SettingGroupContract
    {
        $newSubgroups = [];
        foreach ($this->dataStore->all() as $notification) {
            $newSubgroups[] = $this->getSettingGroupInstance($notification);
        }
        $setting = $this->getSettingInstance($id);
        $setting->setSubgroups(ArrayHelper::combine($setting->getSubgroups(), $newSubgroups));
        $this->getOptionsSettingsDataStore($id)->read($setting);

        return $setting;
    }

    /**
     * Gets the setting instance from the given id.
     *
     * @param string $id
     * @return SettingGroupContract
     * @throws InvalidArgumentException
     */
    protected function getSettingInstance(string $id) : SettingGroupContract
    {
        if (! ArrayHelper::exists($this->settings, $id)) {
            throw new InvalidArgumentException(sprintf(
                __('No settings found with the ID %s.', 'mwc-core'),
                $id
            ));
        }

        $class = ArrayHelper::get($this->settings, $id);

        if (! is_a($class, SettingGroupContract::class, true)) {
            throw new InvalidArgumentException(sprintf(
                __('The class name for %s must be an instance of SettingGroupContract', 'mwc-core'),
                $id
            ));
        }

        return new $class();
    }

    /**
     * Configures new SettingGroup instances.
     *
     * @param EmailNotification $notification
     * @return SettingGroupContract
     */
    protected function getSettingGroupInstance(EmailNotification $notification) : SettingGroupContract
    {
        $settingGroup = $this->createNewSettingGroupInstance();
        $settingGroup->setId($notification->getId())
                     ->setName($notification->getName())
                     ->setLabel($notification->getLabel());
        $settingGroup->setSettings($notification->getSettings());

        $subSettingGroup = $this->createNewSettingGroupInstance();
        $subSettingGroup->setId('content')
                     ->setName('content')
                     ->setLabel(__('Content', 'mwc-core'));
        if ($content = $notification->getContent()) {
            $subSettingGroup->setSettings($content->getSettings());
        }

        $settingGroup->addSubgroup($subSettingGroup);

        return $settingGroup;
    }

    /**
     * Creates new SettingGroup instances by extending AbstractSettingGroup.
     *
     * @return SettingGroupContract
     */
    protected function createNewSettingGroupInstance() : SettingGroupContract
    {
        return new class extends AbstractSettingGroup {
        };
    }

    /**
     * Saves the settings values to database.
     *
     * @param SettingGroupContract $generalSettings
     * @return SettingGroupContract
     */
    public function save(SettingGroupContract $generalSettings) : SettingGroupContract
    {
        $this->getOptionsSettingsDataStore($generalSettings->getId())->save($generalSettings);

        return $generalSettings;
    }

    /**
     * Gets the options settings data store for the setting.
     *
     * @param string $settingId
     * @return OptionsSettingsDataStore
     */
    protected function getOptionsSettingsDataStore(string $settingId) : OptionsSettingsDataStore
    {
        return new OptionsSettingsDataStore($this->getOptionNameTemplate($settingId));
    }

    /**
     * Gets the option name template.
     *
     * @param string $settingId
     * @return string
     */
    protected function getOptionNameTemplate(string $settingId) : string
    {
        return 'mwc_'.$settingId.'_'.OptionsSettingsDataStore::SETTING_ID_MERGE_TAG;
    }
}
