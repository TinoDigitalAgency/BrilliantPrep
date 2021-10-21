<?php

namespace GoDaddy\WordPress\MWC\Core\Payments\Adapters;

use Exception;
use GoDaddy\WordPress\MWC\Common\DataSources\WooCommerce\Adapters\Order\OrderAdapter as CommonOrderAdapter;
use GoDaddy\WordPress\MWC\Common\Models\Orders\Order;
use GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses\CancelledOrderStatus;
use GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses\FailedOrderStatus;
use GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses\RefundedOrderStatus;
use GoDaddy\WordPress\MWC\Core\Payments\Models\Orders\Order as CoreOrder;

/**
 * Order adapter.
 *
 * Converts between a native core order object and a WooCommerce order object.
 *
 * @since 2.10.0
 */
class OrderAdapter extends CommonOrderAdapter
{
    /** @var string overrides the common order class with the core order class */
    protected $orderClass = CoreOrder::class;

    /**
     * Converts the order from source.
     *
     * @since 2.10.0
     *
     * @return CoreOrder
     * @throws Exception
     */
    public function convertFromSource() : Order
    {
        /** @var CoreOrder $order */
        $order = parent::convertFromSource();

        if ($emailAddress = $this->source->get_billing_email()) {
            $order->setEmailAddress($emailAddress);
        }

        if ('yes' === $this->source->get_meta('_mwc_payments_is_captured')) {
            $order->setCaptured(true);
        } elseif ($this->isOrderReadyForCapture($order)) {
            $order->setReadyForCapture(true);
        }

        return $order;
    }

    /**
     * Determines whether the order is ready to be captured.
     *
     * TODO: remove status classes from mwc-payments package {@wvega 2021-05-31}.
     *
     * @param Order $order
     */
    protected function isOrderReadyForCapture(Order $order)
    {
        if ($order->getStatus() instanceof CancelledOrderStatus) {
            return false;
        }

        if ($order->getStatus() instanceof RefundedOrderStatus) {
            return false;
        }

        if ($order->getStatus() instanceof FailedOrderStatus) {
            return false;
        }

        return true;
    }
}
