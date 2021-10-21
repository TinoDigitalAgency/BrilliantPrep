<?php

namespace GoDaddy\WordPress\MWC\Core\Events;

use GoDaddy\WordPress\MWC\Common\Events\Contracts\EventBridgeEventContract;
use GoDaddy\WordPress\MWC\Common\Traits\IsEventBridgeEventTrait;
use function GoDaddy\WordPress\MWC\UrlCoupons\wc_url_coupons;
use WC_Coupon;

/**
 * Abstract coupon event class.
 *
 * @since 2.10.0
 */
abstract class AbstractCouponEvent implements EventBridgeEventContract
{
    use IsEventBridgeEventTrait;

    /** @var WC_Coupon The coupon object */
    protected $coupon;

    /**
     * AbstractCouponEvent constructor.
     */
    public function __construct()
    {
        $this->resource = 'coupon';
    }

    /**
     * Sets the WooCommerce coupon object for this event.
     *
     * @param WC_Coupon $coupon
     * @return $this
     */
    public function setWooCommerceCoupon(WC_Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Gets the data for the event.
     *
     * @return array
     */
    public function getData() : array
    {
        return $this->coupon ? [
            'coupon' => [
                'id' => $this->coupon->get_id(),
                'code' => $this->coupon->get_code(),
                'discountType' => $this->coupon->get_discount_type(),
                'discountAmount' => $this->coupon->get_amount(),
                'allowsFreeShipping' => $this->coupon->get_free_shipping(),
                'expiryDate' => empty($this->coupon->get_date_expires()) ? '' : $this->coupon->get_date_expires()->date('Y-m-d'),
                'uniqueUrl' => $this->coupon->get_meta('_wc_url_coupons_unique_url') ?? '',
                'redirectPage' => $this->getRedirectPage(),
                'productsToAddToCart' => $this->coupon->get_meta('_wc_url_coupons_product_ids') ?? [],
                'deferApply' => 'yes' === $this->coupon->get_meta('_wc_url_coupons_defer_apply'),
            ],
        ] : [];
    }

    /**
     * Gets the redirect page URL based on its ID and type.
     *
     * @since 3.0.0
     *
     * @return string
     */
    private function getRedirectPage()
    {
        // TODO: Update this method in Native URL Coupons V2 {@acastro1 2021-08-10}
        if (! is_callable('GoDaddy\WordPress\MWC\UrlCoupons\wc_url_coupons') || empty($this->coupon->get_meta('_wc_url_coupons_redirect_page'))) {
            return '';
        }

        return wc_url_coupons()->get_object_url((int) $this->coupon->get_meta('_wc_url_coupons_redirect_page'), $this->coupon->get_meta('_wc_url_coupons_existing_page_type'));
    }
}
