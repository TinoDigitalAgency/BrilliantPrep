<?php

namespace GoDaddy\WordPress\MWC\Core\Payments;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Repositories\ManagedWooCommerceRepository;

class Poynt
{
    /**
     * Gets the configured app ID.
     *
     * @return string
     * @throws Exception
     */
    public static function getAppId() : string
    {
        return (string) Configuration::get('payments.poynt.appId', '');
    }

    /**
     * Gets the configured application ID.
     *
     * Note: this represents the merchant's application to process payments, not the developer app ID for API communication.
     *
     * @return string
     * @throws Exception
     */
    public static function getApplicationId() : string
    {
        return (string) Configuration::get('payments.poynt.applicationId', '');
    }

    /**
     * Gets the configured business ID.
     *
     * @return string
     * @throws Exception
     */
    public static function getBusinessId() : string
    {
        return (string) Configuration::get('payments.poynt.businessId', '');
    }

    /**
     * Gets the GoDaddy Payments Hub URL.
     *
     * @return string
     * @throws Exception
     */
    public static function getHubUrl() : string
    {
        return (string) ManagedWooCommerceRepository::isProductionEnvironment() ? Configuration::get('payments.poynt.hub.productionUrl', '') : Configuration::get('payments.poynt.hub.stagingUrl', '');
    }

    /**
     * Gets the GoDaddy Payments private key.
     *
     * @return string
     * @throws Exception
     */
    public static function getPrivateKey() : string
    {
        return (string) Configuration::get('payments.poynt.privateKey', '');
    }

    /**
     * Gets the GoDaddy Payments public key.
     *
     * @return string
     * @throws Exception
     */
    public static function getPublicKey() : string
    {
        return (string) Configuration::get('payments.poynt.publicKey', '');
    }

    /**
     * Gets the configured service ID.
     *
     * @return string
     * @throws Exception
     */
    public static function getServiceId() : string
    {
        return (string) Configuration::get('payments.poynt.serviceId', '');
    }

    /**
     * Sets the app ID.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public static function setAppId(string $value)
    {
        update_option('mwc_payments_poynt_appId', $value);

        Configuration::set('payments.poynt.appId', $value);
    }

    /**
     * Sets the application ID.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public static function setApplicationId(string $value)
    {
        update_option('mwc_payments_poynt_applicationId', $value);

        Configuration::set('payments.poynt.applicationId', $value);
    }

    /**
     * Sets the business ID.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public static function setBusinessId(string $value)
    {
        update_option('mwc_payments_poynt_businessId', $value);

        Configuration::set('payments.poynt.businessId', $value);
    }

    /**
     * Sets the private key.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public static function setPrivateKey(string $value)
    {
        update_option('mwc_payments_poynt_privateKey', $value);

        Configuration::set('payments.poynt.privateKey', $value);
    }

    /**
     * Sets the public key.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public static function setPublicKey(string $value)
    {
        update_option('mwc_payments_poynt_publicKey', $value);

        Configuration::set('payments.poynt.publicKey', $value);
    }

    /**
     * Sets the service ID.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public static function setServiceId(string $value)
    {
        update_option('mwc_payments_poynt_serviceId', $value);

        Configuration::set('payments.poynt.serviceId', $value);
    }
}
