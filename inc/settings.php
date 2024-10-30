<?php
/**
 * If this file is called directly, abort.
 *
 * @package IgugaBible
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Initiate settings section and fields.
add_action( 'admin_init', 'igbible_settings_init' );

// Create menu item for settings page.
add_action( 'admin_menu', 'igbible_add_admin_menu' );

// Add Settings page link to plugin actions cell.
add_filter( 'plugin_action_links_iguga-bible/iguga-bible.php', 'igbible_plugin_settings_link' );

// Update links in plugin row on Plugins page.
add_filter( 'plugin_row_meta', 'igbible_add_plugin_meta_links', 10, 2 );

// Load admin styles on plugin settings page.
add_action( 'admin_enqueue_scripts', 'igbible_admin_enqueue_scripts' );

/**
 * Enqueue the admin style.
 *
 * @param string $hook the hook string.
 */
function igbible_admin_enqueue_scripts( $hook ) {
	if ( 'tools_page_iguga_bible' == $hook ) {
		wp_enqueue_style(
			'head-footer-code-admin',
			plugin_dir_url( __FILE__ ) . '../assets/css/admin.css',
			[],
			WPIG_BIBLE_VER
		);
	}
}

/**
 * Register the iGuga Bible Menu
 */
function igbible_add_admin_menu() {
	add_submenu_page(
		'tools.php',
		__( 'iGuga Bible', 'iguga-bible' ),
		__( 'iGuga Bible', 'iguga-bible' ),
		'manage_options',
		'iguga_bible',
		'igbible_options_page'
	);

}

/**
 * Register a setting and its sanitization callback
 * define section and settings fields
 */
function igbible_settings_init() {
	global $wp_version;

	/**
	 * Get settings from options table
	 */
	$igbible_settings = igbible_defaults();

	/**
	 * Register a setting and its sanitization callback.
	 * This is part of the Settings API, which lets you automatically generate
	 * wp-admin settings pages by registering your settings and using a few
	 * callbacks to control the output.
	 */
	if ( version_compare( $wp_version, '4.7', '<' ) ) {
		register_setting( 'iguga_bible_custom_settings', 'igbible_settings', 'igbible_custom_settings_validate' );
	} else {
		register_setting(
			'iguga_bible_custom_settings',
			'igbible_settings',
			array(
				'sanitize_callback' => 'igbible_custom_settings_validate',
			)
		);
	}

	/**
	 * Settings Sections are the groups of settings you see on WordPress settings pages
	 * with a shared heading. In your plugin you can add new sections to existing
	 * settings pages rather than creating a whole new page. This makes your plugin
	 * simpler to maintain and creates less new pages for users to learn.
	 * You just tell them to change your setting on the relevant existing page.
	 */
	add_settings_section(
		'iguga_bible_custom_settings',
		esc_attr__( 'The Bible and Dictionary Custom Settings', 'iguga-bible' ),
		'igbible_custom_settings_section_description',
		'iguga_bible'
	);

	/**
	 * Register a settings field to a settings page and section.
	 * This is part of the Settings API, which lets you automatically generate
	 * wp-admin settings pages by registering your settings and using a few
	 * callbacks to control the output.
	 */
	add_settings_field(
		'igbible_bible_custom_code',
		__( 'Bible Custom Code', 'iguga-bible' ),
		'igbible_text_field_render',
		'iguga_bible',
		'iguga_bible_custom_settings',
		[
			'field'       => 'igbible_settings[bible_custom_code]',
			'value'       => $igbible_settings['bible_custom_code'],
			'description' => __( 'The code generated on the iguga.org website (login required) to customize your bible. Ex: 1612dca508867f6102edca7d9175281a', 'iguga-bible' ),
			'class'       => 'widefat',
		]
	);

	add_settings_field(
		'igbible_dictionary_custom_code',
		__( 'Dictionary Custom Code', 'iguga-bible' ),
		'igbible_text_field_render',
		'iguga_bible',
		'iguga_bible_custom_settings',
		[
			'field'       => 'igbible_settings[dictionary_custom_code]',
			'value'       => $igbible_settings['dictionary_custom_code'],
			'description' => esc_html__( 'The code generated on the iguga.org website (login required) to customize your dictionary. Ex: 1612dca508867f6102edca7d9175281a', 'iguga-bible' ),
			'class'       => 'widefat',
		]
	);
} // END function igbible_settings_init()


