<?php
/**
 * The iGuga Bible database update
 *
 * @package IgugaBible
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Run the incremental updates one by one.
 *
 * For example, if the current DB version is 3, and the target DB version is 6,
 * this function will execute update routines if they exist:
 *  - igbible_update_4()
 *  - igbible_update_5()
 *  - igbible_update_6()
 */
function igbible_update() {
	// Disable PHP timeout for running updates.
	set_time_limit( 0 );

	// Get the current database schema version number.
	$current_db_ver = get_option( 'igbible_db_ver', 0 );

	// Get the target version that we need to reach.
	$target_db_ver = WPIG_BIBLE_DB_VER;

	// Run update routines one by one until the current version number
	// reaches the target version number.
	while ( $current_db_ver < $target_db_ver ) {
		// Increment the current_db_ver by one.
		++$current_db_ver;

		// Each DB version will require a separate update function
		// for example, for db_ver 3, the function name should be igbible_update_3.
		$func = "igbible_update_{$current_db_ver}";
		if ( function_exists( $func ) ) {
			call_user_func( $func );
		}

		// Update the option in the database,
		// so that this process can always pick up where it left off.
		update_option( 'igbible_db_ver', $current_db_ver );
	}

} // END function igbible_update()

/**
 * Initialize updater
 */
function igbible_update_1() {

	// Get options from DB.
	$defaults = get_option( 'igbible_settings' );

	$need_update = false;

	// Check whether the index "bible_custom_code" exists.
	if ( ! isset( $defaults['bible_custom_code'] ) ) {
		$need_update = true;

		$defaults['bible_custom_code'] = '';
	}

	// Check whether the index "dictionary_custom_code" exists.
	if ( ! isset( $defaults['dictionary_custom_code'] ) ) {
		$need_update = true;

		$defaults['dictionary_custom_code'] = '';
	}

	if ( $need_update ) {
		update_option( 'igbible_settings', $defaults );
	}

} // END function igbible_update_1()
