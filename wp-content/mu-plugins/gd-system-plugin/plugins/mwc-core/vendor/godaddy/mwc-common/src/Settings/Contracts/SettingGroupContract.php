<?php

namespace GoDaddy\WordPress\MWC\Common\Settings\Contracts;

use GoDaddy\WordPress\MWC\Common\Contracts\HasLabelContract;

/**
 * The contract for a setting group.
 *
 * @since 3.4.1
 */
interface SettingGroupContract extends ConfigurableContract, HasLabelContract
{
    /**
     * Gets the ID.
     *
     * @return string
     */
    public function getId() : string;

    /**
     * Gets the parent setting group.
     *
     * @return SettingGroupContract|null
     */
    public function getParent();

    /**
     * Gets the subgroups.
     *
     * @return SettingGroupContract[]
     */
    public function getSubgroups() : array;

    /**
     * Gets a subgroup.
     *
     * @param string $identifier
     * @return SettingGroupContract
     */
    public function getSubgroup(string $identifier) : SettingGroupContract;

    /**
     * Adds a subgroup.
     *
     * @param SettingGroupContract $value
     * @return self
     */
    public function addSubgroup(SettingGroupContract $value);

    /**
     * Sets the ID.
     *
     * @param string $value
     * @return self
     */
    public function setId(string $value);

    /**
     * Sets the parent setting group.
     *
     * @param SettingGroupContract $value
     * @return self
     */
    public function setParent(SettingGroupContract $value);

    /**
     * Sets the subgroups.
     *
     * @param SettingGroupContract[] $value
     * @return self
     */
    public function setSubgroups(array $value);
}
