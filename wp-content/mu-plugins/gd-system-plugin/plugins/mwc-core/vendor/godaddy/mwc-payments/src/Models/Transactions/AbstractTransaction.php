<?php

namespace GoDaddy\WordPress\MWC\Payments\Models\Transactions;

use DateTime;
use GoDaddy\WordPress\MWC\Common\Traits\CanBulkAssignPropertiesTrait;
use GoDaddy\WordPress\MWC\Common\Traits\CanConvertToArrayTrait;
use GoDaddy\WordPress\MWC\Payments\Contracts\TransactionStatusContract;
use GoDaddy\WordPress\MWC\Payments\Models\PaymentMethods\AbstractPaymentMethod;
use GoDaddy\WordPress\MWC\Payments\Models\Customer;
use GoDaddy\WordPress\MWC\Common\Models\Orders\Order;
use GoDaddy\WordPress\MWC\Common\Models\CurrencyAmount;

/**
 * The abstract transaction model.
 *
 * @since 0.1.0
 */
abstract class AbstractTransaction
{
    use CanConvertToArrayTrait;
    use CanBulkAssignPropertiesTrait;

    /** @var DateTime timestamp record was created */
    protected $createdAt;

    /** @var Customer */
    protected $customer;

    /** @var string notes */
    protected $notes;

    /** @var Order */
    protected $order;

    /** @var AbstractPaymentMethod */
    protected $paymentMethod;

    /** @var DateTime timestamp record was updated */
    protected $updatedAt;

    /** @var string remoteId */
    protected $remoteId;

    /** @var string remoteParentId */
    protected $remoteParentId;

    /** @var string resultCode */
    protected $resultCode;

    /** @var string resultMessage */
    protected $resultMessage;

    /** @var string resultMessage */
    protected $source;

    /** @var TransactionStatusContract */
    protected $status;

    /** @var CurrencyAmount */
    protected $totalAmount;

    /** @var string transaction type */
    protected $type;

    /** @var string provider name */
    protected $providerName;

    /**
     * Gets the date at which the transaction was created.
     *
     * @since 0.1.0
     *
     * @return DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets the customer object.
     *
     * @since 0.1.0
     *
     * @return Customer|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Gets the transaction notes.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Gets the order object.
     *
     * @since 0.1.0
     *
     * @return Order|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Gets the payment method object.
     *
     * @since 0.1.0
     *
     * @return AbstractPaymentMethod|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Gets the date at which the transaction was last updated.
     *
     * @since 0.1.0
     *
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Gets the remote ID.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * Gets the remote parent ID.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getRemoteParentId()
    {
        return $this->remoteParentId;
    }

    /**
     * Gets the result code.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * Gets the result message.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getResultMessage()
    {
        return $this->resultMessage;
    }

    /**
     * Gets the source.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Gets the status.
     *
     * @since 0.1.0
     *
     * @return TransactionStatusContract|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets the total amount.
     *
     * @since 0.1.0
     *
     * @return CurrencyAmount|null
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Gets the transaction type.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Gets the provider name.
     *
     * @since 0.1.0
     *
     * @return string|null
     */
    public function getProviderName()
    {
        return $this->providerName;
    }


    /**
     * Sets the date at which the transaction was created.
     *
     * @since 0.1.0
     *
     * @param DateTime $createdAt
     *
     * @return AbstractTransaction
     */
    public function setCreatedAt(DateTime $createdAt) : AbstractTransaction
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Sets the customer object.
     *
     * @since 0.1.0
     *
     * @param Customer $customer
     *
     * @return AbstractTransaction
     */
    public function setCustomer(Customer $customer) : AbstractTransaction
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Sets the notes.
     *
     * @since 0.1.0
     *
     * @param string $notes
     *
     * @return AbstractTransaction
     */
    public function setNotes(string $notes) : AbstractTransaction
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Sets the order object.
     *
     * @since 0.1.0
     *
     * @param Order $order
     *
     * @return AbstractTransaction
     */
    public function setOrder(Order $order) : AbstractTransaction
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Sets the payment method object.
     *
     * @since 0.1.0
     *
     * @param AbstractPaymentMethod $paymentMethod
     *
     * @return AbstractTransaction
     */
    public function setPaymentMethod(AbstractPaymentMethod $paymentMethod) : AbstractTransaction
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Sets the date at which the transaction was last updated.
     *
     * @since 0.1.0
     *
     * @param DateTime $updatedAt
     *
     * @return AbstractTransaction
     */
    public function setUpdatedAt(DateTime $updatedAt) : AbstractTransaction
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Sets the remote ID.
     *
     * @since 0.1.0
     *
     * @param string $remoteId
     *
     * @return AbstractTransaction
     */
    public function setRemoteId(string $remoteId) : AbstractTransaction
    {
        $this->remoteId = $remoteId;

        return $this;
    }

    /**
     * Sets the remote parent ID.
     *
     * @since 0.1.0
     *
     * @param string $remoteParentId
     *
     * @return AbstractTransaction
     */
    public function setRemoteParentId(string $remoteParentId) : AbstractTransaction
    {
        $this->remoteParentId = $remoteParentId;

        return $this;
    }

    /**
     * Sets the result code.
     *
     * @since 0.1.0
     *
     * @param string $resultCode
     *
     * @return AbstractTransaction
     */
    public function setResultCode(string $resultCode) : AbstractTransaction
    {
        $this->resultCode = $resultCode;

        return $this;
    }

    /**
     * Sets the result message.
     *
     * @since 0.1.0
     *
     * @param string $resultMessage
     *
     * @return AbstractTransaction
     */
    public function setResultMessage(string $resultMessage) : AbstractTransaction
    {
        $this->resultMessage = $resultMessage;

        return $this;
    }

    /**
     * Sets the source.
     *
     * @since 0.1.0
     *
     * @param string $source
     *
     * @return AbstractTransaction
     */
    public function setSource(string $source) : AbstractTransaction
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Sets the status.
     *
     * @since 0.1.0
     *
     * @param TransactionStatusContract $status
     *
     * @return AbstractTransaction
     */
    public function setStatus(TransactionStatusContract $status) : AbstractTransaction
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Sets the total amount.
     *
     * @since 0.1.0
     *
     * @param CurrencyAmount $totalAmount
     *
     * @return AbstractTransaction
     */
    public function setTotalAmount(CurrencyAmount $totalAmount) : AbstractTransaction
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Sets the provider name.
     *
     * @since 0.1.0
     *
     * @param string $value
     *
     * @return AbstractTransaction
     */
    public function setProviderName(string $value) : AbstractTransaction
    {
        $this->providerName = $value;

        return $this;
    }
}
