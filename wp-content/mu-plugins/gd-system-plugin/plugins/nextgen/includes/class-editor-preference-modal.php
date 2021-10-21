<?php
/**
 * NextGen Feedback Modal
 *
 * @since 1.0.0
 * @package NextGen
 */

namespace GoDaddy\WordPress\Plugins\NextGen;

defined( 'ABSPATH' ) || exit;

/**
 * Feedback_Modal
 *
 * @package NextGen
 * @author  GoDaddy
 */
class Editor_Preference_Modal {

	use Helper;

	/**
	 * Class constructor
	 */
	public function __construct() {

		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_scripts' ] );

	}

	/**
	 * Enqueue the scripts and styles.
	 */
	public function enqueue_scripts() {

		$default_asset_file = [
			'dependencies' => [],
			'version'      => GD_NEXTGEN_VERSION,
		];

		// Editor Script.
		$asset_filepath = GD_NEXTGEN_PLUGIN_DIR . '/build/editorPreferenceModal.asset.php';
		$asset_file     = file_exists( $asset_filepath ) ? include $asset_filepath : $default_asset_file;

		wp_enqueue_script(
			'nextgen-editor-preference-modal',
			GD_NEXTGEN_PLUGIN_URL . 'build/editorPreferenceModal.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true // Enqueue script in the footer.
		);

		wp_localize_script(
			'nextgen-editor-preference-modal',
			'nextgenEditorPreferenceModalData',
			[
				'feedback_api'  => self::wpnux_api_base() . '/feedback',
				'feedback_body' => [
					'site_uid'   => defined( 'GD_ACCOUNT_UID' ) && GD_ACCOUNT_UID ? GD_ACCOUNT_UID : '',
					'export_uid' => get_option( 'wpnux_export_uid', '' ),
					'versions'   => [
						'coblocks'     => defined( 'COBLOCKS_VERSION' ) ? COBLOCKS_VERSION : '',
						'go_theme'     => defined( 'GO_VERSION' ) ? GO_VERSION : '',
						'nextgen'      => defined( 'GD_NEXTGEN_VERSION' ) ? GD_NEXTGEN_VERSION : '',
						'wpaas_plugin' => class_exists( '\WPaaS\Plugin' ) ? \WPaaS\Plugin::version() : '',
					],
				],
				'nextgen_urls'  => apply_filters(
					'nextgen_admin_links',
					[
						'admin' => get_admin_url(),
					]
				),
			]
		);

		wp_set_script_translations( 'nextgen-editor-preference-modal', 'nextgen', GD_NEXTGEN_PLUGIN_DIR . '/languages' );

		wp_enqueue_style(
			'nextgen-editor-preference-modal',
			GD_NEXTGEN_PLUGIN_URL . 'build/style-editorPreferenceModal.css',
			[],
			$asset_file['version']
		);

	}
}
