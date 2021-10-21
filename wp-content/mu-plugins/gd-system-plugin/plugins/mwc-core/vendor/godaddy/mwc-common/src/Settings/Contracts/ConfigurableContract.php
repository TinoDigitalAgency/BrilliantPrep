<?php

namespace GoDaddy\WordPress\MWC\Common\Settings\Contracts;

/**
 * A contract for objects that can be configured (and hold settings).
 *
 * @since 3.4.1
 */
interface ConfigurableContract
{
    /**
     * Gets the settings.
     *
     * @since 3.4.1
     *
     * @return SettingContract[]
     */
    public function getSettings() : array;

    /**
     * Gets a setting by its name.
     *
     * @since 3.4.1
     *
     * @param string $name
     * @return SettingContract
     */
    public function getSetting(string $name) : SettingContract;

    /**
     * Updates a setting value.
     *
     * @since 3.4.1
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function updateSettingValue(string $name, $value);

    /**
     * Gets a setting value.
     *
     * @since 3.4.1
     *
     * @param string $name
     * @return mixed
     */
    public function getSettingValue(string $name);

    /**
     * Gets the object's configuration as an array with setting names as keys and setting values as values.
     *
     * @since 3.4.1
     *
     * @return array
     */
    public function getConfiguration() : array;

    /**
     * Sets the settings.
     *
     * @param SettingContract[] $value
     * @return self
     */
    public function setSettings(array $value);
}
