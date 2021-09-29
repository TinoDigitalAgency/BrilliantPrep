<?php

namespace GoDaddy\WordPress\MWC\Common\Models\Orders;

use GoDaddy\WordPress\MWC\Common\Models\CurrencyAmount;
use GoDaddy\WordPress\MWC\Common\Traits\FulfillableTrait;

/**
 * A representation of a line Item in an order.
 *
 * @since 3.4.1
 */
class LineItem extends AbstractOrderItem
{
    use FulfillableTrait;

    /** @var int|float the line item's quantity */
    protected $quantity;

    /** @var CurrencyAmount the line item's total tax amount */
    protected $taxAmount;

    /**
     * Gets the line item amount.
     *
     * @since 3.4.1
     *
     * @return int|float
     */
    public function getQuantity() : float
    {
        return $this->quantity;
    }

    /**
     * Gets the line item tax total amount.
     *
     * @since 3.4.1
     *
     * @return CurrencyAmount
     */
    public function getTaxAmount() : CurrencyAmount
    {
        return $this->taxAmount;
    }

    /**
     * Sets the line item quantity.
     *
     * @since 3.4.1
     *
     * @param int|float $quantity
     * @return LineItem
     */
    public function setQuantity(float $quantity) : LineItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Sets the line item tax total amount.
     *
     * @since 3.4.1
     *
     * @param CurrencyAmount $taxAmount
     * @return LineItem
     */
    public function setTaxAmount(CurrencyAmount $taxAmount) : LineItem
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }
}
