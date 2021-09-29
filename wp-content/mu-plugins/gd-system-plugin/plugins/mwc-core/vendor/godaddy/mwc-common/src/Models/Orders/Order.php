<?php

namespace GoDaddy\WordPress\MWC\Common\Models\Orders;

use DateTime;
use GoDaddy\WordPress\MWC\Common\Contracts\OrderStatusContract;
use GoDaddy\WordPress\MWC\Common\Models\CurrencyAmount;
use GoDaddy\WordPress\MWC\Common\Traits\BillableTrait;
use GoDaddy\WordPress\MWC\Common\Traits\FulfillableTrait;
use GoDaddy\WordPress\MWC\Common\Traits\PayableTrait;
use GoDaddy\WordPress\MWC\Common\Traits\ShippableTrait;

/**
 * Native order object.
 *
 * @since 3.4.1
 */
class Order
{
    use BillableTrait;
    use FulfillableTrait;
    use PayableTrait;
    use ShippableTrait;

    /** @var int|null */
    private $id;

    /** @var string|null */
    private $number;

    /** @var OrderStatusContract|null */
    private $status;

    /** @var DateTime|null date created */
    private $createdAt;

    /** @var DateTime|null date updated */
    private $updatedAt;

    /** @var int|null */
    private $customerId;

    /** @var string|null */
    private $customerIpAddress;

    /** @var LineItem[] */
    private $lineItems = [];

    /** @var CurrencyAmount|null */
    private $lineAmount;

    /** @var ShippingItem[] */
    private $shippingItems = [];

    /** @var CurrencyAmount|null */
    private $shippingAmount;

    /** @var FeeItem[] */
    private $feeItems = [];

    /** @var CurrencyAmount|null */
    private $feeAmount;

    /** @var TaxItem[] */
    private $taxItems = [];

    /** @var CurrencyAmount|null */
    private $taxAmount;

    /** @var CurrencyAmount|null */
    private $totalAmount;

    /**
     * Gets the order ID.
     *
     * @since 3.4.1
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the order number.
     *
     * @since 3.4.1
     *
     * @return string|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Gets the order status.
     *
     * @since 3.4.1
     *
     * @return OrderStatusContract|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets the date when the order was created.
     *
     * @since 3.4.1
     *
     * @return DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets the date when the order was last updated.
     *
     * @since 3.4.1
     *
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Gets the ID of the customer associated with the order.
     *
     * @since 3.4.1
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Gets the IP of the customer associated with the order.
     *
     * @since 3.4.1
     *
     * @return string|null
     */
    public function getCustomerIpAddress()
    {
        return $this->customerIpAddress;
    }

    /**
     * Gets the order line items.
     *
     * @since 3.4.1
     *
     * @return LineItem[]
     */
    public function getLineItems() : array
    {
        return $this->lineItems;
    }

    /**
     * Gets the line items amount.
     *
     * @since 3.4.1
     *
     * @return CurrencyAmount|null
     */
    public function getLineAmount()
    {
        return $this->lineAmount;
    }

    /**
     * Gets the order shipping items.
     *
     * @since 3.4.1
     *
     * @return ShippingItem[]
     */
    public function getShippingItems() : array
    {
        return $this->shippingItems;
    }

    /**
     * Gets the shipping items amount.
     *
     * @since 3.4.1
     *
     * @return CurrencyAmount|null
     */
    public function getShippingAmount()
    {
        return $this->shippingAmount;
    }

    /**
     * Gets the order fee items.
     *
     * @since 3.4.1
     *
     * @return FeeItem[]
     */
    public function getFeeItems() : array
    {
        return $this->feeItems;
    }

    /**
     * Gets the fee items amount.
     *
     * @since 3.4.1
     *
     * @return CurrencyAmount|null
     */
    public function getFeeAmount()
    {
        return $this->feeAmount;
    }

    /**
     * Gets the order tax items.
     *
     * @since 3.4.1
     *
     * @return TaxItem[]
     */
    public function getTaxItems() : array
    {
        return $this->taxItems;
    }

