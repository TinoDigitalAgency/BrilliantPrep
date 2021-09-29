<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

/**
 * Coupon updated event class.
 *
 * @since 2.10.0
 */
class CouponUpdatedEvent extends AbstractCouponEvent
{
    /**
     * CouponUpdatedEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = 'update';
    }
}
