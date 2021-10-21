<?php

namespace GoDaddy\WordPress\MWC\Core\Events\Producers;

use Exception;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\ProducerContract;
use GoDaddy\WordPress\MWC\Common\Events\Events;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Common\Repositories\WordPressRepository;
use GoDaddy\WordPress\MWC\Core\Events\PageViewEvent;
use GoDaddy\WordPress\MWC\Core\Features\CostOfGoods\CostOfGoods;
use GoDaddy\WordPress\MWC\Core\Features\CostOfGoods\Events\ProfitReportsPageViewEvent;
use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Events\PaymentSettingsPageViewEvent;
use WP_Screen;

class PageEventsProducer implements ProducerContract
{
    /**
     * Sets up the Page events producer.
     *
     * @throws Exception
     */
    public function setup()
    {
        Register::action()
            ->setGroup('current_screen')
            ->setHandler([$this, 'firePageViewEvent'])
            ->execute();

        Register::action()
            ->setGroup('current_screen')
            ->setHandler([$this, 'maybeFirePaymentSettingsPageViewEvent'])
            ->execute();

        Register::action()
            ->setGroup('current_screen')
            ->setHandler([$this, 'maybeFireProfitReportsPageViewEvent'])
            ->execute();
    }

    /**
     * Fires page view event.
     *
     * @internal
     *
     * @since 2.10.0
     *
     * @param WP_Screen $currentWPScreen
     *
     * @throws Exception
     */
    public function firePageViewEvent($currentWPScreen)
    {
        if (! ArrayHelper::contains(['edit', 'post', 'woocommerce_page_wc-settings'], $currentWPScreen->base)) {
            return;
        }

        if ($currentScreen = WordPressRepository::getCurrentScreen()) {
            Events::broadcast(new PageViewEvent($currentScreen));
        }
    }

    /**
     * Fires Payment Settings page view event if on Payment Settings page.
     *
     * @internal
     *
     * @since 2.10.0
     *
     * @param WP_Screen $currentWPScreen
     *
     * @throws Exception
     */
    public function maybeFirePaymentSettingsPageViewEvent($currentWPScreen)
    {
        if ('woocommerce_page_wc-settings' !== $currentWPScreen->base) {
            return;
        }

        if (($currentScreen = WordPressRepository::getCurrentScreen()) && 'woocommerce_settings_checkout' === $currentScreen->getPageId()) {
            Events::broadcast(new PaymentSettingsPageViewEvent($currentScreen));
        }
    }

    /**
     * Fires a page view event when navigating to WooCommerce > Profit > Reports pages.
     *
     * @internal
     *
     * @since 2.15.0
     *
     * @param WP_Screen $currentWPScreen
     *
     * @throws Exception
     */
    public function maybeFireProfitReportsPageViewEvent($currentWPScreen)
    {
        if ('woocommerce_page_wc-reports' !== $currentWPScreen->base || ! CostOfGoods::shouldLoadConditionalFeature()) {
            return;
        }

        $currentScreen = WordPressRepository::getCurrentScreen();

        if ($currentScreen && 'profit' === ArrayHelper::get($_GET, 'tab')) {
            Events::broadcast(new ProfitReportsPageViewEvent($currentScreen, 'profit'));
        }
    }
}
