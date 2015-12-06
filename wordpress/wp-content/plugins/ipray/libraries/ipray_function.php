<?php // Don't load directly
if ( ! defined('ABSPATH') ) { die(); } 
/* hidden inputs display */
function IpraypopulateHiddenFormFields ($fields = array())
{
	if(!empty($fields))
	{
		 foreach($fields as $name =>$value)
		 {
			echo '<input type="hidden" name="'.$name.'" value="'.$value.'">'; 
		 }
	}
}
/* generate and retrun ajax utility url */
function getIprayAjaxUrl ()
{
	return IPRAY__PLUGIN_URL.IPRAY__LIB_PATH.'/ipray_utility.php';
}
/**
 * adds a box to the main column on the post and page edit screens.
 */
function ipray_format_meta_box() {
  global $post;
  $ipray_meta_box = ipray_global::getMetaBox();
  echo '<input type="hidden" name="plib_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
  echo '<table class="form-table">';
  foreach ($ipray_meta_box['fields'] as $field) {
      $meta = get_post_meta($post->ID, $field['id'], true);
      echo '<tr>'.
              '<th style="width:20%"><label for="'. $field['id'] .'">'. $field['name']. '</label></th>'.
              '<td>';
      switch ($field['type']) {
          case 'text':
              echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />'. '<br />'. $field['desc'];
              break;
          case 'textarea':
              echo '<textarea name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" style="width:97%">'. ($meta ? $meta : $field['default']) . '</textarea>'. '<br />'. $field['desc'];
              break;
          case 'select':
              echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';
              foreach ($field['options'] as $key => $option) {
                  echo '<option value="'.$key.'" '. ( $meta == $key ? ' selected="selected"' : '' ) . '>'. $option . '</option>';
              }
              echo '</select>';
              break;
          case 'radio':
              foreach ($field['options'] as $option) {
                  echo '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . ( $meta == $option['value'] ? ' checked="checked"' : '' ) . ' />' . $option['name'];
              }
              break;
          case 'checkbox':
              echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '"' . ( $meta ? ' checked="checked"' : '' ) . ' />';
              break;
			  case 'hidden':
              echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" value="'. ($meta ? $meta : $field['default']) .'"/>';
			  
              break;
      }
      echo     '<td>'.'</tr>';
  }
  echo '</table>';
}
/* save meta box data */
function ipray_meta_data_save($post_id) {
    global $post;
	$ipray_meta_box = ipray_global::getMetaBox();
	if(!isset($_POST) && empty($_POST)) return ;
    #Verify nonce
    if (isset($_POST['plib_meta_box_nonce']) && !wp_verify_nonce($_POST['plib_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    #Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    #Check permissions
    if (isset($_POST['post_type']) && 'prayer' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($ipray_meta_box['fields'] as $field) {
		
        $old = get_post_meta($post_id, $field['id'], true);
		if(isset($_POST[$field['id']]))
		{
			$new = $_POST[$field['id']];
			if ($new !== false && $new != $old) 
			{
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) 
			{
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
    }
}
/* get plugin listing page url */
function iprayPageUrl($link = null)
{
			$url  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https':'http';
			$url .= '//'.$_SERVER['HTTP_HOST'];
			if($url !== null)
			{
				$url.= base64_decode($link);
			}
			return $url;

}
/* send mail to prayer /subscriber
   @params $mail_type , $mail_type
 */
function sendToMail($mail_type = null,$prayer_data = null,$url = null)
{
	switch($mail_type)
	{
		case 'add_new_prayer' :
		    $body = $prayer_data['name']. PHP_EOL . PHP_EOL;
			$subject = __('Add new prayer','ipray-plugin');
			$content = $prayer_data['message'] . PHP_EOL . PHP_EOL;
			$content = wordwrap($content, 70 );
			$msg = '<div>';
			$msg .= $content;
			if($url!==null)
			{
				$msg .='</br><a href="'.$url.' target="_blank"">'.__('Click here','ipray-plugin').'</a>';
			}
			$msg .= '</div>';
			$headers = "From:".$prayer_data['reply_mail'] . PHP_EOL;
			$headers .= "Reply-To:".$prayer_data['reply_mail']. PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
			@mail($prayer_data['mail_to'],$subject, $msg, $headers); 
		break;
		case 'prayed_to_someone':
			$subject = __('Someone prayer for you.','ipray-plugin');
			$content = $prayer_data['message'] . PHP_EOL . PHP_EOL;
			$content = wordwrap($content, 70 );
			$msg = '<div>';
			$msg .= $content;
			if($url!==null)
			{
				$msg .='</br><a href="'.$url.' target="_blank"">'.__('Click here','ipray-plugin').'</a>';
			}
			$msg .= '</div>';
			$headers = "From:".$prayer_data['mail_to'] . PHP_EOL;
			$headers .= "Reply-To:".$prayer_data['mail_to']. PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
			@mail($prayer_data['mail_to'],$subject, $msg, $headers); 
		break;
	}
	 
}
