<?php 
require_once '../../../../wp-load.php';
require_once 'ipray_function.php';
class ipray_utility
{
	public $dbobj;
	public $start;
	public function __construct() {
       global $wpdb;
	   $this->dbObj = $wpdb;
    }
	public function getResponse($data = array())
	{
		switch($this->action)
		{
			case 'ipray-list':
			  return $this->prayerList($data);
			break;
			case 'prayer_submit':
			  return $this->addPrayer();
			break;
			case 'newsletter_subscribe':
			  return $this->prayerSubscribe();
			break;
			case 'iprayed':
			  return $this->iPrayed();
			break;
			default :
			  return $this->prayerList($data);
			break;
		}	
	}
	/* add new prayer*/
	public function addPrayer()
	{
		$post_status = '';
		$result = array('submit' => 0);
		$modification = get_option('prayer_modification');
		/* check email */
		if(!isset($_REQUEST['email']) && empty($_REQUEST['email']) )
		{
			return $result;
		}
		if($modification != NULL && $modification == 1)
		{
			 $post_status = 'pending';
		}
		else 
		{
			$post_status = 'publish';
		}
		/* post prayer data */
		$user_ID = get_current_user_id();
		$new_post = array(
		'post_title' => sanitize_text_field($_REQUEST['name']),
		'post_content' => sanitize_text_field($_REQUEST['prayer']),
		'post_status' => $post_status,
		//'post_date' => date('Y-m-d H:i:s'),
		'post_author' => $user_ID,
		'post_type' => 'prayer',
      );
      $post_id = wp_insert_post($new_post);
	   #insert post meta
	  if ($post_id) {
				add_post_meta($post_id, 'ipray_owner_name', sanitize_text_field($_REQUEST['name']));
				add_post_meta($post_id, 'ipray_owner_email', sanitize_text_field($_REQUEST['email']));
				add_post_meta($post_id, 'ipray_owner_phone', sanitize_text_field($_REQUEST['phone']));
				add_post_meta($post_id, 'ipray_prayer_notifyme', isset($_REQUEST['notifyme'])?1:0);
				add_post_meta($post_id, 'ipray_desired_share_option', sanitize_text_field($_REQUEST['desired_share_option']));
				/* send alert new prayer add */
				if($_REQUEST['desired_share_option'] != 2)
				{
					$share_option = $_REQUEST['desired_share_option'];
					$name = ($share_option == 0)?$_REQUEST['name']:__('Anonymous','ipray-plugin');
					$prayer_data['name'] = $name;
					$prayer_data['message'] = $_REQUEST['prayer'];
					$prayer_data['reply_mail'] = $_REQUEST['email'];
					/* fetch all subscribers */
					$email_alerts = $this->subscriberMail();
					if(!empty($email_alerts))
					{
						foreach($email_alerts  as $mail_to)
						{
							$prayer_data['mail_to'] = $mail_to;
							$sendurl                = iprayPageUrl($_REQUEST['requesturi']);
							sendToMail('add_new_prayer',$prayer_data,$sendurl);
						}
					}
				}
				$result['submit'] = 1;
				return $result;
       }
	   return $result;
	}
	/* list all prayers */
	public function prayerList($option)
	{
		global $wp_query; 
		$data = array();
        query_posts( 
		       array(
			       'post_type'          =>'prayer',
				   'meta_query'         => array(
				                                array(
												    'relation' => 'AND',
				                                            array(
															   'key' => 'ipray_desired_share_option',
															    'value' => 2,
																'compare' => '!='
																)
														)
				                                 ),
				   'orderby'            => 'date',
				   'order'              => 'DESC',
				   'offset'             =>$_REQUEST['start'],
				   'posts_per_page'     =>$_REQUEST['per_page']
				   )
		);		
		if(isset($option['count']))
		{
            return $wp_query->found_posts;
			//return $GLOBALS['wp_query']->request;
		}
		if (have_posts())
		  {
			$i=0;
            while (have_posts()){
				the_post();
				$share_option = get_post_meta(get_the_ID(),'ipray_desired_share_option',true);

					$data[$i]['ID'] = get_the_ID();
					$name = '';
					if($share_option == 1)
					{
						$name = __('Anonymous','ipray-plugin');
					}
					else
					{
						$name = get_post_meta(get_the_ID(),'ipray_owner_name',true);
					}
					$data[$i]['name'] = $name;
					$data[$i]['is_pray_allow'] = $this->isPrayeredAllow(get_the_ID());
					$data[$i]['prayer'] = get_the_content();
					$data[$i]['date_time'] = get_the_time('F d, Y',get_the_ID());
					$data[$i]['class'] = ($i%2==0)?'even':'odd';
					$prayer_count = $this->prayerCount(get_the_ID());
		            $time_srting = ($prayer_count >1)?'times':'time';
					$data[$i]['prayer_count'] = $this->prayerCount(get_the_ID());
					$count_msg = sprintf(__('Prayed for %d %s','ipray-plugin'),$prayer_count,$time_srting);
					$data[$i]['prayer_count_msg'] = $count_msg;
					$i++;
			}
		  }
		  return $data;
	}
	/* subscribe prayer */
	public function prayerSubscribe()
	{
		 $table_name = $this->dbObj->prefix.'prayer_newsletter';
		 $result = array('submit' => 0);
		 if(!isset($_REQUEST['email']) && empty($_REQUEST['email']) )
		 {
			return $result;
		 }
		 if($this->checkmail(trim($_REQUEST['email'])))
		 {
			  $result['submit'] = 2;
			  $result['msg'] = __('This email address already exists!','ipray-plugin');
			  return $result;
		 }
		 
		  $email       = trim($_REQUEST['email']);
		  $browser     = $_SERVER['HTTP_USER_AGENT'];
		  $ip          = $_SERVER['REMOTE_ADDR'];
		  $created     = date('Y-m-d H:i:s');
						
	  $sql ="INSERT INTO $table_name (id,email, browser,ip,created) VALUES ('','$email','$browser','$ip','$created')" ;
      $response = $this->dbObj->query($sql);
	  if($response)
	  {
		  $result['msg'] = __('You have been successfully subscribed!','ipray-plugin');
		  $result['submit'] = 1;
	  }
	  return $result;
	}
	/* is prayed allowed  */
	public function isPrayeredAllow($prayer_id)
	{
        $table_name = $this->dbObj->prefix.'prayer_prayed';
		if (!isset($_SESSION))
		{ 
		   session_start();
		}
		
		$session_id = session_id();
		$prayer_ip = $_SERVER['REMOTE_ADDR'];
		
        $sql ="SELECT id FROM $table_name WHERE prayer_id =$prayer_id AND prayer_session ='$session_id' AND prayer_ip = '$prayer_ip'" ;
        $response = $this->dbObj->get_row($sql,OBJECT);
		if($response == null)
		{
		   return 1; 
		}
		return 0;
	}
	/* check mail is alreay exist or not */
	private function checkmail($email)
	{
		$table_name = $this->dbObj->prefix.'prayer_newsletter';
        $sql ="SELECT email FROM $table_name WHERE email = '$email'" ;
        $response = $this->dbObj->get_row($sql,OBJECT);
		
		if($response !== NULL)
		{
		   return true; 
		}
		
		return false;
	}
	
