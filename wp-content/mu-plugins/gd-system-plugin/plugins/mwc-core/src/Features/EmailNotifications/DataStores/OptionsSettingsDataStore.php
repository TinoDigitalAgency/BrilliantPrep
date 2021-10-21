<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataStores;

use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\ConfigurableContract;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingContract;
use GoDaddy\WordPress\MWC\Common\Settings\Models\Setting;
use InvalidArgumentException;

/**
 * Data store for email notifications options settings.
 *
 * @since 2.15.0
 */
class OptionsSettingsDataStore
{
    /** @var string */
    const SETTING_ID_MERGE_TAG = '{{setting_id}}';

    /** @var string a placeholder used to format option names */
    private $optionNameTemplate;

    /**
     * Options settings data store constructor.
     *
     * @since 2.15.0
     *
     * @param string $optionNameTemplate
     * @throws InvalidArgumentException
     */
    public function __construct(string $optionNameTemplate)
    {
        if (! StringHelper::contains($optionNameTemplate, static::SETTING_ID_MERGE_TAG)) {
            throw new InvalidArgumentException(sprintf(
                __('Invalid option name template "%s": it should contain a {{setting_id}} placeholder.', 'mwc-core'),
                $optionNameTemplate
            ));
        }

        $this->optionNameTemplate = $optionNameTemplate;
    }

    /**
     * Reads the values of the options settings from database.
     *
     * @since 2.15.0
     *
     * @param ConfigurableContract $options
     * @return ConfigurableContract
     * @throws InvalidArgumentException
     */
    public function read(ConfigurableContract $options) : ConfigurableContract
    {
        foreach ($options->getSettings() as $setting) {

            $value = get_option($this->getOptionName($setting), null);

            if (null === $value) {
                continue;
            }

            if ($setting->isMultivalued()) {
                $value = array_map(function($value) use($setting) {
                    return $this->formatValueFromDatabase($value, $setting);
                }, ArrayHelper::wrap($value));
            } else {
                $value = $this->formatValueFromDatabase($value, $setting);
            }

            $setting->setValue($value);
        }

        return $options;
    }

    /**
     * Saves the options settings values to database.
     *
     * @since 2.15.0
     *
     * @param ConfigurableContract $options
     * @return ConfigurableContract
     * @throws InvalidArgumentException
     */
    public function save(ConfigurableContract $options) : ConfigurableContract
    {
        foreach ($options->getSettings() as $setting) {

            if (! $setting->hasValue()) {
                continue;
            }

            $value = $setting->getValue();

            if ($setting->isMultivalued()) {
                $value = array_map(function($value) use($setting) {
                    return $this->formatValueForDatabase($value, $setting);
                }, ArrayHelper::wrap($value));
            } else {
                $value = $this->formatValueForDatabase($value, $setting);
            }

            update_option($this->getOptionName($setting), $value);
        }

        return $options;
    }

    /**
     * Deletes the options settings values from database.
     *
     * @since 2.15.0
     *
     * @param ConfigurableContract $options
     * @return ConfigurableContract
     */
    public function delete(ConfigurableContract $options) : ConfigurableContract
    {
        foreach ($options->getSettings() as $setting) {
            delete_option($this->getOptionName($setting));
            $setting->setValue($setting->getDefault());
        }

        return $options;
    }

    /**
     * Gets an option name for a given setting.
     *
     * @since 2.15.0
     *
     * @param SettingContract $setting
     * @return string
     */
    protected function getOptionName(SettingContract $setting) : string
    {
        return StringHelper::replaceFirst($this->optionNameTemplate, static::SETTING_ID_MERGE_TAG, $setting->getId());
    }

    /**
     * Formats a value for storage handling.
     *
     * @since x.y.z
     *
     * @param mixed $value
     * @param SettingContract $setting
     * @return bool|float|int|string
     * @throws InvalidArgumentException
     */
    protected function formatValue($value, SettingContract $setting)
    {
        switch($setting->getType()) {
            case Setting::TYPE_FLOAT :
                $value = (float) $value;
                break;
            case Setting::TYPE_INTEGER :
                $value = (int) $value;
                break;
            case Setting::TYPE_EMAIL :
            case Setting::TYPE_STRING :
            case Setting::TYPE_URL :
                $value = (string) $value;
                break;
            case Setting::TYPE_BOOLEAN :
                throw new InvalidArgumentException(sprintf(
                    __('Please use %1$s or %2$s to format a boolean value for reading from or saving to storage.', 'mwc-core'),
                    __CLASS__.'::boolToString()',
                    __CLASS__.'::stringToBool()'
                ));
        }

        return $value;
    }

    /**
     * Converts a setting value from database for setting type consistency.
     *
     * @since x.y.z
     *
     * @param bool|float|int|string $value
     * @param SettingContract $setting
     * @return bool|float|int|string
     * @throws InvalidArgumentException
     */
    protected function formatValueFromDatabase($value, SettingContract $setting)
    {
        if (Setting::TYPE_BOOLEAN === $setting->getType()) {
            return $this->stringToBool($value);
        }

        return $this->formatValue($value, $setting);
    }

    /**
     * Converts a setting value for database storage.
     *
     * @since x.y.z
     *
     * @param bool|int|float|string $value
     * @param SettingContract $setting
     * @return bool|float|int|string
     * @throws InvalidArgumentException
     */
    protected function formatValueForDatabase($value, SettingContract $setting)
    {
        if (Setting::TYPE_BOOLEAN === $setting->getType()) {
            return $this->boolToString($value);
        }

        return $this->formatValue($value, $setting);
    }

    /**
     * Converts a string or numerical value to boolean for storage use.
     *
     * @see wc_string_to_bool() for a WooCommerce equivalent
     *
     * @since x.y.z
     *
     * @param string|int|bool $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function stringToBool($value) : bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return 1 === $value;
        }

        if (is_string($value)) {
            return '1' === $value || 'yes' === strtolower($value) || 'true' === strtolower($value);
        }

        throw new InvalidArgumentException(sprintf(
            __('Cannot handle a "%s" type to parse a valid boolean value.', 'mwc-core'),
            gettype($value)
        ));
    }

    /**
     * Converts a boolean value to string value for storage use.
     *
     * @see wc_bool_to_string() for a WooCommerce equivalent
     *
     * @since x.y.z
     *
     * @param string|int|bool $value
     * @return string
     * @throws InvalidArgumentException
     */
    protected function boolToString($value) : string
    {
        if (! is_bool($value)) {
            $value = $this->stringToBool($value);
        }

        return true === $value ? 'yes' : 'no';
    }
}
