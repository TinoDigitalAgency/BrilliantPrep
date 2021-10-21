<?php

namespace GoDaddy\WordPress\MWC\Core\Features\UrlCoupons;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Extensions\Types\PluginExtension;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Repositories\WooCommerceRepository;
use GoDaddy\WordPress\MWC\Common\Repositories\WordPressRepository;
use GoDaddy\WordPress\MWC\Common\Traits\Features\IsConditionalFeatureTrait;
use GoDaddy\WordPress\MWC\Core\Events\FeatureEnabledEvent;
use GoDaddy\WordPress\MWC\Core\Events\PluginDeactivatedEvent;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Views\Components\GoDaddyBranding;
use function GoDaddy\WordPress\MWC\SequentialOrderNumbers\wc_seq_order_number_pro;
use function GoDaddy\WordPress\MWC\UrlCoupons\wc_url_coupons;
use GoDaddy\WordPress\MWC\UrlCoupons\WC_URL_Coupons_Loader;

/**
 * The URL Coupons feature loader.
 *
 * @since 3.0.0
 */
class UrlCoupons
{
    use IsConditionalFeatureTrait;

    /** @var string the plugin name */
    protected static $communityPluginName = 'woocommerce-url-coupons/woocommerce-url-coupons.php';

    /** @var string the community plugin slug */
    protected static $communityPluginSlug = 'woocommerce-url-coupons';

    /**
     * Constructs the class and loads the URL Coupons feature.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $rootVendorPath = StringHelper::trailingSlash(StringHelper::before(__DIR__, 'src').'vendor');

        // load plugin class file
        require_once $rootVendorPath.'godaddy/mwc-url-coupons/woocommerce-url-coupons.php';

        // load SV Framework from root vendor folder first
        require_once $rootVendorPath.'skyverge/wc-plugin-framework/woocommerce/class-sv-wc-plugin.php';

        WC_URL_Coupons_Loader::instance()->init_plugin();

        $this->registerHooks();
    }

    /**
     * Registers hooks.
     *
     * @since 3.0.0
     *
     * @throws Exception
     */
    protected function registerHooks()
    {
        Register::action()
            ->setGroup('admin_init')
            ->setHandler([$this, 'maybeDeactivateUrlCouponsPlugins'])
            ->execute();

        Register::action()
                ->setGroup('mwc_coupon_options_discount_links')
                ->setHandler([$this, 'addGoDaddyBrandingStyles'])
                ->setCondition([$this, 'shouldAddGoDaddyBranding'])
                ->execute();

        Register::action()
                ->setGroup('mwc_coupon_options_discount_links')
                ->setHandler([GoDaddyBranding::getInstance(), 'render'])
                ->setCondition([$this, 'shouldAddGoDaddyBranding'])
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
               // only add branding if another feature is not already adding it
               ! has_action('mwc_coupon_options_discount_links', [GoDaddyBranding::getInstance(), 'render']);
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
                margin: 9px;
                line-height: 0;
                padding-top: 24px;
                width: 120px;
            }
        </style>
        <?php

        (GoDaddyBranding::getInstance())->addStyle(ob_get_clean());
    }

    /**
     * Determines whether this feature should be loaded.
     *
     * @since 3.0.0
     *
     * @return bool
     * @throws Exception
     */
    public static function shouldLoadConditionalFeature() : bool
    {
        // should not load if URL Coupons is disabled through configurations
        if (! Configuration::get('features.url_coupons', true)) {
            return false;
        }

        return ManagedWooCommerceRepository::hasEcommercePlan() && WooCommerceRepository::isWooCommerceActive();
    }

    /**
     * May deactivate the URL Coupons plugin.
     *
     * @since 3.0.0
     *
     * @throws Exception
     */
    public function maybeDeactivateUrlCouponsPlugins()
    {
        if (! static::isUrlCouponsPluginActive()) {
            return;
        }

        update_option('mwc_url_coupons_show_notice_plugin_users', 'yes');

        // we want to display the notice again even it was previously dismissed
        wc_url_coupons()->get_admin_notice_handler()->undismiss_notice(wc_url_coupons()->get_id_dasherized().'-plugin-users');

        if (function_exists('deactivate_plugins')) {
            deactivate_plugins(static::$communityPluginName);

            $pluginExtension = (new PluginExtension())
                ->setName(static::$communityPluginName)
                ->setSlug(static::$communityPluginSlug);

            Events::broadcast(new PluginDeactivatedEvent($pluginExtension));

            Events::broadcast(new FeatureEnabledEvent('url_coupons'));
        }
    }

    /**
     * Checks if URL Coupons plugin is active.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isUrlCouponsPluginActive() : bool
    {
        return function_exists('is_plugin_active') && is_plugin_active(static::$communityPluginName);
    }
}