	/* fecth all active prayer subscriber user 
	   return all subscriber emails
	*/
	
	private function subscriberMail()
	{
		$data = array();
		$table_name = $this->dbObj->prefix.'prayer_newsletter';
        $sql ="SELECT email FROM $table_name WHERE status = 1" ;
        $all_mail = $this->dbObj->get_results($sql,OBJECT);
		if($all_mail)
		{
			$i = 0;
			foreach ($all_mail as $data_mail ) 
			{
				$data[$i] = $data_mail->email;
				$i++;
			}
		}
		return $data;
	}

	/* prayer count */
	private function prayerCount($prayer_id)
	{
		$table_name = $this->dbObj->prefix.'prayer_prayed';
        $sql ="SELECT COUNT(prayer_id) as total_prayer FROM $table_name WHERE prayer_id = $prayer_id" ;
        $response = $this->dbObj->get_row($sql,OBJECT);
		return $response->total_prayer; 
	}	
	/* any person prayer for The prayer owner */
	public function iPrayed()
	{
		$data = array(); 
		$data['prayer_count'] = 0;
		if(!isset($_REQUEST['prayer_id']))
		{
			return $data;
		}
		if($this->isPrayeredAllow($_REQUEST['prayer_id']))
		{
			if (!isset($_SESSION))
			{ 
			   session_start();
			}
		  $table_name      = $this->dbObj->prefix.'prayer_prayed';
		  $prayer_id       = $_REQUEST['prayer_id'];
		  $prayer_browser  = $_SERVER['HTTP_USER_AGENT'];
		  $prayer_ip       = $_SERVER['REMOTE_ADDR'];
		  $prayed_created  = date('Y-m-d H:i:s');
		  $prayer_session  = session_id();
		  
		   $sql  ="INSERT INTO $table_name(id,prayer_id,prayer_session,prayer_browser, ";
		   $sql .="prayer_ip,prayed_created) VALUES ";
		   $sql .="('',$prayer_id,'$prayer_session','$prayer_browser','$prayer_ip','$prayed_created')" ;
		   $this->dbObj->query($sql);
		   /* iprayed submit */
		   $data['prayer_count'] = $this->prayerCount($prayer_id);
		   $time_srting = ($data['prayer_count']>1)?'times':'time';
		   $data['prayer_count_msg'] = sprintf(__('Prayed for %d %s','ipray-plugin'),$data['prayer_count'],$time_srting);
				/* inform someone prayer */
				$notifyme = get_post_meta($prayer_id,'ipray_prayer_notifyme',true);
				$prayer_owner_email = get_post_meta($prayer_id,'ipray_owner_email',true);
				if($notifyme != NULL && !empty($notifyme) && $notifyme == 1)
				{
					$content_post = get_post($prayer_id);
					$content = $content_post->post_content;
					$prayer_data['mail_to'] = $prayer_owner_email;
					$prayer_data['message'] = $content;
					$sendurl                = iprayPageUrl($_REQUEST['requesturi']);
					sendToMail('prayed_to_someone',$prayer_data,$sendurl );
				}	
		}
        return $data;
	}
	public function isAjax()
	{
		/* AJAX check  */
		 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		 {
			 return true;
		 }
		 return false;
	}
	/* clear all memories */
	public function __destruct() {
        unset($this->dbObj);
    }
}
/* perform ajax activity */
$ipray_utility = new ipray_utility();
if(isset($_REQUEST['action']) && $ipray_utility->isAjax())
{
	$data = array();
	$ipray_utility->action = trim($_REQUEST['action']);
	/* prayer list */
	if($_REQUEST['action'] == 'ipray-list')
	{
		$res_count = $ipray_utility->getResponse(array('count'=>true));
		$ipray_data = $ipray_utility->getResponse();
		$data['res_count'] = $res_count;
		$data['display_results'] = $ipray_data;
		$data['setting']['prayer_text'] = __('I prayed for this','ipray-plugin');
		$data['setting']['recieve_text'] = __('Posted:','ipray-plugin');
		$data['per_page'] = trim($_REQUEST['per_page']);
		header('Content-Type: application/json');
		echo json_encode($data);;
	    die;
	}
	/* another actions */
	if($_REQUEST['action'] == 'prayer_submit' ||
	 $_REQUEST['action'] == 'newsletter_subscribe' ||
	 $_REQUEST['action'] == 'iprayed')
	{
	    header('Content-Type: application/json');
		echo json_encode($ipray_utility->getResponse());
		die;
	}
}
die();