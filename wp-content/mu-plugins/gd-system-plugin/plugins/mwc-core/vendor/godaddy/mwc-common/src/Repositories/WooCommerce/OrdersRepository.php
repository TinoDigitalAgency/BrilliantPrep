<?php

namespace GoDaddy\WordPress\MWC\Common\Repositories\WooCommerce;

/**
 * Repository for handling WooCommerce orders.
 *
 * @since 3.4.1
 */
class OrdersRepository
{
    /**
     * Gets a WooCommerce order object.
     *
     * @since 3.4.1
     *
     * @param int order ID
     * @return \WC_Order|null
     */
    public static function get(int $id)
    {
        return wc_get_order($id) ?: null;
    }

    /**
     * Gets a list of WooCommerce statuses which are considered "paid".
     *
     * @since 3.4.1
     *
     * @return string[] array of status slugs
     */
    public static function getPaidStatuses() : array
    {
        return (array) wc_get_is_paid_statuses();
    }
}
