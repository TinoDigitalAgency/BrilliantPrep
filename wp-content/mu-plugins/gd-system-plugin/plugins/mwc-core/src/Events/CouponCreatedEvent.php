<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

/**
 * Coupon created event class.
 *
 * @since 2.10.0
 */
class CouponCreatedEvent extends AbstractCouponEvent
{
    /**
     * CouponCreatedEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = 'create';
    }
}
