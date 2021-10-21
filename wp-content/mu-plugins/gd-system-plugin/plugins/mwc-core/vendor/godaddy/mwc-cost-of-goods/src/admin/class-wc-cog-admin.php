<?php
/**
 * WooCommerce Cost of Goods
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Cost of Goods to newer
 * versions in the future. If you wish to customize WooCommerce Cost of Goods for your
 * needs please refer to http://docs.woocommerce.com/document/cost-of-goods/ for more information.
 *
 * @author      SkyVerge
 * @copyright   Copyright (c) 2013-2020, SkyVerge, Inc. (info@skyverge.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace GoDaddy\WordPress\MWC\CostOfGoods\Admin;

defined( 'ABSPATH' ) or exit;

use function GoDaddy\WordPress\MWC\CostOfGoods\wc_cog;

/**
 * Cost of Goods Admin Class.
 *
 * Adds general COG settings and loads the orders/product admin classes.
 *
 * @since 1.0
 */
class WC_COG_Admin {


	/** @var WC_COG_Admin_Orders class instance */
	protected $orders;

	/** @var WC_COG_Admin_Products class instance */
	protected $products;


	/**
	 * Admin handler.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$this->init_hooks();

		$this->load_classes();
	}


	/**
	 * Initialize hooks
	 *
	 * @since 2.0.0
	 */
	protected function init_hooks() {

		// load styles/scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'load_styles_scripts' ] );
	}


	/**
	 * Load Orders/Products admin classes
	 *
	 * @since 2.0.0
	 */
	protected function load_classes() {

		$this->orders   = wc_cog()->load_class( '/src/admin/class-wc-cog-admin-orders.php', '\GoDaddy\WordPress\MWC\CostOfGoods\Admin\WC_COG_Admin_Orders' );
		$this->products = wc_cog()->load_class( '/src/admin/class-wc-cog-admin-products.php', '\GoDaddy\WordPress\MWC\CostOfGoods\Admin\WC_COG_Admin_Products' );
	}


	/**
	 * Return the admin orders class instance
	 *
	 * @since 2.0.0
	 * @return WC_COG_Admin_Orders
	 */
	public function get_orders_instance() : WC_COG_Admin_Orders {

		return $this->orders;
	}


	/**
	 * Return the admin products class instance
	 *
	 * @since 2.0.0
	 * @return WC_COG_Admin_Products
	 */
	public function get_products_instance() : WC_COG_Admin_Products {

		return $this->products;
	}


	/**
	 * Returns the global settings array for the plugin.
	 *
	 * @since 1.0
	 * @return array the global settings
	 */
	public static function get_global_settings() : array {

		return apply_filters( 'wc_cog_global_settings', [

			// section start
			[
				'name' => __( 'Cost of Goods Options', 'mwc-cost-of-goods' ),
				'type' => 'title',
				'id'   => 'wc_cog_global_settings',
			],

			// include fees
			[
				'title'         => __( 'Exclude these item(s) from income when calculating profit. ', 'mwc-cost-of-goods' ),
				'desc'          => __( 'Fees charged to customer (e.g. Checkout Add-Ons, Payment Gateway Based Fees)', 'mwc-cost-of-goods' ),
				'id'            => 'wc_cog_profit_report_exclude_gateway_fees',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start',
			],

			// include shipping costs
			[
				'desc'          => __( 'Shipping charged to customer', 'mwc-cost-of-goods' ),
				'id'            => 'wc_cog_profit_report_exclude_shipping_costs',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => '',
			],

			// include taxes
			[
				'desc'          => __( 'Tax charged to customer', 'mwc-cost-of-goods' ),
				'id'            => 'wc_cog_profit_report_exclude_taxes',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'end',
			],

			// custom section for applying costs to previous orders
			[
				'id'   => 'wc_cog_apply_costs_to_previous_orders',
				'type' => 'wc_cog_apply_costs_to_previous_orders',
			],

			// section end
			[ 'type' => 'sectionend', 'id' => 'wc_cog_profit_reports' ],

		] );
	}


	/**
	 * Load admin styles and scripts
	 *
	 * @since 1.8.0
	 */
	public function load_styles_scripts() {

		if ( wc_cog()->is_reports_page() ) {

			// hide WooCommerce Analytics error notice via JS
			wc_enqueue_js( "
				jQuery( function( $ ) {
					$( 'a[href$=\"page=wc-admin&path=/analytics/overview\"]' ).closest( 'div.error' ).remove();
				} );
			" );

			// fallback with CSS
			echo '<style>body.woocommerce_page_wc-reports .woocommerce #message.error.inline { display: none; }</style>';
		}
	}


}
