<?php

namespace GoDaddy\WordPress\MWC\Common\Traits;

/**
 * A trait for objects that handle payments.
 *
 * @since 3.4.1
 */
trait PayableTrait
{
    /** @var string payment status */
    protected $paymentStatus;

    /**
     * Gets the payment status.
     *
     * @since 3.4.1
     *
     * @return string
     */
    public function getPaymentStatus() : string
    {
        return is_string($this->paymentStatus) ? $this->paymentStatus : '';
    }

    /**
     * Sets the payment status.
     *
     * @since 3.4.1
     *
     * @param string $status
     * @return self
     */
    public function setPaymentStatus(string $status)
    {
        $this->paymentStatus = $status;

        return $this;
    }
}
