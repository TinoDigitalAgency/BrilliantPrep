<?php

namespace GoDaddy\WordPress\MWC\Core\Events\Producers;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\ProducerContract;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Core\Events\AbstractWebhookReceivedEvent;

class WebhookEventsProducer implements ProducerContract
{
    /**
     * Sets up the webhook events producer.
     *
     * @since 2.14.0
     *
     * @throws Exception
     */
    public function setup()
    {
        foreach (Configuration::get('webhooks', []) as $webhookData) {
            $namespace = ArrayHelper::get($webhookData, 'namespace');

            if ('' === $namespace || ! is_string($namespace)) {
                continue;
            }

            Register::action()
                ->setGroup("woocommerce_api_{$namespace}")
                ->setHandler([$this, 'broadcastEvents'])
                ->execute();
        }
    }

    /**
     * Broadcasts an event when a request is received for a given webhook namespace.
     *
     * This is a callback for WooCommerce API actions set in {@see WebhookEventsProducer::setup()}.
     *
     * @internal
     *
     * @since 2.14.0
     *
     * @throws Exception
     */
    public function broadcastEvents()
    {
        $hook = current_action();

        foreach (Configuration::get('webhooks', []) as $webhookData) {
            $namespace = ArrayHelper::get($webhookData, 'namespace');
            $eventClass = ArrayHelper::get($webhookData, 'eventClass');

            if (! $this->shouldBroadcast($eventClass) || ! StringHelper::contains($hook, $namespace)) {
                continue;
            }

            /** @var AbstractWebhookReceivedEvent $event */
            $event = new $eventClass(
                $this->getRequestHeaders(),
                $this->getRequestPayload()
            );

            Events::broadcast($event);
        }
    }

    /**
     * Gets the request headers.
     *
     * @since 2.14.0
     *
     * @return array
     */
    protected function getRequestHeaders() : array
    {
        return ArrayHelper::where(ArrayHelper::wrap($_SERVER), function ($value, $key) {
            return StringHelper::startsWith($key, 'HTTP_') || StringHelper::startsWith($key, 'CONTENT_');
        });
    }

    /**
     * Gets the request payload.
     *
     * @since 2.14.0
     *
     * @return string
     */
    protected function getRequestPayload() : string
    {
        return file_get_contents('php://input') ?: '';
    }

    /**
     * Determines whether an event should be broadcast.
     *
     * @since 2.14.0
     *
     * @param string|mixed $eventClass
     * @return bool
     */
    private function shouldBroadcast($eventClass) : bool
    {
        return is_string($eventClass) && class_exists($eventClass) && is_subclass_of($eventClass, AbstractWebhookReceivedEvent::class);
    }
}
