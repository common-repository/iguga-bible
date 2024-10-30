<?php
/**
 * The iGuga Bible plugin helpers
 *
 * @package IgugaBible
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include back-end/front-end resources.
if ( is_admin() ) {
	require_once WPIG_BIBLE_INC . 'settings.php';
} else {
	require_once WPIG_BIBLE_INC . 'front.php';
}

register_activation_hook( WPIG_BIBLE_FILE, 'igbible_activate' );
/**
 * Plugin Activation hook function to check for Minimum PHP and WordPress versions
 */
function igbible_activate() {
	global $wp_version;
	$php_req = '5.4'; // Minimum version of PHP required for this plugin.
	$wp_req  = '4.9'; // Minimum version of WordPress required for this plugin.

	if ( version_compare( PHP_VERSION, $php_req, '<' ) ) {
		$flag = 'PHP';
	} elseif ( version_compare( $wp_version, $wp_req, '<' ) ) {
		$flag = 'WordPress';
	} else {
		return;
	}
	$version = 'PHP' == $flag ? $php_req : $wp_req;
	deactivate_plugins( WPIG_BIBLE_FILE );
	wp_die(
		'<p>The <strong>iGuga Bible</strong> plugin requires' . $flag . ' version ' . $version . ' or greater.</p>',
		'Plugin Activation Error',
		[
			'response'  => 200,
			'back_link' => true,
		]
	);

	// Trigger updater function.
	igbible_maybe_update();
} // END function igbible_activate()

// Regular update trigger.
add_action( 'plugins_loaded', 'igbible_maybe_update' );

/**
 * Check whether is necessary to update the plugin data or not
 *
 * @return void
 */
function igbible_maybe_update() {
	load_plugin_textdomain( 'iguga-bible', false, dirname( plugin_basename( __DIR__ ) ) . '/languages/' );
	// Bail if this plugin data doesn't need updating.
	if ( get_option( 'igbible_db_ver' ) >= WPIG_BIBLE_DB_VER ) {
		return;
	}
	// Require update script.
	require_once dirname( __FILE__ ) . '/update.php';
	// Trigger update function.
	igbible_update();
} // END function igbible_maybe_update()

/**
 * Provide global defaults
 *
 * @return array Array of defined global values.
 */
function igbible_defaults() {
	$defaults = [
		'bible_custom_code'      => '',
		'dictionary_custom_code' => '',
	];
	$igbible_settings = get_option( 'igbible_settings', $defaults );
	$igbible_settings = wp_parse_args( $igbible_settings, $defaults );
	return $igbible_settings;
} // END function igbible_defaults()

function igbible_string_remove_whitespaces( $string ) {
	return preg_replace( '/\s+/', '', $string );
}
