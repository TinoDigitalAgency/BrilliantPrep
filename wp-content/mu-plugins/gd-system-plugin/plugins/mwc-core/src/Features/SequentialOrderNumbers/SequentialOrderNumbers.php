<?php

namespace GoDaddy\WordPress\MWC\Core\Features\SequentialOrderNumbers;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Extensions\Types\PluginExtension;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Repositories\WooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Traits\Features\IsConditionalFeatureTrait;
use GoDaddy\WordPress\MWC\Core\Events\FeatureEnabledEvent;
use GoDaddy\WordPress\MWC\Core\Events\PluginDeactivatedEvent;
use GoDaddy\WordPress\MWC\Core\Events\SettingsUpdatedEvent;
use GoDaddy\WordPress\MWC\Core\Features\SequentialOrderNumbers\Events\SequentialOrderNumbersSettingsUpdatedEvent;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Views\Components\GoDaddyBranding;
use function GoDaddy\WordPress\MWC\SequentialOrderNumbers\wc_seq_order_number_pro;
use GoDaddy\WordPress\MWC\SequentialOrderNumbers\WC_Sequential_Order_Numbers_Pro_Loader;

/**
 * The Sequential Order Numbers feature loader.
 *
 * @since 2.10.0
 */
class SequentialOrderNumbers
{
    use IsConditionalFeatureTrait;

    /** @var string the community plugin name */
    protected static $communityPluginName = 'woocommerce-sequential-order-numbers/woocommerce-sequential-order-numbers.php';

    /** @var string the community plugin slug */
    protected static $communityPluginSlug = 'woocommerce-sequential-order-numbers';

    /** @var string the community pro plugin name */
    protected static $communityProPluginName = 'woocommerce-sequential-order-numbers-pro/woocommerce-sequential-order-numbers-pro.php';

    /** @var string the community pro plugin slug */
    protected static $communityProPluginSlug = 'woocommerce-sequential-order-numbers-pro';

    /**
     * Constructs the class and loads the Sequential Order Numbers feature.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $rootVendorPath = StringHelper::trailingSlash(StringHelper::before(__DIR__, 'src').'vendor');

        // Load plugin class file
        require_once $rootVendorPath.'godaddy/mwc-sequential-order-numbers/woocommerce-sequential-order-numbers-pro.php';

        // load SV Framework from root vendor folder first
        require_once $rootVendorPath.'skyverge/wc-plugin-framework/woocommerce/class-sv-wc-plugin.php';

        WC_Sequential_Order_Numbers_Pro_Loader::instance()->init_plugin();

        $this->registerHooks();
    }

    /**
     * Registers hooks.
     *
     * @since 2.10.0
     *
     * @throws Exception
     */
    protected function registerHooks()
    {
        Register::action()
            ->setGroup('admin_init')
            ->setHandler([$this, 'maybeDeactivateSequentialOrderNumbersPlugins'])
            ->execute();

        Register::action()
                ->setGroup('admin_footer')
                ->setHandler([$this, 'addGoDaddyBrandingStyles'])
                ->setCondition([$this, 'shouldAddGoDaddyBranding'])
                ->execute();

        Register::action()
                ->setGroup('admin_footer')
                ->setHandler([GoDaddyBranding::getInstance(), 'render'])
                ->setCondition([$this, 'shouldAddGoDaddyBranding'])
                ->execute();

        Register::action()
            ->setGroup('wc_sequential_order_numbers_settings_updated')
            ->setHandler([$this, 'broadcastSettingsUpdatedEvent'])
            ->execute();
    }

    /**
     * Checks if should add GoDaddy branding to module settings page.
     *
     * @since 3.0.0
     *
     * @throws Exception
     * @return bool
     */
    public function shouldAddGoDaddyBranding() : bool
    {
        return ! ManagedWooCommerceRepository::isReseller() &&
               wc_seq_order_number_pro()->is_plugin_settings() &&
               // only add branding if another feature is not already adding it
               ! has_action('admin_footer', [GoDaddyBranding::getInstance(), 'render']);
    }

    /**
     * Adds the style tag used by the GoDaddy branding.
     *
     * @since 3.0.0
     */
    public function addGoDaddyBrandingStyles()
    {
        ob_start(); ?>
        <style>
            .mwc-gd-branding {
                position: absolute;
                bottom: 18px;
                left: 180px;
            }

            <?php
            // hide WordPress footer on older WooCommerce 3.x versions
            if (version_compare(WC_VERSION, '4.0', '<')) : ?>
            #wpfooter {
                display: none;
            }
            <?php endif; ?>

