<?php

namespace GoDaddy\WordPress\MWC\Dashboard\Events;

use GoDaddy\WordPress\MWC\Common\Events\Contracts\EventBridgeEventContract;
use GoDaddy\WordPress\MWC\Common\Traits\IsEventBridgeEventTrait;
use GoDaddy\WordPress\MWC\Dashboard\Message\Message;

/**
 * Abstract message event class.
 *
 * @since x.y.z
 */
abstract class AbstractMessageEvent implements EventBridgeEventContract
{
    use IsEventBridgeEventTrait;

    /** @var Message */
    protected $message;

    /**
     * Constructor.
     *
     * @since x.y.z
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->resource = 'message';
        $this->message = $message;
    }

    /**
     * Gets the data for the current event.
     *
     * @since x.y.z
     *
     * @return array
     */
    public function getData() : array
    {
        return [
            'message' => [
                'id' => $this->message->getId(),
            ],
        ];
    }
}
