<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

use GoDaddy\WordPress\MWC\Common\Events\Contracts\EventContract;

/**
 * Abstract webhook received event class.
 *
 * @since 2.14.0
 */
abstract class AbstractWebhookReceivedEvent implements EventContract
{
    /** @var array */
    protected $headers;

    /** @var string */
    protected $payload;

    /**
     * Event constructor.
     *
     * @since 2.14.0
     *
     * @param array $headers
     * @param string $payload
     */
    public function __construct(array $headers, string $payload)
    {
        $this->headers = $headers;
        $this->payload = $payload;
    }

    /**
     * Gets the headers.
     *
     * @since 2.14.0
     *
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * Gets the payload.
     *
     * @since 2.14.0
     *
     * @return string
     */
    public function getPayload() : string
    {
        return $this->payload;
    }
}
