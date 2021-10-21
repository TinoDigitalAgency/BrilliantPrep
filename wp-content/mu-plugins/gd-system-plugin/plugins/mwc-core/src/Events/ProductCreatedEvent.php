<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

/**
 * Product created event class.
 *
 * @since 2.10.0
 */
class ProductCreatedEvent extends AbstractProductEvent
{
    /**
     * ProductCreatedEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = 'create';
    }
}
