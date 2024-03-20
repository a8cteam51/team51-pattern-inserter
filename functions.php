<?php

defined( 'ABSPATH' ) || exit;

use WPCOMSpecialProjects\Team51PatternInserter\Plugin;

// region

/**
 * Returns the plugin's main class instance.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  Plugin
 */
function wpcomsp_t5pi_get_plugin_instance(): Plugin {
	return Plugin::get_instance();
}

/**
 * Returns the plugin's slug.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function wpcomsp_t5pi_get_plugin_slug(): string {
	return sanitize_key( WPCOMSP_T5PI_METADATA['TextDomain'] );
}

// endregion

//region OTHERS

require WPCOMSP_T5PI_PATH . 'includes/assets.php';
require WPCOMSP_T5PI_PATH . 'includes/settings.php';

// endregion
