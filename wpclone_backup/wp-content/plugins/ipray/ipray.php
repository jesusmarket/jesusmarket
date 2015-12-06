<?php
/********************
 * @package iPray   *
 *******************/
 
/*
Plugin Name: iPray
Plugin URI: http://imitheme.com/plugins/ipray
Description: iPray is a prayeres wall plugin. To get started: 1) Click the "Activate" link to the left of this description.
Version: 1.1
Author: imithemes
Author URI: http://imithemes.com/plugins/ipray
License: GPLv2 or later
*/

#Don't load directly
if ( ! defined('ABSPATH') ) { die(); }

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
#declare common constant
define( 'EXT', '.php' );
define( 'IPRAY__VERSION', '1.0.0' );
define( 'IPRAY__MINIMUM_WP_VERSION', '4.0');
define( 'IPRAY__CLSPRE', 'ipray_' );
define( 'IPRAY__ADMIN_PATH', 'admin');
define( 'IPRAY__LIB_PATH',   'libraries');
define( 'IPRAY__PUBLIC_PATH','public');
define( 'DIRSEP', DIRECTORY_SEPARATOR);
define( 'IPRAY__PLUGIN_URL', plugin_dir_url( __FILE__ ));
define( 'IPRAY__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define( 'IPRAY__LOADER',IPRAY__PLUGIN_URL.'/'.IPRAY__PUBLIC_PATH.'/templates/images/Loader.gif');
#plugin activation hook
register_activation_hook( __FILE__, array('ipray', 'plugin_ipray_activation') );
#plugin deactivation hook
register_deactivation_hook( __FILE__, array('ipray', 'plugin_ipray_deactivation') );
#only admin allow
if (is_admin()) {
 #main file
require_once(IPRAY__PLUGIN_DIR.IPRAY__LIB_PATH.DIRSEP.IPRAY__CLSPRE.'admin_init'.EXT);
}
#for frontend
if (!is_admin()) {
	require_once(IPRAY__PLUGIN_DIR.IPRAY__LIB_PATH.DIRSEP.IPRAY__CLSPRE.'frontend_init'.EXT);
}