            @media screen and (max-width: 960px) {
                .mwc-gd-branding {
                    left: 55px;
                }
            }

            @media screen and (max-width: 782px) {
                .mwc-gd-branding {
                    left: 20px;
                }
            }
        </style>
        <?php

        (GoDaddyBranding::getInstance())->addStyle(ob_get_clean());
    }

    /**
     * Broadcasts an event when settings are updated.
     *
     * @internal
     * @since 2.10.0
     */
    public function broadcastSettingsUpdatedEvent()
    {
        $plugin = wc_seq_order_number_pro();

        $event = new SettingsUpdatedEvent($plugin->get_id());
        $event->setSettings([
            'starting_number'    => $plugin->get_order_number_start(),
            'prefix'             => $plugin->get_order_number_prefix(),
            'suffix'             => $plugin->get_order_number_suffix(),
            'skip_free_orders'   => $plugin->skip_free_orders(),
            'free_orders_prefix' => $plugin->get_free_order_number_prefix(),
        ]);

        Events::broadcast($event);
    }

    /**
     * May deactivate SON/SONP plugins.
     *
     * @since 2.10.0
     *
     * @throws Exception
     */
    public function maybeDeactivateSequentialOrderNumbersPlugins()
    {
        if (static::isSonSonpActivated()) {
            update_option('mwc_sequential_order_numbers_show_notice_son_sonp_users', 'yes');

            // we want to display the notice again even it was previously dismissed
            wc_seq_order_number_pro()->get_admin_notice_handler()->undismiss_notice(wc_seq_order_number_pro()->get_id_dasherized().'-son-sonp-users');

            $this->maybeDeactivatePlugin(static::$communityPluginName, static::$communityPluginSlug);
            $this->maybeDeactivatePlugin(static::$communityProPluginName, static::$communityProPluginSlug);

            Events::broadcast(new FeatureEnabledEvent('sequential_order_numbers'));
        }
    }

    /**
     * May deactivate a sequential order numbers plugin.
     *
     * @since 2.10.0
     *
     * @param string $pluginName the name of the plugin to be deactivated
     * @param string $pluginSlug the slug of the plugin to be deactivated
     * @throws Exception
     */
    private function maybeDeactivatePlugin(string $pluginName, string $pluginSlug)
    {
        if (function_exists('deactivate_plugins') && static::isPluginActivated($pluginName)) {
            deactivate_plugins($pluginName);

            $this->broadcastDeactivationEvent($pluginName, $pluginSlug);
        }
    }

    /**
     * Broadcasts a plugin deactivation event.
     *
     * @since 2.10.0
     *
     * @param string $deactivatedPluginName deactivated plugin's name
     * @param string $deactivatedPluginSlug deactivated plugin's slug
     * @throws Exception
     */
    private function broadcastDeactivationEvent(string $deactivatedPluginName, string $deactivatedPluginSlug)
    {
        $pluginExtension = (new PluginExtension())
            ->setName($deactivatedPluginName)
            ->setSlug($deactivatedPluginSlug);

        Events::broadcast(new PluginDeactivatedEvent($pluginExtension));
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
        // should not display if Sequential Order Numbers is disabled through configurations
        if (! Configuration::get('features.sequential_order_numbers', true)) {
            return false;
        }

        return ManagedWooCommerceRepository::hasEcommercePlan() && WooCommerceRepository::isWooCommerceActive();
    }

    /**
     * Checks if Sequential Order Number Free or Pro plugin are active.
     *
     * @since 2.10.0
     *
     * @return bool
     */
    public static function isSonSonpActivated() : bool
    {
        return
            static::isPluginActivated(static::$communityPluginName) ||
            static::isPluginActivated(static::$communityProPluginName);
    }

    /**
     * Checks if a plugin is active.
     *
     * @since 2.10.0
     *
     * @param string $pluginName the plugin's name to be checked
     * @return bool true if the plugin is active
     */
    private static function isPluginActivated(string $pluginName) : bool
    {
        return function_exists('is_plugin_active') && is_plugin_active($pluginName);
    }
}
