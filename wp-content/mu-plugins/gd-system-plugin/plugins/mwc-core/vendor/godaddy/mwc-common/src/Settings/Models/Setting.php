<?php

namespace GoDaddy\WordPress\MWC\Common\Settings\Models;

use Exception;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\ValidationHelper;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\ControlContract;
use GoDaddy\WordPress\MWC\Common\Settings\Contracts\SettingContract;
use GoDaddy\WordPress\MWC\Common\Traits\CanConvertToArrayTrait;
use GoDaddy\WordPress\MWC\Common\Traits\HasLabelTrait;
use InvalidArgumentException;
use ReflectionClass;

/**
 * An object model for representing a setting.
 */
class Setting implements SettingContract
{
    use CanConvertToArrayTrait;
    use HasLabelTrait;

    /** @var string the string setting type */
    const TYPE_STRING = 'string';

    /** @var string the URL setting type */
    const TYPE_URL = 'url';

    /** @var string the email setting type */
    const TYPE_EMAIL = 'email';

    /** @var string the integer setting type */
    const TYPE_INTEGER = 'integer';

    /** @var string the float setting type */
    const TYPE_FLOAT = 'float';

    /** @var string the boolean setting type */
    const TYPE_BOOLEAN = 'boolean';

    /** @var string unique setting ID */
    protected $id;

    /** @var string setting type */
    protected $type;

    /** @var string setting description */
    protected $description = '';

    /** @var array valid setting options */
    protected $options = [];

    /** @var int|float|string|bool|array|null setting default value */
    protected $default;

    /** @var int|float|string|bool|array|null setting current value */
    protected $value;

    /** @var ControlContract control object */
    protected $control;

    /** @var bool whether the setting holds an array of multiple values */
    protected $isMultivalued = false;

    /** @var bool settings required value */
    protected $isRequired = false;

    /**
     * Gets the setting id.
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Gets the setting type.
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Gets the setting description.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Gets the setting options.
     *
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * Gets the setting default value.
     *
     * @return int|float|string|bool|array|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Gets the setting value.
     *
     * @return int|float|string|bool|array|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets the setting's control instance.
     *
     * @return ControlContract
     */
    public function getControl() : ControlContract
    {
        return $this->control;
    }

    /**
     * Determines whether the setting is multivalued.
     *
     * @return bool
     */
    public function isMultivalued() : bool
    {
        return $this->isMultivalued;
    }

    /**
     * Determines whether the setting is a required setting.
     *
     * @return bool
     */
    public function isRequired() : bool
    {
        return $this->isRequired;
    }

    /**
     * Determines whether Setting has a value.
     *
     * @return bool
     */
    public function hasValue() : bool
    {
        return null !== $this->getValue();
    }

    /**
     * Sets the setting id.
     *
     * @param string $value
     * @return self
     */
    public function setId(string $value) : Setting
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Sets the setting type.
     *
     * @param string $value
     * @return self
     */
    public function setType(string $value) : Setting
    {
        $allowedTypes = $this->getAllowedTypes();

        if (! ArrayHelper::contains($allowedTypes, $value)) {
            throw new InvalidArgumentException(sprintf(
                __('Invalid value for updating the setting type of %1s: must be one of %2$s, %3$s given.', 'mwc-core'),
                $this->getLabel() ?: get_class($this),
                implode(', ', $allowedTypes),
                $value
            ));
        }

        $this->type = $value;

        return $this;
    }

    /**
     * Gets a list of allowed setting types.
     *
     * @return string[]
     */
    protected function getAllowedTypes() : array
    {
        $allowedTypes = [];
        $constants = (new ReflectionClass($this))->getConstants();

        foreach ($constants as $key => $value) {
            if (StringHelper::startsWith($key, 'TYPE_')) {
                $allowedTypes[] = $value;
            }
        }

        return $allowedTypes;
    }

    /**
     * Sets the setting description.
     *
     * @param string $value
     * @return self
     */
    public function setDescription(string $value) : Setting
    {
        $this->description = $value;

        return $this;
    }

