<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\ProducerContract;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Repositories\WooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Traits\Features\IsConditionalFeatureTrait;

/**
 * Producers.
 *
 * @since 2.10.0
 */
class Producers
{
    use IsConditionalFeatureTrait;

    /**
     * Class constructor.
     *
     * @since 2.10.0
     *
     * @throws Exception
     */
    public function __construct()
    {
        foreach (Configuration::get('events.producers', []) as $className) {
            if (is_a($className, ProducerContract::class, true)) {
                (new $className())->setup();
            }
        }
    }

    /**
     * Determines whether the feature should be loaded.
     *
     * @since 2.10.0
     *
     * @return bool
     * @throws Exception
     */
    public static function shouldLoadConditionalFeature() : bool
    {
        return WooCommerceRepository::isWooCommerceActive() && ManagedWooCommerceRepository::hasEcommercePlan();
    }
}
