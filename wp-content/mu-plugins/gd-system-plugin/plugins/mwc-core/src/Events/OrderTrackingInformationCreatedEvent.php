<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

/**
 * Order tracking information created event class.
 *
 * @since 2.10.0
 */
class OrderTrackingInformationCreatedEvent extends AbstractOrderTrackingInformationEvent
{
    /**
     * OrderTrackingInformationCreatedEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = 'create';
    }
}
