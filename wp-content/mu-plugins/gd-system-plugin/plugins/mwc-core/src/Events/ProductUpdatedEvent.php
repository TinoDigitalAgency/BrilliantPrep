<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

/**
 * Product updated event class.
 *
 * @since 2.10.0
 */
class ProductUpdatedEvent extends AbstractProductEvent
{
    /**
     * ProductUpdatedEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = 'update';
    }
}
