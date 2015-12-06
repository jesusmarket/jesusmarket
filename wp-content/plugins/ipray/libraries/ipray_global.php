<?php // Don't load directly
if ( ! defined('ABSPATH') ) { die(); } 
class ipray_global {
/* constructor calling */
public function __construct()
{
   //tidy up
}
/**
  register prayer post type
  @param : null
  return : null
  cope: public
*/
public static function ipray_register() {
  #register custom post type for event
  $labels = array(
        'name' => __('Prayers', 'ipray-plugin'),
        'singular_name' => __('Prayer', 'ipray-plugin'),
        'add_new' => __('Add New', 'ipray-plugin'),
        'add_new_item' => __('Add new prayer', 'ipray-plugin'),
        'edit_item' => __('Edit Prayer', 'ipray-plugin'),
        'new_item' => __('New Prayer', 'ipray-plugin'),
        'view_item' => __('View Prayer', 'ipray-plugin'),
        'search_items' => __('Search Prayer', 'ipray-plugin'),
        'not_found' => __('No prayers have been added yet', 'ipray-plugin'),
        'not_found_in_trash' => __('Nothing found in Trash', 'ipray-plugin'),
        'parent_item_colon' => '',
    );
   $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'author'),
        'has_archive' => true,
        'taxonomies' => array(),
    );
    register_post_type('prayer', $args);
}
public static function getMetaBox()
{
	$prayer_anonymous   =  get_option('prayer_anonymous');
	$prayer_anonymous   =  ($prayer_anonymous!='' && !empty($prayer_anonymous))?$prayer_anonymous:'';
	
	$options = array(
                '0' => __('Share this','ipray-plugin'),
				'1' => __('Share this anonymously','ipray-plugin'),
				'2' => __('Do not share this','ipray-plugin'),
            );
	if(empty($prayer_anonymous))
	{
		$options = array(
                '0' => __('Share this','ipray-plugin'),
				'2' => __('Do not share this','ipray-plugin'),
				);
	}

			
	return $ipray_meta_box = array(
    'id' => 'prayer_metabox_box',
    'title' => __('Prayer Extra Fields', 'ipray-plugin'),
    'context' => 'normal',    
    'priority' => 'high',
    'fields' => array( 		 
		array(
            'name' => __('Your Name:', 'ipray-plugin'),
            'id' =>'ipray_owner_name',
            'desc' => __("Enter your name.", 'ipray-plugin'),
            'type' => 'text',
            'default' => '',
		),
		array(
            'name' => __('Your Email:', 'ipray-plugin'),
            'id' =>'ipray_owner_email',
            'desc' => __("Enter your name.",'ipray-plugin'),
            'type' => 'text',
            'default' => '',
		),
		array(
            'name' => __('Your Phone:','ipray-plugin'),
            'id' => 'ipray_owner_phone',
            'desc' => __("Enter your phone", 'ipray-plugin'),
            'type' => 'text',
			'default' => '',
		),
        array(
            'name'    => __('Please...', 'ipray-plugin'),
            'id'      => 'ipray_desired_share_option',
            'desc'    => __("Desired share option", 'ipray-plugin'),
            'type'    => 'select',
            'options' => $options,
        ),
		array(
            'name' => __('Email me when someone prays for me', 'ipray-plugin'),
            'id' => 'ipray_prayer_notifyme',
            'desc' => __("Please check for notification", 'ipray-plugin'),
            'type' => 'checkbox',
        ),
    )
);
}

/**
 register prayer page
 @param : null
 return : null
 scope: public
*/
public static function ipray_register_page() {
    #start add page setting
	add_submenu_page('edit.php?post_type=prayer', __('Settings', 'ipray-plugin'), __('Settings', 'ipray-plugin'), 'edit_posts', 'ipray_setting', array('ipray_page','ipray_setting'));
	#end add page setting 
}
/* add meta box */
public static function ipray_add_meta_box() {

$ipray_meta_box = ipray_global::getMetaBox();
   add_meta_box($ipray_meta_box['id'], $ipray_meta_box['title'], 'ipray_format_meta_box', 'prayer', $ipray_meta_box['context'], $ipray_meta_box['priority']);

}

/**
 ipray setting options
 @param : null
 return : null
 scope: public
*/

public static function register_ipray_page_fields() {   
  if(isset($_REQUEST['prayer_submit_option_page']))
  {
	  if(isset($_REQUEST['prayer_subscribe']))
	     update_option('prayer_subscribe', 1);
	  else 
		 update_option('prayer_subscribe', 0);
	  
	  if(isset($_REQUEST['prayer_anonymous']))
	     update_option('prayer_anonymous', 1);
	  else 
		 update_option('prayer_anonymous', 0);
	  
	  if(isset($_REQUEST['prayer_modification']))
	     update_option('prayer_modification', 1);
	  else 
		 update_option('prayer_modification', 0);
	  
	  if(isset($_REQUEST['prayer_success_msg']))
	  {
		 $prayer_success_msg = trim($_REQUEST['prayer_success_msg']);
	     update_option('prayer_success_msg', $prayer_success_msg);
	  }
	  
	  if(isset($_REQUEST['prayer_to_show']))
	  {
		 $prayer_to_show = trim($_REQUEST['prayer_to_show']);
	     update_option('prayer_to_show', (int)$prayer_to_show);
	  }
	  
	  if(isset($_REQUEST['prayer_pagination']))
	  {
		 $prayer_pagination = trim($_REQUEST['prayer_pagination']);
	     update_option('prayer_pagination', (int)$prayer_pagination);
	  } 
	  
	  if(isset($_REQUEST['prayer_instruction']))
	  {
		 $prayer_instruction = trim($_REQUEST['prayer_instruction']);
	     update_option('prayer_instruction', $prayer_instruction);
	  } 
	  
	  if(isset($_REQUEST['prayer_bootstrap_css']))
	  {
		 $prayer_bootstrap_css = trim($_REQUEST['prayer_bootstrap_css']);
	     update_option('prayer_bootstrap_css', $prayer_bootstrap_css);
	  } 
	  if(isset($_REQUEST['prayer_bootstrap_js']))
	  {
		 $prayer_bootstrap_js = trim($_REQUEST['prayer_bootstrap_js']);
	     update_option('prayer_bootstrap_js', $prayer_bootstrap_js);
	  } 
  }
}
}