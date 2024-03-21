<?php

namespace WPcomSpecialProjects\Team51PatternInserter;

defined( 'ABSPATH' ) || exit; // @phpstan-ignore-line

/**
 * Settings class.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Settings {

	/**
	 * Initializes the class.
	 *
	 * @return void
	 */
	public function initialize(): void {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
	}

	/**
	 * Adds a settings page.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @return void
	 */
	public function add_settings_page(): void {
		add_options_page(
			__( 'Pattern Inserter', 'wpcomsp-team51-pattern-inserter' ),
			__( 'Pattern Inserter', 'wpcomsp-team51-pattern-inserter' ),
			'manage_options',
			'pattern_inserter_settings',
			array( $this, 'display_settings' )
		);
	}

	/**
	 * Display settings page.
	 *
	 * @return void
	 */
	public function display_settings(): void {
		$options = get_option( 'wpcomsp_team51_pattern_inserter' );

		if ( ! is_array( $options ) ) {
			$options = array(
				'last_update'  => 'Now',
				'num_patterns' => 0,
			);
		}

		if ( is_numeric( $options['last_update'] ) ) {
			$time_diff              = human_time_diff( $options['last_update'], current_time( 'timestamp' ) );
			$options['last_update'] = sprintf( __( '%s ago', 'wpcomsp_team51_pattern_inserter' ), $time_diff );
		}

		if ( isset( $_POST['clear_cache'] ) && wp_verify_nonce( $_POST['clear_cache_nonce'], 'clear_cache' ) ) {
			delete_transient( 'wpcom_special_projects_patterns' );
		}

		ob_start();
		include WPCOMSP_T5PI_PATH . 'templates/admin/settings.php';
		$html = ob_get_contents();
		ob_end_clean();

		echo wp_kses_post( $html );
	}
}
