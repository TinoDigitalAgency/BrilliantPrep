<?php

namespace GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Frontend\Views\PaymentForm;

use GoDaddy\WordPress\MWC\Core\WooCommerce\Payments\Frontend\Views\Traits\RendersCardPaymentMethodTrait;
use GoDaddy\WordPress\MWC\Payments\Models\PaymentMethods\CardPaymentMethod;

/**
 * The card payment method view at checkout.
 *
 * @since 2.10.0
 *
 * @method CardPaymentMethod getPaymentMethod()
 */
class CardPaymentMethodView extends PaymentMethodView
{
    use RendersCardPaymentMethodTrait;

    /**
     * Renders the card's title.
     *
     * @since 2.10.0
     */
    protected function renderTitle()
    {
        parent::renderTitle();

        echo $this->getLastFourHtml();

        if ($expirationDate = $this->getFormattedExpirationDate()) {
            /* translators: Placeholders: %s - expiration date */
            echo '<span class="expiration">('.sprintf(__('expires %s', 'mwc-core'), esc_html($expirationDate)).')</span>';
        }
    }

    /**
     * Gets the formatted expiration date.
     *
     * @since 2.10.0
     *
     * @return string
     */
    protected function getFormattedExpirationDate() : string
    {
        $year = $this->getPaymentMethod()->getExpirationYear();

        // display a year at minimum
        if (! $year) {
            return '';
        }

        $month = $this->getPaymentMethod()->getExpirationMonth();

        if ($month) {
            $year = substr($year, -2);

            return "{$month}/{$year}";
        } else {
            return 2 === strlen($year) ? "20{$year}" : $year;
        }
    }
}
