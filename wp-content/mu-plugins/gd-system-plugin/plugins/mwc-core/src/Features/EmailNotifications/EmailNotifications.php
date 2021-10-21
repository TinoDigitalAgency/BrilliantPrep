<?php

namespace GoDaddy\WordPress\MWC\Core\Features\EmailNotifications;

use Exception;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ConditionalComponentContract;
use GoDaddy\WordPress\MWC\Common\Components\Traits\HasComponentsTrait;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Traits\Features\IsConditionalFeatureTrait;
use GoDaddy\WordPress\MWC\Core\Features\EmailNotifications\API\API;

/**
 * Email notifications feature loader.
 *
 * @since 2.14.1
 */
class EmailNotifications implements ConditionalComponentContract
{
    use IsConditionalFeatureTrait;
    use HasComponentsTrait;

    /** @var array */
    protected $componentClasses = [
        API::class,
        EmailsPage::class,
    ];

    /**
     * Constructor.
     *
     * TODO: remove this method when {@see Pacakge} is converted to use {@see HasComponentsTrait} {wvega 2021-09-10}
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->load();
    }

    /**
     * Determines whether the feature is active.
     *
     * @since 2.14.1
     *
     * @return bool
     * @throws Exception
     */
    public static function isActive() : bool
    {
        return Configuration::get('features.email_notifications', false);
        // @TODO delete or implement at feature launch {unfulvio 2021-09-01}
            // && ManagedWooCommerceRepository::getXid() % 3 > 0;
    }

    /**
     * Determines whether the feature is enabled.
     *
     * @since 2.14.1
     *
     * @return bool
     * @throws Exception
     */
    public static function isEnabled() : bool
    {
        return static::isActive() && Configuration::get('email_notifications.enabled', false);
    }

    /**
     * Determines whether the Email Notifications feature should load.
     *
     * TODO: remove this method when {@see Package} is converted to use {@see HasComponentsTrait} {wvega 2021-09-10}
     *
     * @return bool
     * @throws Exception
     */
    public static function shouldLoadConditionalFeature(): bool
    {
        return static::shouldLoad();
    }

    /**
     * Determines whether the Email Notifications feature should load.
     *
     * @return bool
     * @throws Exception
     */
    public static function shouldLoad(): bool
    {
        return static::isActive();
    }

    /**
     * Initializes the feature.
     *
     * @throws Exception
     */
    public function load()
    {
        $this->loadComponents();
    }

    /**
     * Gets the available email notifications categories.
     *
     * @return array associative array of slug identifiers and translatable labels
     */
    public static function getCategories() : array
    {
        return [
            'admin'      => __('Admin', 'mwc-core'),
            'extensions' => __('Extensions', 'mwc-core'),
            'customer'   => __('Customer', 'mwc-core'),
            'order'      => __('Order', 'mwc-core'),
        ];
    }
}
