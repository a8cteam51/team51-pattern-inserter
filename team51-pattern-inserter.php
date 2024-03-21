<?php
/**
 * The Team 51 Pattern Inserter bootstrap file.
 *
 * @since       1.0.0
 * @version     1.0.0
 * @author      WordPress.com Special Projects
 * @license     GPL-3.0-or-later
 *
 * @noinspection    ALL
 *
 * @wordpress-plugin
 * Plugin Name:             Team 51 Pattern Inserter
 * Plugin URI:              https://wpspecialprojects.wordpress.com
 * Description:             Inserts official Team 51 patterns into your content.
 * Version:                 1.0.0
 * Requires at least:       6.2
 * Tested up to:            6.2
 * Requires PHP:            8.0
 * Author:                  WordPress.com Special Projects
 * Author URI:              https://wpspecialprojects.wordpress.com
 * License:                 GPL v3 or later
 * License URI:             https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:             wpcomsp-team51-pattern-inserter
 * Domain Path:             /languages
 * WC requires at least:    7.4
 * WC tested up to:         7.4
 **/

defined( 'ABSPATH' ) || exit;

// Define plugin constants.
function_exists( 'get_plugin_data' ) || require_once ABSPATH . 'wp-admin/includes/plugin.php';
define( 'WPCOMSP_T5PI_METADATA', get_plugin_data( __FILE__, false, false ) );

define( 'WPCOMSP_T5PI_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPCOMSP_T5PI_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPCOMSP_T5PI_URL', plugin_dir_url( __FILE__ ) );

// Load plugin translations so they are available even for the error admin notices.
add_action(
	'init',
	static function() {
		load_plugin_textdomain(
			WPCOMSP_T5PI_METADATA['TextDomain'],
			false,
			dirname( WPCOMSP_T5PI_BASENAME ) . WPCOMSP_T5PI_METADATA['DomainPath']
		);
	}
);

// Load the autoloader.
if ( ! is_file( WPCOMSP_T5PI_PATH . '/vendor/autoload.php' ) ) {
	add_action(
		'admin_notices',
		static function() {
			$message      = __( 'It seems like <strong>Team 51 Pattern Inserter</strong> is corrupted. Please reinstall!', 'wpcomsp-team51-pattern-inserter' );
			$html_message = wp_sprintf( '<div class="error notice wpcomsp-team51-pattern-inserter-error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	);
	return;
}
require_once WPCOMSP_T5PI_PATH . '/vendor/autoload.php';

require_once WPCOMSP_T5PI_PATH . 'functions.php';
add_action( 'plugins_loaded', array( wpcomsp_t5pi_get_plugin_instance(), 'initialize' ) );
