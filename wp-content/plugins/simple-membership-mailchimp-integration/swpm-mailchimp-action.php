<?php

add_action('swpm_front_end_registration_complete', 'swpm_do_mailchimp_signup_rego_complete'); //For core plugin signup
add_action('swpm_front_end_registration_complete_fb', 'swpm_do_mailchimp_signup_form_builder'); //For form builder addon signup
add_action('swmp_wpimport_user_imported', 'swpm_do_imported_user_mailchimp_signup'); //For WP user import addon

function swpm_do_mailchimp_signup_rego_complete(){
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $membership_level = sanitize_text_field($_POST['membership_level']);
    
    //Do the signup
    $args = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'membership_level' => $membership_level);
    swpm_do_mailchimp_signup($args);
}


function swpm_do_mailchimp_signup_form_builder($data) {
    $first_name = sanitize_text_field(isset($data['first_name']) ? $data['first_name'] : '');
    $last_name = sanitize_text_field(isset($data['last_name']) ? $data['last_name'] : '');
    $email = sanitize_email($data['email']);
    $membership_level = sanitize_text_field($data['membership_level']);

    //Do the signup
    $args = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'membership_level' => $membership_level);
    swpm_do_mailchimp_signup($args);
}

function swpm_do_imported_user_mailchimp_signup($args){
    swpm_do_mailchimp_signup($args);
}


/* This function will do the MC signup given the appropriate args have been passed to it */
function swpm_do_mailchimp_signup($args) {
    $first_name = sanitize_text_field($args['first_name']);
    $last_name = sanitize_text_field($args['last_name']);
    $email = sanitize_email($args['email']);
    $membership_level = sanitize_text_field($args['membership_level']);
    
    $level_id = $membership_level;
    $key = 'swpm_mailchimp_list_name';
    $mc_list_name = SwpmMembershipLevelCustom::get_value_by_key($level_id, $key);

    SwpmLog::log_simple_debug("Mailchimp integration addon. After registration hook. Debug data: " . $mc_list_name . "|" . $email . "|" . $first_name . "|" . $last_name, true);

    if (empty($mc_list_name)) {//This level has no mailchimp list name specified for it
        return;
    }

    SwpmLog::log_simple_debug("Mailchimp integration - Doing list signup...", true);

    include_once('lib/SWPM_MCAPI.class.php');

    $swpm_mc_settings = get_option('swpm_mailchimp_settings');
    $api_key = $swpm_mc_settings['mc_api_key'];
    if (empty($api_key)) {
        SwpmLog::log_simple_debug("MailChimp API Key value is not saved in the settings. Go to MailChimp settings and enter the API Key.", false);
        return;
    }

    $api = new SWPM_MCAPI($api_key);

    $target_list_name = $mc_list_name;
    $list_filter = array();
    $list_filter['list_name'] = $target_list_name;
    $all_lists = $api->lists($list_filter);
    $lists_data = $all_lists['data'];
    $found_match = false;
    foreach ($lists_data as $list) {
        SwpmLog::log_simple_debug("Checking list name : " . $list['name'], true);
        if (strtolower($list['name']) == strtolower($target_list_name)) {
            $found_match = true;
            $list_id = $list['id'];
            SwpmLog::log_simple_debug("Found a match for the list name on MailChimp. List ID :" . $list_id, true);
        }
    }
    if (!$found_match) {
        SwpmLog::log_simple_debug("Could not find a list name in your MailChimp account that matches with the target list name: " . $target_list_name, false);
        return;
    }
    SwpmLog::log_simple_debug("List ID to subscribe to:" . $list_id, true);

    //Create the merge_vars data
    $merge_vars = array('FNAME' => $first_name, 'LNAME' => $last_name, 'INTERESTS' => '');
    //$signup_date_field_name = $swpm_mc_settings['mc_signup_date'];//get from settings if needed;
    //if (!empty($signup_date_field_name)) {//Add the signup date
    //    $todays_date = date("Y-m-d");
    //    $merge_vars[$signup_date_field_name] = $todays_date;
    //}
    //if (count($pieces) > 2) {//Add the interest groups data to the merge_vars
    //    $group_data = array(array('name' => $interest_group_name, 'groups' => $interest_groups));
    //    $merge_vars['GROUPINGS'] = $group_data;
    //}

    $retval = $api->listSubscribe($list_id, $email, $merge_vars);

    if ($api->errorCode) {
        SwpmLog::log_simple_debug("Unable to load listSubscribe()!", false);
        SwpmLog::log_simple_debug("\tCode=" . $api->errorCode, false);
        SwpmLog::log_simple_debug("\tMsg=" . $api->errorMessage, false);
    } else {
        SwpmLog::log_simple_debug("MailChimp Signup was successful.", true);
    }
}
