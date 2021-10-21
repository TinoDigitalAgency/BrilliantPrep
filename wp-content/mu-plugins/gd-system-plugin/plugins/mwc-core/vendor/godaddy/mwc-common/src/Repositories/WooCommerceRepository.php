<?php

namespace GoDaddy\WordPress\MWC\Common\Repositories;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;

/**
 * WooCommerce repository class.
 *
 * @since 1.0.0
 */
class WooCommerceRepository
{
    /**
     * Retrieve the current WooCommerce instance.
     *
     * @return \WooCommerce|null
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (! static::isWooCommerceActive()) {
            return null;
        }

        return WC();
    }

    /**
     * Retrieve the configured WooCommerce country code.
     *
     * @return string
     * @throws Exception
     * @since 3.4.1
     *
     * @return string
     * @throws Exception
     */
    public static function getBaseCountry(): string
    {
        if (! empty($wc = static::getInstance()) && $wc->countries) {
            return $wc->countries->get_base_country();
        }

        return '';
    }

    /**
     * Retrieve the configured WooCommerce currency code.
     *
     * @since 3.4.1
     *
     * @return string
     * @throws Exception
     */
    public static function getCurrency(): string
    {
        return static::isWooCommerceActive() ? get_woocommerce_currency() : '';
    }

    /**
     * Retrieve the current WooCommerce access token.
     *
     * @since 1.0.0
     *
     * @return string|null
     */
    public static function getWooCommerceAccessToken()
    {
        $authorization = self::getWooCommerceAuthorization();

        return ArrayHelper::get($authorization, 'access_token');
    }

    /**
     * Retrieve the current WooCommerce Authorization Object.
     *
     * @since 1.0.0
     *
     * @return array|null
     */
    public static function getWooCommerceAuthorization()
    {
        if (class_exists('WC_Helper_Options')) {
            return \WC_Helper_Options::get('auth');
        }

        return null;
    }

    /**
     * Checks if the WooCommerce plugin is active.
     *
     * @since 1.0.0
     *
     * @return bool
     * @throws Exception
     */
    public static function isWooCommerceActive() : bool
    {
        return null !== Configuration::get('woocommerce.version') &&
            class_exists(\WooCommerce::class);
    }

    /**
     * Checks if the site is connected to WooCommerce.com.
     *
     * @since 1.0.0
     *
     * @return bool
     * @throws Exception
     */
    public static function isWooCommerceConnected() : bool
    {
        return self::isWooCommerceActive() && self::getWooCommerceAccessToken();
    }

    /**
     * Checks whether the current page is a WooCommerce admin page.
     *
     * This method should return true for all admin pages that have a URL like
     * /wp-admin/admin.php?page=wc-admin&path={somepath} (where path is optional).
     *
     * @since 3.4.1
     *
     * @param string $path optional string to compare with the path query paramter
     *
     * @return bool
     */
    public static function isWooCommerceAdminPage(string $path = null) : bool
    {
        if (! $screen = get_current_screen()) {
            return false;
        }

        if ($screen->base !== 'woocommerce_page_wc-admin') {
            return false;
        }

        return $path ? $path === ArrayHelper::get($_REQUEST, 'path', '') : true;
    }
}
