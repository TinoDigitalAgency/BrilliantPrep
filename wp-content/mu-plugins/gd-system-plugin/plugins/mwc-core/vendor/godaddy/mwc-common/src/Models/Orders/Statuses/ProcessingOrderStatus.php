<?php

namespace GoDaddy\WordPress\MWC\Common\Models\Orders\Statuses;

use GoDaddy\WordPress\MWC\Common\Contracts\OrderStatusContract;
use GoDaddy\WordPress\MWC\Common\Traits\HasLabelTrait;

/**
 * Class ProcessingOrderStatus
 */
final class ProcessingOrderStatus implements OrderStatusContract
{
    use HasLabelTrait;

    public function __construct()
    {
        $this->setName('processing')
            ->setLabel(__('Processing', 'mwc-common'));
    }
}