    /**
     * Sets the setting options.
     *
     * @param array $value
     * @return self
     * @throws InvalidArgumentException
     */
    public function setOptions(array $value) : Setting
    {
        foreach ($value as $option) {
            try {
                $this->validateValue($option);
            } catch (Exception $e) {
                throw new InvalidArgumentException(
                    sprintf(__('Invalid option to set for %1$s: %2$s', 'mwc-core'),
                        $this->getLabel() ?: get_class($this),
                        $e->getMessage()
                    )
                );
            }
        }

        $this->options = $value;

        return $this;
    }

    /**
     * Sets the setting default.
     *
     * @param int|float|string|bool|array $value
     * @return self
     * @throws InvalidArgumentException
     */
    public function setDefault($value) : Setting
    {
        $value = $this->isMultivalued() ? ArrayHelper::wrap($value) : $value;

        try {
            $this->isMultivalued()
                ? array_walk($value, [$this, 'validateValue'])
                : $this->validateValue($value);
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf(__('Invalid default value to set for %1$s: %2$s', 'mwc-core'),
                    $this->getLabel() ?: get_class($this),
                    lcfirst($e->getMessage())
                )
            );
        }

        $this->default = $value;

        return $this;
    }

    /**
     * Sets the setting value.
     *
     * @param int|float|string|bool|array $value
     * @return self
     * @throws InvalidArgumentException
     */
    public function setValue($value) : Setting
    {
        $value = $this->isMultivalued() ? ArrayHelper::wrap($value) : $value;

        try {
            $this->isMultivalued()
                ? array_walk($value, [$this, 'validateValue'])
                : $this->validateValue($value);
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf(__('Invalid value to set for %1$s: %2$s', 'mwc-core'),
                    $this->getLabel() ?: get_class($this),
                    lcfirst($e->getMessage())
                )
            );
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Sets whether the setting is multivalued.
     *
     * @param bool $value
     * @return self
     */
    public function setIsMultivalued(bool $value) : Setting
    {
        $this->isMultivalued = $value;

        return $this;
    }

    /**
     * Sets whether the setting is required.
     *
     * @param bool $value
     * @return self
     */
    public function setIsRequired(bool $value) : Setting
    {
        $this->isRequired = $value;

        return $this;
    }

    /**
     * Sets a control instance for the setting.
     *
     * @param ControlContract $value
     * @return self
     */
    public function setControl(ControlContract $value) : Setting
    {
        $this->control = $value;

        return $this;
    }

    /**
     * Validates a setting value according to its type.
     *
     * @param mixed $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validateValue($value) : bool
    {
        $type = $this->getType();
        $typeName = ucfirst($type);
        $validateMethod = "validate{$typeName}Value";

        if (is_callable([$this, $validateMethod]) && ! $this->$validateMethod($value)) {

            if (static::TYPE_EMAIL === $type || static::TYPE_URL === $type) {
                $invalidType = is_string($value) ? $value : gettype($value);
            } else {
                $invalidType = gettype($value);
            }

            throw new InvalidArgumentException(sprintf(
                __('Value should be type of %1$s, %2$s given.', 'mwc-core'),
                $type,
                $invalidType
            ));
        }

        return true;
    }

    /**
     * Validates an email value.
     *
     * @param mixed $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validateEmailValue($value) : bool
    {
        return ValidationHelper::isEmail($value);
    }

    /**
     * Validates a URL value.
     *
     * @param mixed $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validateUrlValue($value) : bool
    {
        return ValidationHelper::isUrl($value);
    }

    /**
     * Validates a string value.
     *
     * @param mixed $value
     * @return bool
     */
    protected function validateStringValue($value) : bool
    {
        return is_string($value);
    }

    /**
     * Validates an integer value.
     *
     * @param mixed $value
     * @return bool
     */
    protected function validateIntegerValue($value) : bool
    {
        return is_int($value);
    }

    /**
     * Validates a float value.
     *
     * @param mixed $value
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validateFloatValue($value) : bool
    {
        return is_int($value) || is_float($value);
    }

    /**
     * Validates a boolean value.
     *
     * @param mixed $value
     * @return bool
     */
    protected function validateBooleanValue($value) : bool
    {
        return is_bool($value);
    }
}
