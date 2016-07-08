<?php
add_action( 'admin_menu', 'sbfp_admin_add_page' );
function sbfp_admin_add_page() {
	add_options_page( 
		'Statebuilt Facebook Popup Settings', 		// Title of Page
		'Statebuilt FB Popup', 										// Title to show on Menu in Dashboard
		'manage_options', 												// Capabilities Required (manage_options = Administrator)
		'sbfp', 																	// Slug for Options Page
		'sbfp_options_page' 											// Callback function to display the page
	);
}

// Render the Settings Page
function sbfp_options_page() {
?>
	<style>
	<?php include 'admin.css'; ?>
	</style>
	<div class="wrap">
		<h2>Statebuilt Facebook Page Like Popup Settings</h2>
		<form action="options.php" method="post">
			<?php settings_fields( 'sbfp' ); ?>
			<?php do_settings_sections( 'sbfp' ); ?>
			<?php submit_button(); ?>
		</form>
		<div class="like-it">
			<h2>Do you like this plugin?</h2>
			<h3>Please rate it and consider a donation!</h3>
			<a class="btn donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FMSGLA48SV8VU" target="_blank">DONATE</a>
			<a class="btn rate" href="https://wordpress.org/support/view/plugin-reviews/statebuilt-facebook-page-like-popup" target="_blank">RATE</a>
		</div>
	</div>
<?php
}

add_action( 'admin_init', 'sbfp_admin_init' );
function sbfp_admin_init(){
	// Create Settings
	register_setting( 
		'sbfp', 
		'sbfp' 
	);

	// Create Facebook Page Info Section
	add_settings_section( 
		'sbfp_fb_page_info_settings_section', 				// ID of the Facebook Page Info Settings Section
		'Facebook Page Info', 								// Title of the Facebook Page Info Settings Sections
		'sbfp_fb_page_info_settings_section_display', 		// Callback function to display the Section Description Text
		'sbfp'												// Page on which to display the Facebook Page Info Settings Section
	);
	
	// Add Facebook URL field to Facebook Page Info Section
	add_settings_field( 
		'sbfp_page_url',						// ID for the Facebook Page URL Field
		'Facebook Page URL', 					// Title for the Facebook Page URL Field
		'sbfp_page_url_display', 				// Callback function to display the Facebook URL Field
		'sbfp', 								// Page on which to display the Facebook Page URL Field
		'sbfp_fb_page_info_settings_section' 	// Section in which to display the Facebook Page URL Field
	);

	// Add Facebook Page Title field to Facebook Page Info Section
	add_settings_field( 
		'sbfp_page_title', 						// ID for the Facebook Page title Field
		'Facebook Page Title', 					// Title for the Facebook Page title Field
		'sbfp_page_title_display', 				// Callback function to display the Facebook title Field
		'sbfp',									// Page on which to display the Facebook Page Title Field
		'sbfp_fb_page_info_settings_section'	// Section in which to display the Facebook Page Title Field
	);

	// Add Facebook language field to Facebook Page Info Section
	add_settings_field( 
		'sbfp_language',						// ID for the Facebook Page language Field
		'Language', 							// Title for the Facebook Page language Field
		'sbfp_language_display', 				// Callback function to display the Facebook language Field
		'sbfp', 								// Page on which to display the Facebook Page language Field
		'sbfp_fb_page_info_settings_section' 	// Section in which to display the Facebook Page language Field
	);

	// Create Popup Settings Section
	add_settings_section( 
		'sbfp_popup_settings_section', 					// ID of the Popup Settings Section
		'Popup Settings', 								// Title of the Popup Settings Section
		'sbfp_popup_settings_section_display', 			// Callback function to display the Section Description Text
		'sbfp'											// Page on which to display the Popup Settings Section
	);

	// Add Time Before Firing Field to Popup Settings Section
	add_settings_field( 
		'sbfp_popup_activate',					// ID for the Activate Popup Field
		'Activate Popup',						// activate for the Activate Popup Field'
		'sbfp_popup_activate_display',	 		// Callback function to display the Activate Popup Field
		'sbfp', 								// Page on which to display the Activate Popup Field
		'sbfp_popup_settings_section'			// Section in which to display the Activate Popup Field
	);

	// Add Time Before Firing Field to Popup Settings Section
	add_settings_field( 
		'sbfp_popup_countdown',					// ID for the Popup Countdown Field
		'Popup Countdown',	 						// Time for the Popup Countdown Field
		'sbfp_popup_countdown_display', 		// Callback function to display the Popup Countdown Field
		'sbfp', 								// Page on which to display the Popup Countdown Field
		'sbfp_popup_settings_section'			// Section in which to display the Popup Countdown Field
	);
	
	// Add Time to wait in between firing to Popup Settings Section
	add_settings_field( 
	'sbfp_popup_timeout', 					// ID for the Popup Timout Field
	'Popup Timeout',	 					// Title for the Popup Timout Field
	'sbfp_popup_timeout_display', 			// Callback function to display the Popup Timeout Field
	'sbfp', 								// Page on which to display the Popup Timeout Field
	'sbfp_popup_settings_section'			// Section in which to display the Popup Timeout Field
	);
	
}

