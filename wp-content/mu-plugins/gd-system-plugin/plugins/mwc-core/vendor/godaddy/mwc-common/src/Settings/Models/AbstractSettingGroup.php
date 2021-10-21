<?php

namespace GoDaddy\WordPress\MWC\Common\Settings\Models;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingGroupContract;
use GoDaddy\WordPress\MWC\Common\Settings\Traits\HasSettingsTrait;
use GoDaddy\WordPress\MWC\Common\Traits\HasLabelTrait;
use InvalidArgumentException;

/**
 * An abstract class for setting groups.
 */
abstract class AbstractSettingGroup implements SettingGroupContract
{
    use HasLabelTrait;
    use HasSettingsTrait;

    /** @var string identifier */
    protected $id;

    /** @var SettingGroupContract|null parent group */
    protected $parent;

    /** @var SettingGroupContract[] sub groups */
    protected $subgroups = [];

    /**
     * Gets the setting group ID.
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Gets the parent setting group.
     *
     * @return SettingGroupContract|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Gets the setting subgroups.
     *
     * @return SettingGroupContract[]
     */
    public function getSubgroups() : array
    {
        return $this->subgroups;
    }

    /**
     * Gets a subgroup.
     *
     * @param string $identifier
     * @return SettingGroupContract
     * @throws InvalidArgumentException
     */
    public function getSubgroup(string $identifier) : SettingGroupContract
    {
        foreach ($this->getSubgroups() as $subgroup) {
            if ($identifier === $subgroup->getId()) {
                return $subgroup;
            }
        }

        throw new InvalidArgumentException(sprintf(
            __('%s is not a valid subgroup.', 'mwc-core'),
            $identifier
        ));
    }

    /**
     * Adds a subgroup.
     *
     * @param SettingGroupContract $value
     * @return self
     */
    public function addSubgroup(SettingGroupContract $value) : AbstractSettingGroup
    {
        $this->subgroups[] = $value;

        return $this;
    }

    /**
     * Sets the group ID.
     *
     * @param string $value
     * @return self;
     */
    public function setId(string $value) : SettingGroupContract
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Sets the parent setting group.
     *
     * @param SettingGroupContract $value
     * @return SettingGroupContract
     */
    public function setParent(SettingGroupContract $value) : SettingGroupContract
    {
        $this->parent = $value;

        return $this;
    }

    /**
     * Sets the setting subgroups.
     *
     * @param array $value
     * @return SettingGroupContract
     */
    public function setSubgroups(array $value) : SettingGroupContract
    {
        $this->subgroups = $value;

        return $this;
    }
}
