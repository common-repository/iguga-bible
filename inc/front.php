<?php
/**
 * The iGuga Bible front scritp
 *
 * @package IgugaBible
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Function to registe the iGuga! Bible Shortcode
 */
function igbible_bible_shortcode_scripts() {

	$igbible_settings = igbible_defaults();

	if ( empty( $igbible_settings['dictionary_custom_code'] ) ) {
		$igbible_settings['dictionary_custom_code'] = '1612dca508867f6102edca7d9175281a';
	}

	$bible_custom_code = $igbible_settings['bible_custom_code'];

	?>
	<script type="text/javascript" src="https://www.iguga.org/js/igpostmessage.js"></script>
	<script type="text/javascript">
		window.onload = function()
		{
			var iGugaBibleContainer = document.getElementById("iGugaBibleContainer");
			if (typeof iGugaBibleContainer !== "undefined" && iGugaBibleContainer !== null) {
				var iGugaBibleCustomLink = 'https://www.iguga.org/bible/searchFrame/ID/<?php echo esc_attr( $bible_custom_code ); ?>';
				var iGugaBibleFrameSource = iGugaBibleCustomLink + '?fromUrl=' + encodeURIComponent(document.location.href);
				iGugaBibleContainer.innerHTML = '<iframe id="iGugaBibleFrame" src="' + iGugaBibleFrameSource
					+ '" style="height: 1000px; width: 100%;" scrolling="no" allowtransparency="true" frameborder="0"></iframe>';
			}
		}
		igPostMessage.receiveMessage(function(event)
		{
			if ((!isNaN(event.data)) && (event.data > 0))
			{
				var iGugaBibleFrame = document.getElementById("iGugaBibleFrame");
				if (typeof iGugaBibleFrame !== "undefined" && iGugaBibleFrame !== null) {
					iGugaBibleFrame.style.height = '100%';
					iGugaBibleContainer.style.height = event.data + 'px';
				}
			}
		}, 'https://www.iguga.org');
	</script>
	<?php
}

/**
 * The function to implement the bible shortcode
 *
 * @param array $atts the shortcodes attributes.
 * @param string|null $content the shortcode content.
 */
function igbible_bible_shortcode( $atts, $content = null ) {
	add_action( 'wp_footer', 'igbible_bible_shortcode_scripts', 50 );

	return '<div id="iGugaBibleContainer"><a href="https://www.iguga.org">'
		. esc_attr__( 'iGuga Online Bible', 'iguga-bible' ) . '</a></div>';
}
add_shortcode( 'igugabible', 'igbible_bible_shortcode' );

/**
 * Function to register the iGuga! Dictionary Shortcode scripts
 */
function igbible_dictionary_shortcode_scripts() {

	$igbible_settings = igbible_defaults();

	if ( empty( $igbible_settings['dictionary_custom_code'] ) ) {
		$igbible_settings['dictionary_custom_code'] = '1612dca508867f6102edca7d9175281a';
	}

	$dictionary_custom_code = $igbible_settings['dictionary_custom_code'];

	?>
	<script type="text/javascript" src="https://www.iguga.org/js/igpostmessage.js"></script>
	<script type="text/javascript">
		window.onload = function()
		{
			var iGugaDictionaryContainer = document.getElementById("iGugaDictionaryContainer");
			if (typeof iGugaDictionaryContainer !== "undefined" && iGugaDictionaryContainer !== null) {
				var iGugaDictionaryCustomLink = 'https://www.iguga.org/bible/dictionaryFrame/ID/<?php echo esc_attr( $dictionary_custom_code ); ?>';
				var iGugaDictionaryFrameSource = iGugaDictionaryCustomLink + '?fromUrl=' + encodeURIComponent(document.location.href);
				iGugaDictionaryContainer.innerHTML = '<iframe id="iGugaDictionaryFrame" src="' + iGugaDictionaryFrameSource + '" style="height: 1000px; width: 100%;" scrolling="no" allowtransparency="true" frameborder="0"></iframe>';
			}
		}
		igPostMessage.receiveMessage(function(event)
		{
			if ((!isNaN(event.data)) && (event.data > 0))
			{
				var iGugaDictionaryFrame = document.getElementById("iGugaDictionaryFrame");
				if (typeof iGugaDictionaryFrame !== "undefined" && iGugaDictionaryFrame !== null) {
					iGugaDictionaryFrame.style.height = '100%';
					iGugaDictionaryContainer.style.height = event.data + 'px';
				}
			}
		}, 'https://www.iguga.org');
	</script>
	<?php
}

/**
 * The function to implement the dictionary shortcode
 *
 * @param array $atts the shortcodes attributes.
 * @param string|null $content the shortcode content.
 */
function igbible_dictionary_shortcode( $atts, $content = null ) {
	add_action( 'wp_footer', 'igbible_dictionary_shortcode_scripts', 50 );
	return '<div id="iGugaDictionaryContainer"><a href="https://www.iguga.org">'
		. esc_attr__( 'iGuga Bible Dictionary', 'iguga-bible' ) . '</a></div>';
}
add_shortcode( 'igugadictionary', 'igbible_dictionary_shortcode' );
