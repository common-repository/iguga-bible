<?php
/**
 * iGuga Bible Plugin
 *
 * @link        https://iguga.org
 * @since       1.0.0
 * @package     IgugaBible
 *
 * @wordpress-plugin
 * Plugin Name: iGuga Bible
 * Plugin URI:  https://iguga.org/plugins/wp-plugin-iguga-bible/
 * Description: Easy way to add Almeida Corrected and Faithful (ACF) by Trinitarian Bible Society of Brazil to your site
 * Version:     1.0.0
 * Author:      Ivan Mota
 * Author URI:  https://github.com/ivanmota
 * License:     GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: iguga-bible
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$dummy_name = __( 'iGuga Bible', 'iguga-bible' );
$dummy_desc = __( 'Easy way to add Almeida Corrected and Faithful (ACF) by Trinitarian Bible Society of Brazil to your site', 'iguga-bible' );

define( 'WPIG_BIBLE_VER', '1.0.0' );
define( 'WPIG_BIBLE_DB_VER', '1' );
define( 'WPIG_BIBLE_FILE', basename( __FILE__ ) );
define( 'WPIG_BIBLE_INC', dirname( __FILE__ ) . '/inc/' );

// Load files.
require_once 'inc/helpers.php';
