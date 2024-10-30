<?php
/**
 * The Plugin unnistall script
 *
 * @link        https://iguga.org
 * @since       1.0.0
 * @package     IgugaBible
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * If uninstall is not called from WordPress, exit
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$igbible_options = array( 'igbible_settings', 'igbible_db_ver' );
foreach ( $igbible_options as $option_name ) {
	/**
	 * Delete option on single site
	 */
	delete_option( $option_name );
}
