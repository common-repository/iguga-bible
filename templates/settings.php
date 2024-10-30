<?php
/**
 * Iguga Bible General Settings page template
 *
 * @category Template
 * @package IgugaBible
 * @author Ivan Mota
 * @license https://www.gnu.org/copyleft/gpl-3.0.html GNU General Public License v3.0
 * @link https://iguga.org
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>
<div class="wrap" id="iguga_bible_settings">
	<h1><?php esc_attr_e( 'iGuga Bible', 'iguga-bible' ); ?></h2>
	<em><?php esc_attr_e( 'Plugin version:', 'iguga-bible' ); ?>: <?php echo WPIG_BIBLE_VER; ?></em>
	<div class="iguga_bible_wrapper">
		<div class="content_cell">
			<form method="post" action="options.php">
			<?php
				@settings_fields( 'iguga_bible_custom_settings' );
				@do_settings_sections( 'iguga_bible' );
				@submit_button();
			?>
			</form>
		</div><!-- .content_cell -->

		<div class="sidebar_container">
			<a href="https://iguga.org/donate/?donate_for=wordpress-iguga-bible" class="igbible-button paypal_donate" target="_blank"><?php esc_attr_e( 'Donate', 'iguga-bible' ); ?></a>
			<br />
			<a href="https://wordpress.org/plugins/iguga-bible/faq/" class="igbible-button" target="_blank"><?php esc_attr_e( 'FAQ', 'iguga-bible' ); ?></a>
			<br />
			<a href="https://wordpress.org/support/plugin/iguga-bible" class="igbible-button" target="_blank"><?php esc_attr_e( 'Community Support', 'iguga-bible' ); ?></a>
			<br />
			<a href="https://wordpress.org/support/view/plugin-reviews/iguga-bible#postform" class="igbible-button" target="_blank"><?php esc_attr_e( 'Review this plugin', 'iguga-bible' ); ?></a>
		</div><!-- .sidebar_container -->
	</div><!-- .iguga_bible_wrapper -->
</div>
