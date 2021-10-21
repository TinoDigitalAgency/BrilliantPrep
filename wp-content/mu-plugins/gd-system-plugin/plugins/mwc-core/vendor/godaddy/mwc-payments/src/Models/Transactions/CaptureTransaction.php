<?php

namespace GoDaddy\WordPress\MWC\Payments\Models\Transactions;

/**
 * Capture transaction.
 *
 * @since 0.1.0
 */
class CaptureTransaction extends AbstractTransaction
{
    /** @var string type */
    protected $type = 'capture';
}
