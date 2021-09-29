<?php

namespace GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses;

use GoDaddy\WordPress\MWC\Common\Contracts\OrderStatusContract;
use GoDaddy\WordPress\MWC\Common\Traits\HasLabelTrait;

/**
 * Class RefundedOrderStatus
 */
final class RefundedOrderStatus implements OrderStatusContract
{
    use HasLabelTrait;

    public function __construct()
    {
        $this->setName('refunded')
            ->setLabel(__('Refunded', 'mwc-common'));
    }
}