/**
 * This function provides number input for settings fields
 *
 * @param array $args the field args.
 */
function igbible_text_field_render( $args ) {
	printf(
		'<input type="text" name="%1$s" id="%1$s" value="%2$s" class="%3$s" /><p class="description">%4$s</p>',
		esc_attr( $args['field'] ), // name/id .
		esc_attr( $args['value'] ), // value .
		esc_attr( $args['class'] ), // class .
		esc_html( $args['description'] ) // description .
	);
}

function igbible_custom_settings_validate( $inputs ) {
	$type = null;
	$message = null;

	$inputs['bible_custom_code']      = igbible_string_remove_whitespaces( $inputs['bible_custom_code'] );
	$inputs['dictionary_custom_code'] = igbible_string_remove_whitespaces( $inputs['dictionary_custom_code'] );

	if ( '' !== $inputs['bible_custom_code']
		&& ( strlen( $inputs['bible_custom_code'] ) !== 32
			|| preg_match( '/^[a-f0-9]{32}$/i', $inputs['bible_custom_code'] ) !== 1 ) ) {
		$inputs['bible_custom_code'] = '';

		$type    = 'error';
		$message = __( 'The Bible Custom Code is not valid. Should be a alpanumeric code with 32 characters.', 'iguga-bible' );
	}

	if ( '' !== $inputs['dictionary_custom_code']
		&& ( strlen( $inputs['bible_custom_code'] ) !== 32
			|| preg_match( '/^[a-f0-9]{32}$/i', $inputs['bible_custom_code'] ) !== 1 ) ) {
		$inputs['bible_custom_code'] = '';

		$type    = 'error';
		$message = __( 'The Dictionay Custom Code is not valid. Should be a alpanumeric code with 32 characters.', 'iguga-bible' );
	}

	if ( null === $type ) {
		$message = __( 'iGuga Bible settings successfully updated.', 'iguga-bible' );
	}

	add_settings_error(
		'iguga-bible-custom-settings',
		esc_attr( 'settings_updated' ),
		$message,
		$type
	);

	return $inputs;
}

function igbible_custom_settings_section_description() {
	?>
		<p><?php esc_attr_e( 'Bible and the Dictionary customization', 'iguga-bible' ) ?></p>
		<?php settings_errors(); ?>
	<?php
}

function igbible_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_attr__( 'You do not have sufficient permissions to access this page.' ) );
	}
	// Render the settings template.
	include sprintf( '%s/../templates/settings.php', dirname( __FILE__ ) ) ;
}

/**
 * Generate Settings link on Plugins page listing
 * @param  array $links Array of existing plugin row links.
 * @return array        Updated array of plugin row links with link to Settings page
 */
function igbible_plugin_settings_link( $links ) {
	$settings_link = '<a href="tools.php?page=iguga_bible">Settings</a>';
	array_unshift( $links, $settings_link );
	return $links;
}

/**
 * Add link to official plugin pages
 * @param array $links  Array of existing plugin row links.
 * @param string $file  Path of current plugin file.
 * @return array        Array of updated plugin row links
 */
function igbible_add_plugin_meta_links( $links, $file ) {
	if ( 'iguga-bible/iguga-bible.php' === $file ) {
		return array_merge(
			$links,
			[
				sprintf(
					'<a href="https://wordpress.org/support/plugin/iguga-bible" target="_blank">%s</a>',
					__( 'Support', 'iguga-bible' )
				),
				sprintf(
					'<a href="https://iguga.org/donate/?ref=wp-plugin-iguga-bible" target="_blank">%s</a>',
					__( 'Donate', 'iguga-bible' )
				),
			]
		);
	}
	return $links;
}
