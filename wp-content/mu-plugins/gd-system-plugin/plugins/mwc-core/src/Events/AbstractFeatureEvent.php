<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

use GoDaddy\WordPress\MWC\Common\Events\Contracts\EventBridgeEventContract;
use GoDaddy\WordPress\MWC\Common\Traits\IsEventBridgeEventTrait;

/**
 * Abstract feature event class.
 *
 * @since 2.10.0
 */
abstract class AbstractFeatureEvent implements EventBridgeEventContract
{
    use IsEventBridgeEventTrait;

    /** @var string $featureId */
    protected $featureId;

    /**
     * AbstractFeatureEvent constructor.
     *
     * @since 2.10.0
     *
     * @param string $featureId
     */
    public function __construct(string $featureId)
    {
        $this->featureId = $featureId;
        $this->resource = 'feature';
    }

    /**
     * Gets the data for the current event.
     *
     * @since 2.10.0
     *
     * @return array
     */
    public function getData() : array
    {
        return [
            'feature' => [
                'id' => $this->featureId,
            ],
        ];
    }
}
