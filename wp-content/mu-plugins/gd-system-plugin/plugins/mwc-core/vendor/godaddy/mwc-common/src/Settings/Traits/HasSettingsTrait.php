<?php

namespace GoDaddy\WordPress\MWC\Common\Settings\Traits;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingContract;
use InvalidArgumentException;

/**
 * Trait for classes that have settings.
 *
 * @since 3.4.1
 */
trait HasSettingsTrait
{
    /** @var SettingContract[]|null */
    protected $settings;

    /**
     * Gets the settings configuration.
     *
     * @since 3.4.1
     *
     * @return array
     */
    public function getConfiguration() : array
    {
        $configuration = [];

        foreach ($this->getSettings() as $setting) {
            $configuration[$setting->getName()] = $setting->getValue();
        }

        return $configuration;
    }

    /**
     * Gets the initial settings.
     *
     * Classes can override this to return their own settings objects.
     *
     * @since 3.4.1
     *
     * @return SettingContract[]
     */
    protected function getInitialSettings() : array
    {
        return [];
    }

    /**
     * Gets a setting.
     *
     * @since 3.4.1
     *
     * @param string $name
     * @return SettingContract
     * @throws InvalidArgumentException
     */
    public function getSetting(string $name) : SettingContract
    {
        foreach ($this->getSettings() as $setting) {

            if ($name === $setting->getName()) {
                return $setting;
            }
        }

        throw new InvalidArgumentException(sprintf(
            __('%s is not a valid setting.', 'mwc-core'),
            $name
        ));
    }

    /**
     * Gets the settings objects.
     *
     * @since 3.4.1
     *
     * @return SettingContract[]
     */
    public function getSettings() : array
    {
        // load the settings objects if not loaded previously
        if (null === $this->settings) {
            $this->settings = $this->getInitialSettings();
        }

        return $this->settings;
    }

    /**
     * Gets a setting's value.
     *
     * @since 3.4.1
     *
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getSettingValue(string $name)
    {
        return $this->getSetting($name)->getValue();
    }

    /**
     * Updates a setting's value.
     *
     * Will validate a value to be set against the setting type and any options, if set.
     *
     * @since 3.4.1
     *
     * @param string $name
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    public function updateSettingValue(string $name, $value)
    {
        $setting = $this->getSetting($name);
        $settingType = $setting->getType();
        $valueType = gettype($value);

        if ($settingType !== $valueType) {
            throw new InvalidArgumentException(sprintf(
                __('Invalid value for updating %1$s: must be a type of %2$s (type of %1$s used instead).', 'mwc-core'),
                $setting->getLabel() ?: get_class($this),
                $settingType,
                $valueType
            ));
        }

        $options = $setting->getOptions();

        if (! empty($options) && ! ArrayHelper::contains($options, $value)) {
            throw new InvalidArgumentException(sprintf(
                __('Invalid value for updating %s: must be one of the allowed options.', 'mwc-core'),
                $setting->getLabel() ?: get_class($this)
            ));
        }

        $setting->setValue($value);
    }

    /**
     * Sets the settings objects.
     *
     * @param SettingContract[] $value
     * @return self
     * @throws InvalidArgumentException
     */
    public function setSettings(array $value)
    {
        foreach ($value as $instance) {
            if (! is_a($instance, SettingContract::class, true)) {
                throw new InvalidArgumentException(__('The settings objects must be an instance of SettingContract', 'mwc-core'));
            }
        }
        $this->settings = $value;

        return $this;
    }
}
