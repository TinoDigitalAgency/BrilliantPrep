<?php

namespace GoDaddy\WordPress\MWC\Common\Settings\Contracts;

use GoDaddy\WordPress\MWC\Common\Contracts\HasLabelContract;

/**
 * An interface for object representations of setting controls.
 */
interface ControlContract extends HasLabelContract
{
    /**
     * Gets the control ID.
     *
     * @return string|null
     */
    public function getId();

    /**
     * Gets the control type.
     *
     * @return string|null
     */
    public function getType();

    /**
     * Gets the control description.
     *
     * @return string
     */
    public function getDescription() : string;

    /**
     * Gets the control options.
     *
     * @return array
     */
    public function getOptions() : array;

    /**
     * Sets the control ID.
     *
     * @param string $value
     * @return self
     */
    public function setId(string $value) : ControlContract;

    /**
     * Sets the control type.
     *
     * @param string $value
     * @return self
     */
    public function setType(string $value) : ControlContract;

    /**
     * Sets the control description.
     *
     * @param string $value
     * @return self
     */
    public function setDescription(string $value) : ControlContract;

    /**
     * Sets the control options.
     *
     * @param array $value
     * @return self
     */
    public function setOptions(array $value) : ControlContract;
}
