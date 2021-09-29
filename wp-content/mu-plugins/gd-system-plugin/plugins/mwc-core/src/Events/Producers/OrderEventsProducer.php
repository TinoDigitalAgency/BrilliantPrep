<?php

namespace GoDaddy\WordPress\MWC\Core\Events\Producers;

use GoDaddy\WordPress\MWC\Common\Events\Contracts\ProducerContract;
use Exception;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\WooCommerce\OrdersRepository;
use GoDaddy\WordPress\MWC\Core\Events\OrderCreatedEvent;
use GoDaddy\WordPress\MWC\Core\Events\OrderUpdatedEvent;
use WC_Order;

class OrderEventsProducer implements ProducerContract
{
    /**
     * Sets up the Coupon events producer.
     *
     * @since 2.14.0
     *
     * @throws Exception
     */
    public function setup()
    {
        Register::action()
            ->setGroup('woocommerce_checkout_order_created')
            ->setHandler([$this, 'maybeFireOrderCreatedEventFromCheckout'])
            ->execute();

        Register::action()
            ->setGroup('woocommerce_new_order')
            ->setHandler([$this, 'maybeFireOrderCreatedEvent'])
            ->setArgumentsCount(2)
            ->execute();

        Register::action()
            ->setGroup('woocommerce_update_order')
            ->setHandler([$this, 'maybeFireOrderUpdatedEvent'])
            ->setArgumentsCount(2)
            ->execute();
    }

    /**
     * Fires order created event via checkout process.
     *
     * @internal
     *
     * @since x.y.z
     *
     * @param $order
     * @throws Exception
     */
    public function maybeFireOrderCreatedEventFromCheckout($order)
    {
        Events::broadcast((new OrderCreatedEvent())->setWooCommerceOrder($order));
    }

    /**
     * Fires order created event.
     *
     * @internal
     *
     * @since 2.14.0
     *
     * @param $orderId
     * @param $order
     * @throws Exception
     */
    public function maybeFireOrderCreatedEvent($orderId, $order = null)
    {
        if ($order = $this->getOrderForEventBroadcast($orderId, $order)) {
            Events::broadcast((new OrderCreatedEvent())->setWooCommerceOrder($order));
        }
    }

    /**
     * Fires order updated event.
     *
     * @internal
     *
     * @since 2.14.0
     *
     * @param $orderId
     * @param $order
     * @throws Exception
     */
    public function maybeFireOrderUpdatedEvent($orderId, $order = null)
    {
        if ($order = $this->getOrderForEventBroadcast($orderId, $order)) {
            Events::broadcast((new OrderUpdatedEvent())->setWooCommerceOrder($order));
        }
    }

    /**
     * Gets an order object for broadcast.
     *
     * @since 2.14.0
     *
     * @param int|mixed $orderId
     * @param WC_Order|mixed|null $order
     * @return WC_Order|null
     */
    private function getOrderForEventBroadcast($orderId, $order)
    {
        if (! $order instanceof WC_Order) {
            $order = is_numeric($orderId) ? OrdersRepository::get((int) $orderId) : null;
        }

        return $order instanceof WC_Order ? $order : null;
    }
}
