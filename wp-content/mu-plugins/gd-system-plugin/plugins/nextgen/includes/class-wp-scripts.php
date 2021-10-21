<?php
/**
 * Class WP_Scripts
 *
 * @since NEXT
 * @package GoDaddy\WordPress\Plugins\NextGen
 */

namespace GoDaddy\WordPress\Plugins\NextGen;

defined( 'ABSPATH' ) || exit;

/**
 * Class WP_Scripts
 * The purpose of this class is to intercept request to wp_localize_script.
 *
 * @package GoDaddy\WordPress\Plugins\NextGen
 */
class WP_Scripts extends \WP_Scripts {

	/**
	 * Contains localize data we want to expose through an API.
	 *
	 * @var array the data.
	 */
	public static $localized_data = [];

	/**
	 * Function that looks at the handle and if part of match we store data to expose later.
	 *
	 * @param string $handle script handle.
	 * @param string $object_name js object name.
	 * @param array  $l10n the data.
	 *
	 * @return bool
	 */
	public function localize( $handle, $object_name, $l10n ) {

		if ( preg_match( '/(nextgen|coblocks)/', $handle ) ) {

			self::$localized_data[ $object_name ] = $l10n;

		};

		return parent::localize( $handle, $object_name, $l10n );

	}

}