// Description of Facebook Page Info Settings Section
function sbfp_fb_page_info_settings_section_display() {
	preview_display(); 
}

function preview_display() { 
	
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

	$options = (array)get_option('sbfp');			// Options Group
	$url  = $options['sbfp_page_url']; 				// Facebook URL Option
	$title  = $options['sbfp_page_title']; 			// Facebook Page Title Option
	
	?>
		<h3 class="preview-label">Preview</h3>
		<div class="state-fb-pop-up-preview">
			<?php echo '<h5>Save changes to update preview</h5>'; ?>
			<?php include ( ABSPATH . 'wp-content/plugins/statebuilt-facebook-page-like-popup/facebook-popup-contents.php' ); ?>
		</div>
	<?php
}

// Render the Facebook Page URL Field
function sbfp_page_url_display() {
	$options  	= (array)get_option('sbfp');
	$url 		= $options['sbfp_page_url']; // Facebook Page URL Option

	echo '
		<p class="settings-field-desc">Enter the URL of your Facebook Page</p>
		https://www.facebook.com/<input name="sbfp[sbfp_page_url]" id="sbfp_page_url" value="'; 
		if (isset($url)) { 
			echo sanitize_text_field($url);

		}
	echo '" />';
}

// Render the Facbook Page Title Field
function sbfp_page_title_display() {
	$options  	= (array)get_option('sbfp');
	$title 		= $options['sbfp_page_title']; // Facebook Page Title Option

	echo '
		<p class="settings-field-desc">Enter the title of your Facebook Page</p>
		<input name="sbfp[sbfp_page_title]" id="sbfp_page_title" value="'; 
		if (isset($title)) { 
			echo sanitize_text_field( $title );
		}
	echo '" />';
}

// Render the Facbook Page Language Field
function sbfp_language_display() {
	
	require_once ( plugin_dir_path(__FILE__) . '../assets/sbfp-languages.php' );
	
	sbfp_language_options();

}

// Description of Popup Settings Section
function sbfp_popup_settings_section_display() {
	echo '<p class="settings-section-desc">You can adjust the timers for your Popup to wait X seconds before firing on a page and X minutes in between firing for the user';
}

function sbfp_popup_activate_display() {
	$options    = (array)get_option('sbfp');

	if ( !isset($options['sbfp_popup_activate']) ) {
		$options['sbfp_popup_activate'] = false;
		add_option( 'sbfp', $options['sbfp_popup_activate']);
	}
	
	$activate 	= $options['sbfp_popup_activate']; // Activate/Deactivate the Popup	

	echo '
		<input type="checkbox" name="sbfp[sbfp_popup_activate]" id="sbfp_popup_activate" value="1"';

		echo checked( 1, $activate, false );

	echo ' /> <label for="sbfp_popup_activate">Check this box to activate the popup on your site.</label>';

}

function sbfp_popup_countdown_display() {
	$options  	= (array)get_option('sbfp');
	$countdown	= $options['sbfp_popup_countdown']; // Seconds before firing the popup

	echo '
		<p class="settings-field-desc">Set the amount of time (in seconds) you would like the popup to wait before loading onto the page.</p>
		<input type="number" size="4" maxlength="4" name="sbfp[sbfp_popup_countdown]" id="sbfp_popup_countdown" value="'; 
		if (isset($countdown)) { 
			echo intval($countdown); 
		} 
	echo '" /> seconds';
}

function sbfp_popup_timeout_display() {
	$options  	= (array)get_option('sbfp');
	$timeout	= $options['sbfp_popup_timeout']; // Minutes between firing the popup

	echo '
		<p class="settings-field-desc">Set the amount of time (in minutes) you would like to wait before it shows again.</p>
		<p><small><strong>NOTE:</strong> The popup will <strong>not</strong> fire more than once per page load.</small></p>
		<input type="number" size="4" maxlength="4" name="sbfp[sbfp_popup_timeout]" id="sbfp_popup_timeout" value="'; 
		
		if (isset($timeout)) { 
			echo intval($timeout); 
		}

	echo '" /> minutes';
}