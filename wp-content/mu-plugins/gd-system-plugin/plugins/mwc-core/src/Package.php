<?php

namespace GoDaddy\WordPress\MWC\Core;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Plugin\BasePlatformPlugin;
use GoDaddy\WordPress\MWC\Common\Repositories\WordPressRepository;
use GoDaddy\WordPress\MWC\Common\Traits\IsSingletonTrait;
use GoDaddy\WordPress\MWC\Core\Client\Client;
use GoDaddy\WordPress\MWC\Core\Events\Producers;
use GoDaddy\WordPress\MWC\Core\Features\CostOfGoods\CostOfGoods;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\EmailNotifications;
use GoDaddy\WordPress\MWC\Core\Features\GoogleAnalytics\GoogleAnalytics;
use GoDaddy\WordPress\MWC\Core\Features\SequentialOrderNumbers\SequentialOrderNumbers;
use GoDaddy\WordPress\MWC\Core\Features\UrlCoupons\UrlCoupons;
use GoDaddy\WordPress\MWC\Core\Pages\Plugins\IncludedWooCommerceExtensionsTab;
use GoDaddy\WordPress\MWC\Core\WooCommerce\ExtensionsTab;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Overrides;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\CorePaymentGateways;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Shipping\RemoveShipmentTrackingFromManagedWordPressSites;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Shipping\ShipmentTracking;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Updates;
use GoDaddy\WordPress\MWC\Dashboard\Dashboard;

/**
 * MWC Core package class.
 *
 * @since 2.10.0
 */
final class Package extends BasePlatformPlugin
{
    use IsSingletonTrait;

    /** @var string Plugin name */
    protected $name = 'mwc-core';

    /** @var array Classes to instantiate */
    protected $classesToInstantiate = [
        CorePaymentGateways::class                             => 'web',
        ExtensionsTab::class                                   => 'web',
        Producers::class                                       => 'web',
        Overrides::class                                       => 'web',
        RemoveShipmentTrackingFromManagedWordPressSites::class => 'web',
        ShipmentTracking::class                                => 'web',
        Updates::class                                         => 'web',
        Client::class                                          => 'web',
        IncludedWooCommerceExtensionsTab::class                => 'web',

        // GoDaddy\WordPress\MWC\Core\Features
        CostOfGoods::class                                     => true,
        EmailNotifications::class                              => true,
        SequentialOrderNumbers::class                          => true,
        UrlCoupons::class                                      => true,
        GoogleAnalytics::class                                 => true,
    ];

    /**
     * Package constructor.
     *
     * @since 2.10.0
     *
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        // skip in CLI mode.
        if (! WordPressRepository::isCliMode()) {
            $coreDir = plugin_basename(dirname(__DIR__));

            // load the textdomains
            load_plugin_textdomain('mwc-core', false, $coreDir.'/languages');
            load_plugin_textdomain('mwc-common', false, $coreDir.'/vendor/godaddy/mwc-common/languages');

            // load the dashboard
            Dashboard::getInstance();
        }
    }

    /**
     * Gets configuration values.
     *
     * @since 2.10.0
     *
     * @return array
     */
    protected function getConfigurationValues() : array
    {
        return array_merge(parent::getConfigurationValues(), [
            'version'    => '2.15.0',
            'plugin_dir' => dirname(__DIR__),
            'plugin_url' => plugin_dir_url(dirname(__FILE__)),
        ]);
    }

    /**
     * Initializes the Configuration class adding the plugin's configuration directory.
     *
     * @since 2.10.0
     */
    protected function initializeConfiguration()
    {
        Configuration::initialize([
            StringHelper::trailingSlash(dirname(__DIR__)).'vendor/godaddy/mwc-shipping/configurations',
            StringHelper::trailingSlash(dirname(__DIR__)).'configurations',
        ]);
    }
}
