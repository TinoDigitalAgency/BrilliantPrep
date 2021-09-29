<?php

namespace GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses;

use GoDaddy\WordPress\MWC\Common\Contracts\OrderStatusContract;
use GoDaddy\WordPress\MWC\Common\Traits\HasLabelTrait;

/**
 * Class FailedOrderStatus
 */
final class FailedOrderStatus implements OrderStatusContract
{
    use HasLabelTrait;

    public function __construct()
    {
        $this->setName('failed')
            ->setLabel(__('Failed', 'mwc-common'));
    }
}
