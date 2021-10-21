<?php

namespace GoDaddy\WordPress\MWC\Core\WooCommerce\Payments;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\WooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Traits\Features\IsConditionalFeatureTrait;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Events\PaymentGatewayFirstActiveEvent;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Events\Producers\OnboardingEventsProducer;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Events\Producers\PaymentGatewayEventsProducer;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Frontend\MyPaymentMethods;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\GoDaddyPayments\Frontend\Admin\PaymentMethodsListTable;

/**
 * Core payment gateways.
 *
 * Takes care of the necessary tasks for adding the core gateway(s) in a way that WooCommerce understands.
 *
 * @since 2.10.0
 */
class CorePaymentGateways
{
    use IsConditionalFeatureTrait;

    /** @var string[] classes to load as universal handlers */
    private $handlerClasses = [
        Captures::class,
        PaymentMethodsListTable::class,
        MyPaymentMethods::class,
    ];

    /** @var string[] payments gateways to load */
    protected static $paymentGatewayClasses = [
        GoDaddyPaymentsGateway::class,
    ];

    /** @var AbstractPaymentGateway[] */
    private static $paymentGateways = [];

    /**
     * CorePaymentGateways constructor.
     *
     * @since 2.10.0
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->addHooks();
    }

    /**
     * Loads the payments handlers.
     *
     * @internal
     */
    public function loadHandlers()
    {
        // don't load anything if we don't have any gateways enabled
        if (empty(static::getPaymentGateways())) {
            return;
        }

        foreach ($this->handlerClasses as $class) {
            new $class();
        }

        (new OnboardingEventsProducer())->setUp();
        (new PaymentGatewayEventsProducer())->setUp();
    }

    /**
     * Adds instance of the gateways contained in $paymentGateways to the WooCommerce provided
     * $gateways param.
     *
     * @internal
     *
     * @param mixed $gateways
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function loadPaymentGateways($gateways) : array
    {
        if (! ArrayHelper::accessible($gateways)) {
            return $gateways;
        }

        // add our gateways to the top of the list
        foreach (static::getPaymentGateways() as $gateway) {
            array_unshift($gateways, $gateway);
        }

        return $gateways;
    }

    /**
     * Register the woocommerce_payment_gateways hook with loadPaymentGateways as the callback.
     *
     * @since 2.10.0
     *
     * @throws Exception
     */
    private function addHooks()
    {
        Register::action()
            ->setGroup('init')
            ->setHandler([$this, 'loadHandlers'])
            ->execute();

        Register::filter()
            ->setGroup('woocommerce_payment_gateways')
            ->setArgumentsCount(1)
            ->setHandler([$this, 'loadPaymentGateways'])
            ->execute();
    }

    /**
     * Broadcasts an event once the GDP gateway is active (available to be setup) for the first time.
     *
     * @since 2.10.0
     */
    protected static function maybeBroadcastPaymentGatewayFirstActiveEvent(AbstractPaymentGateway $gateway)
    {
        if (! Configuration::get('woocommerce.flags.broadcastGoDaddyPaymentsFirstActiveEvent')) {
            return;
        }

        Events::broadcast(new PaymentGatewayFirstActiveEvent($gateway->id));

        Configuration::set('woocommerce.flags.broadcastGoDaddyPaymentsFirstActiveEvent', false);

        update_option('gd_mwc_broadcast_go_daddy_payments_first_active', 'no');
    }

    /**
     * Gets a list of initialized core payment gateways.
     *
     * @since 2.10.0
     *
     * @return AbstractPaymentGateway[]
     */
    public static function getPaymentGateways() : array
    {
        if (! empty(static::$paymentGateways)) {
            return static::$paymentGateways;
        }

        foreach (static::$paymentGatewayClasses as $class) {
            if (! $class::isActive()) {
                continue;
            }

            /** @var AbstractPaymentGateway $gateway */
            $gateway = new $class;

            static::$paymentGateways[$gateway->id] = $gateway;

            static::maybeBroadcastPaymentGatewayFirstActiveEvent($gateway);
        }

        return static::$paymentGateways;
    }

    /**
     * Determines that the feature can be loaded if WooCommerce is available.
     *
     * @since 2.10.0
     *
     * @return bool
     * @throws Exception
     */
    public static function shouldLoadConditionalFeature() : bool
    {
        return WooCommerceRepository::isWooCommerceActive();
    }
}
