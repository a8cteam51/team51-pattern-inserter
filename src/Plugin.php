<?php

namespace WPCOMSpecialProjects\Team51PatternInserter;

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Plugin {
	// region FIELDS AND CONSTANTS

	// endregion

	// region MAGIC METHODS

	/**
	 * Plugin constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	protected function __construct() {
		/* Empty on purpose. */
	}

	/**
	 * Prevent cloning.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	private function __clone() {
		/* Empty on purpose. */
	}

	/**
	 * Prevent unserializing.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function __wakeup() {
		/* Empty on purpose. */
	}

	// endregion

	// region METHODS

	/**
	 * Returns the singleton instance of the plugin.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  Plugin
	 */
	public static function get_instance(): self {
		static $instance = null;

		if ( null === $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Returns true if all the plugin's dependencies are met.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string|null $minimum_wc_version The minimum WooCommerce version required.
	 *
	 * @return  boolean
	 */
	public function is_active( string &$minimum_wc_version = null ): bool {
		// Check if WooCommerce is active.
		$woocommerce_exists = \class_exists( 'WooCommerce' ) && \defined( 'WC_VERSION' );
		if ( ! $woocommerce_exists ) {
			return false;
		}

		// Get the minimum WooCommerce version required from the plugin's header, if needed.
		if ( null === $minimum_wc_version ) {
			$updated_plugin_metadata = \get_plugin_data( \trailingslashit( WP_PLUGIN_DIR ) . WPCOMSP_T5PI_BASENAME, false, false );
			if ( ! \array_key_exists( \WC_Plugin_Updates::VERSION_REQUIRED_HEADER, $updated_plugin_metadata ) ) {
				return false;
			}

			$minimum_wc_version = $updated_plugin_metadata[ \WC_Plugin_Updates::VERSION_REQUIRED_HEADER ];
		}

		// Check if WooCommerce version is supported.
		$woocommerce_supported = \version_compare( WC_VERSION, $minimum_wc_version, '>=' );
		if ( ! $woocommerce_supported ) {
			return false;
		}

		// Custom requirements check out, just ensure basic requirements are met.
		return true === WPCOMSP_T5PI_REQUIREMENTS;
	}

	/**
	 * Initializes the plugin components.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		foreach ( glob( WPCOMSP_T5PI_PATH . 'includes/*.php' ) as $file ) {
			require_once $file;
		}
	}

	// endregion
}
