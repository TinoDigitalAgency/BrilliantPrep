<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\DataProviders;

use DateTime;
use Exception;
use GoDaddy\WordPress\MWC\Common\DataSources\WooCommerce\Adapters\Order\OrderAdapter;
use GoDaddy\WordPress\MWC\Common\Models\Address;
use GoDaddy\WordPress\MWC\Common\Models\CurrencyAmount;
use GoDaddy\WordPress\MWC\Common\Models\Orders\LineItem;
use GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses\ProcessingOrderStatus;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\DataProviderContract;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\Contracts\OrderEmailNotificationContract;
use GoDaddy\WordPress\MWC\Core\Payments\Models\Orders\Order;
use WC_Order;

/**
 * The order data provider for email notifications with order-related placeholders.
 */
class OrderDataProvider implements DataProviderContract
{
    /** @var OrderEmailNotificationContract */
    protected $emailNotification;

    /**
     * Constructor.
     *
     * @param OrderEmailNotificationContract $emailNotification
     */
    public function __construct(OrderEmailNotificationContract $emailNotification)
    {
        $this->emailNotification = $emailNotification;
    }

    /**
     * Gets the data.
     *
     * @return array
     */
    public function getData() : array
    {
        $order = $this->getOrder();
        $billingAddress = $order->getBillingAddress();
        $createdAt = $order->getCreatedAt();

        return [
            'order_number' => $order->getNumber(),
            'order_date' => $createdAt ? $this->getFormattedDateTime($createdAt) : '',
            'order_billing_full_name' => trim($billingAddress->getFirstName().' '.$billingAddress->getLastName()),
        ];
    }

    /**
     * Gets the order.
     *
     * @return Order
     */
    protected function getOrder() : Order
    {
        return $this->emailNotification->getOrder();
    }

    /**
     * Gets an order adapter instance.
     *
     * @return OrderAdapter
     */
    protected function getOrderAdapter() : OrderAdapter
    {
        return new OrderAdapter(new WC_Order());
    }

    /**
     * Gets a WooCommerce order for the given order.
     *
     * @param Order $order
     * @return WC_Order
     * @throws Exception
     */
    protected function getWooCommerceOrder(Order $order) : WC_Order
    {
        return $this->getOrderAdapter()->convertToSource($order);
    }

    /**
     * Gets a dummy order for generating preview data.
     *
     * @return Order
     */
    protected function getPreviewOrder() : Order
    {
        $billingAddress = (new Address())
            ->setFirstname('John')
            ->setLastName('Doe')
            ->setBusinessName('John Doe Co.')
            ->setCountryCode('US')
            ->setPostalCode('1234')
            ->setAdministrativeDistricts(['MA'])
            ->setLocality('Springfield')
            ->setLines(['Main Avenue 1']);
        $shippingAddress = clone $billingAddress;
        $lineItems = [
            (new LineItem())
                ->setName('product-a')
                ->setLabel('Product A')
                ->setQuantity(1)
                ->setNeedsShipping(true)
                ->setTotalAmount(
                    (new CurrencyAmount())
                        ->setAmount(10)
                        ->setCurrencyCode('USD'))
                ->setTaxAmount(
                    (new CurrencyAmount())
                        ->setAmount(1)
                        ->setCurrencyCode('USD')),
            (new LineItem())
                ->setName('product-b')
                ->setLabel('Product B')
                ->setQuantity(2)
                ->setNeedsShipping(true)
                ->setTotalAmount(
                    (new CurrencyAmount())
                        ->setAmount(20)
                        ->setCurrencyCode('USD'))
                ->setTaxAmount(
                    (new CurrencyAmount())
                        ->setAmount(2)
                        ->setCurrencyCode('USD'))];

        return (new Order)
            ->setId(123)
            ->setNumber('1000001ABC')
            ->setStatus(new ProcessingOrderStatus())
            ->setCreatedAt(new DateTime('now'))
            ->setCustomerIpAddress('192.168.0.1')
            ->setBillingAddress($billingAddress)
            ->setShippingAddress($shippingAddress)
            ->setLineItems($lineItems);
    }

    /**
     * Gets the known placeholders.
     *
     * @return string[]
     */
    public function getPlaceholders() : array
    {
        return array_keys($this->getData());
    }

    /**
     * Gets fake preview data.
     *
     * @return array
     */
    public function getPreviewData() : array
    {
        $previewOrder = $this->getPreviewOrder();

        return [
            'order_number' => $previewOrder->getNumber(),
            'order_date' => $this->getFormattedDateTime($previewOrder->getCreatedAt()),
            'order_billing_full_name' => $previewOrder->getBillingAddress()->getFirstName().' '.$previewOrder->getBillingAddress()->getLastName(),
        ];
    }

    /**
     * Gets a date & time, formatted for display.
     *
     * This is formatted according to WooCommerce's configured date format, localized to the site locale.
     *
     * TODO: update these raw WP/WC methods to our own once available in MWC Common {@cwiseman 2021-09-15}
     *
     * @param DateTime $dateTime
     * @return string
     */
    protected function getFormattedDateTime(DateTime $dateTime)
    {
        return date_i18n(wc_date_format(), $dateTime->getTimestamp() + $dateTime->getOffset());
    }
}
