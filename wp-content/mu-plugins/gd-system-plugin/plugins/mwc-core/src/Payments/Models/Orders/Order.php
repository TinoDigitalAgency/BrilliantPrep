<?php

namespace GoDaddy\WordPress\MWC\Core\Payments\Models\Orders;

use GoDaddy\WordPress\MWC\Common\Models\Orders\Order as CommonOrder;

/**
 * Core order object.
 *
 * @since 2.10.0
 */
class Order extends CommonOrder
{
    /** @var bool whether the payment for the order is captured */
    protected $captured = false;

    /** @var string customer email address */
    protected $emailAddress;

    /** @var bool whether the the order is ready to have a payment captured */
    protected $readyForCapture = false;

    /**
     * Gets the customer's email address.
     *
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Sets the customer's email address.
     *
     * @return self
     */
    public function setEmailAddress(string $value) : Order
    {
        $this->emailAddress = $value;

        return $this;
    }

    /**
     * Sets a flag whether the payment for the order has been captured.
     *
     * @since 2.10.0
     *
     * @param bool $value
     * @return self
     */
    public function setCaptured(bool $value) : Order
    {
        $this->captured = $value;

        return $this;
    }

    /**
     * Determines whether the payment for the order was captured.
     *
     * @since 2.10.0
     *
     * @return bool
     */
    public function isCaptured() : bool
    {
        return $this->captured;
    }

    /**
     * Sets whether the order is ready to have its payment captured.
     *
     * @since 2.10.0
     *
     * @param bool $value
     * @return self
     */
    public function setReadyForCapture(bool $value) : Order
    {
        $this->readyForCapture = $value;

        return $this;
    }

    /**
     * Determines whether the order is ready to have its payment captured.
     *
     * @since 2.10.0
     *
     * @return bool
     */
    public function isReadyForCapture() : bool
    {
        return $this->readyForCapture;
    }
}
