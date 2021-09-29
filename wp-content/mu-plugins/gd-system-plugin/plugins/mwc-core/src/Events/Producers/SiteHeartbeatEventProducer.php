<?php

namespace GoDaddy\WordPress\MWC\Core\Events\Producers;

use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\ProducerContract;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Core\Events\SiteHeartbeatEvent;

class SiteHeartbeatEventProducer implements ProducerContract
{
    /**
     * Sets up the Site Heartbeat event producer.
     */
    public function setup()
    {
        if (! $this->shouldBroadcastSiteHeartbeatEvent()) {
            return;
        }

        Register::action()
            ->setGroup('init')
            ->setHandler([$this, 'broadcastSiteHeartbeatEvent'])
            ->setPriority(20)
            ->execute();
    }

    /**
     * Determines whether we should broadcast the site heart event.
     *
     * @return bool
     */
    protected function shouldBroadcastSiteHeartbeatEvent() : bool
    {
        // broadcast the event for existing sites only: sites created before August 9, 2021
        if (((int) Configuration::get('godaddy.site.created')) >= 1628467200) {
            return false;
        }

        return Configuration::get('woocommerce.flags.broadcastSiteHeartbeatEvent');
    }

    /**
     * Broadcasts a Site Heartbeat event.
     *
     * @internal
     *
     * @since 2.11.0
     */
    public function broadcastSiteHeartbeatEvent()
    {
        Events::broadcast(new SiteHeartbeatEvent());

        Configuration::set('woocommerce.flags.broadcastSiteHeartbeatEvent', false);

        update_option('mwc_site_heartbeat_event_sent_at', time());
    }
}