    /**
     * Gets the tax items amount.
     *
     * @since 3.4.1
     *
     * @return CurrencyAmount|null
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Gets the order total amount.
     *
     * @since 3.4.1
     *
     * @return CurrencyAmount|null
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Sets the order ID.
     *
     * @since 3.4.1
     *
     * @param int $value
     * @return self
     */
    public function setId(int $value) : Order
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Sets the order number.
     *
     * @since 3.4.1
     *
     * @param string $value
     * @return self
     */
    public function setNumber(string $value) : Order
    {
        $this->number = $value;

        return $this;
    }

    /**
     * Sets the order status.
     *
     * @since 3.4.1
     *
     * @param OrderStatusContract $value
     * @return self
     */
    public function setStatus(OrderStatusContract $value) : Order
    {
        $this->status = $value;

        return $this;
    }

    /**
     * Sets the date when the order was created.
     *
     * @since 3.4.1
     *
     * @param DateTime $value
     * @return self
     */
    public function setCreatedAt(DateTime $value) : Order
    {
        $this->createdAt = $value;

        return $this;
    }

    /**
     * Sets the date when the order was last updated.
     *
     * @since 3.4.1
     *
     * @param DateTime $value
     * @return self
     */
    public function setUpdatedAt(DateTime $value) : Order
    {
        $this->updatedAt = $value;

        return $this;
    }

    /**
     * Sets the ID of the customer associated with the order.
     *
     * @since 3.4.1
     *
     * @param int $value
     * @return self
     */
    public function setCustomerId(int $value) : Order
    {
        $this->customerId = $value;

        return $this;
    }

    /**
     * Sets the IP address of the customer associated with the order.
     *
     * @since 3.4.1
     *
     * @param string $value IP address
     * @return self
     */
    public function setCustomerIpAddress(string $value) : Order
    {
        $this->customerIpAddress = $value;

        return $this;
    }

    /**
     * Sets the order line items.
     *
     * @since 3.4.1
     *
     * @param LineItem[] $value
     *
     * @return self
     */
    public function setLineItems(array $value) : Order
    {
        $this->lineItems = $value;

        return $this;
    }

    /**
     * Sets the line items amount.
     *
     * @since 3.4.1
     *
     * @param CurrencyAmount $value
     * @return self
     */
    public function setLineAmount(CurrencyAmount $value) : Order
    {
        $this->lineAmount = $value;

        return $this;
    }

    /**
     * Sets the order shipping items.
     *
     * @since 3.4.1
     *
     * @param ShippingItem[] $value
     * @return self
     */
    public function setShippingItems(array $value) : Order
    {
        $this->shippingItems = $value;

        return $this;
    }

    /**
     * Sets the shipping items amount.
     *
     * @since 3.4.1
     *
     * @param CurrencyAmount $value
     * @return self
     */
    public function setShippingAmount(CurrencyAmount $value) : Order
    {
        $this->shippingAmount = $value;

        return $this;
    }

    /**
     * Sets the order fee items.
     *
     * @since 3.4.1
     *
     * @param FeeItem[] $value
     * @return self
     */
    public function setFeeItems(array $value) : Order
    {
        $this->feeItems = $value;

        return $this;
    }

    /**
     * Sets the fee items amount.
     *
     * @since 3.4.1
     *
     * @param CurrencyAmount $value
     * @return self
     */
    public function setFeeAmount(CurrencyAmount $value) : Order
    {
        $this->feeAmount = $value;

        return $this;
    }

    /**
     * Sets the order tax items.
     *
     * @since 3.4.1
     *
     * @param TaxItem[] $value
     * @return self
     */
    public function setTaxItems(array $value) : Order
    {
        $this->taxItems = $value;

        return $this;
    }

    /**
     * Sets the tax items amount.
     *
     * @since 3.4.1
     *
     * @param CurrencyAmount $value
     * @return self
     */
    public function setTaxAmount(CurrencyAmount $value) : Order
    {
        $this->taxAmount = $value;

        return $this;
    }

    /**
     * Sets the order total amount.
     *
     * @since 3.4.1
     *
     * @param CurrencyAmount $value
     * @return self
     */
    public function setTotalAmount(CurrencyAmount $value) : Order
    {
        $this->totalAmount = $value;

        return $this;
    }
}
