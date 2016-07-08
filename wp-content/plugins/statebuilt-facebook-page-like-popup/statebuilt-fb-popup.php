<?php
/**
 * Plugin Name: Statebuilt Facebook Page Like Popup
 * Plugin URI: http://statebuilt.com
 * Description: Promote your Facebook Fan Page with a sleek customizable slide-in popup. Supports 91 different languages.
 * Version: 1.2.7
 * Author: STATE BUILT
 * Author URI: http://statebuilt.com
 * License: GPLv2 or later
 */

// if this file is called directly, abort
if ( ! defined( 'WPINC') ) {
	die;
} 

// Activation
function sbfp_activate_plugin() {

    $default_page_info = array (
    	'sbfp_page_url' => 'statebuilt',
    	'sbfp_page_title' => 'State Built',
    	'sbfp_language' => 'en_US',
    	'sbfp_popup_activate' => false,
    	'sbfp_popup_countdown' => 15,
    	'sbfp_popup_timeout' => 10
    );

    add_option('sbfp', $default_page_info);
}

// Deactivation
register_activation_hook( __FILE__, 'sbfp_activate_plugin' );

function sbfp_deactivate_plugin() {
	delete_option('sbfp');
}
register_deactivation_hook( __FILE__, 'sbfp_deactivate_plugin' );

// Load Settings File
require_once ( plugin_dir_path(__FILE__) . 'admin/sbfp-settings.php' );

// Add Settings Link to Plugins Page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sbfp_add_action_links' );
function sbfp_add_action_links ( $links ) {
	$sbfp_links = array(
		'<a href="' . admin_url( 'options-general.php?page=sbfp' ) . '">Settings</a>',
	);
return array_merge( $links, $sbfp_links );
}

/*-------------------------------------------*
* Enqueue Scripts & Styles
/*-------------------------------------------*/
function sbfp_assets() {

	wp_enqueue_script( 'sbfp_cookie', plugin_dir_url(__FILE__) . 'assets/jquery.cookie.js', array( 'jquery' ), '1.8.1', true );
	wp_enqueue_script( 'sbfp_script', plugin_dir_url(__FILE__) . 'assets/sbfp-script.js', array( 'jquery' ), '1.8.1', true );

	// Set PHP Variables for wp_localize_script
	$options  	= (array)get_option('sbfp');
	$countdown	= $options['sbfp_popup_countdown']; // Seconds before firing the popup
	$timeout	= $options['sbfp_popup_timeout']; // Seconds before firing the popup

	$sbfp_script_vars = array(
    'countdown'			=> __( $countdown ),
    'timeout'			=> __( $timeout )
	);
	wp_localize_script( 'sbfp_script', 'sbfp_script_data', $sbfp_script_vars );

	wp_enqueue_style( 'sbfp_style', plugin_dir_url(__FILE__) . 'assets/sbfp.css' );
}
add_action( 'wp_enqueue_scripts', 'sbfp_assets' );

// Add Facebook's SDK for the Page Plugin to Display
function sbfp_sdk() {

	// Language Support
	require_once ( plugin_dir_path(__FILE__) . '/assets/sbfp-languages.php' );
	$options = (array)get_option('sbfp');	 // Options Group

	if(isset($options['sbfp_language'])) {
		$language 	= $options['sbfp_language']; // Facebook Page Language Option 
	} else {
		$language = 'en_US';
	} ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0]; 
		
		if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/<?php if(isset($options['sbfp_language'])) { echo sanitize_text_field( $language ); } else { echo $language; } ?>/sdk.js#xfbml=1&version=v2.5&appId=417184695094507";
			fjs.parentNode.insertBefore(js, fjs);
		} (document, 'script', 'facebook-jssdk'));
	</script>
	<?php
}

// Render Popup On the Site
function sbfp_show() {

	$options 	= (array)get_option('sbfp');			// Options Group
	$url  		= $options['sbfp_page_url']; 			// Facebook URL Option
	$title  	= $options['sbfp_page_title']; 			// Facebook Page Title Option

	if ( isset($options['sbfp_popup_activate']) && $options['sbfp_popup_activate'] == '1') {
		// Show popup if the popup has been activated in the settings 
	?>

		<div class="state-fb-pop-up">
			<div class="state-fb-pop-up-close">
				<img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/popup-close-light.png'; ?>" alt="Close">
			</div>
			<?php include ( ABSPATH . 'wp-content/plugins/statebuilt-facebook-page-like-popup/facebook-popup-contents.php' ); ?>
		</div>

	<?php } else {
			// Show nothing if Popup is not activated in the Settings
		    } ?>

<?php
}

add_action( 'wp_footer', 'sbfp_sdk');
add_action( 'wp_footer', 'sbfp_show');
