<?php
/*
Plugin Name: CAPTCHA In Thai
Plugin URI: http://www.captcha.in.th
Description: CAPTCHA in Thai เป็นการบริการฟรี CAPTCHA ที่เป็นภาษาไทย ในลักษณะของการแก้ไขคำที่มักเขียนผิด คำอ่าน และสุภาษิตต่างๆ เพื่อช่วยป้องกันเว็บไซด์ของท่านจากสแปม ท่านสามารถติดตั้งใช้ได้หลายส่วน ได้แก่ การเข้าสู่ระบบ, การลงทะเบียนและการแสดงความคิดเห็น นอกจากนี้การใช้ CAPTCHA in Thai เป็นการส่งเสริมให้ผู้ใช้งานสามารถใช้ภาษาไทยได้ถูกต้องอีกด้วย
Version: 1.1
Author: Nattapon and Thanate
Author URI: http://www.captcha.in.th
License: GPLv2 or later
*/

/*  Copyright 2013  Nattapon and Thanate  (email : nattapon_wora@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//add admin menu

require_once('menupage.php');
require_once('offline.php');

$capth_def_setting = array(
        'font_size' => 30,
        'width' => 250,
        'height' => 100,
        'font_color' => "#000000",
        'bg_color' => "#64dcdc",
    );

$captcha_host = gethostbyname("www.captcha.in.th");
add_action( 'admin_menu', 'add_menu' );

function add_menu()
{
    add_menu_page( 'CAPTCHA in Thai', 'CAPTCHA in Thai', 'manage_options', 'capthsetting', 'menu_page', plugins_url('captcha-in-thai/images/icon.png'));
    add_action( 'admin_init', 'setting' );
}

function setting()
{
    global $options;
    global $capth_def_setting;
    $option_defaults = array(
        'login_font_color' => $capth_def_setting['font_color'],
        'login_bg_color' => $capth_def_setting['bg_color'],
        'comment_font_color' => $capth_def_setting['font_color'],
        'comment_bg_color' => $capth_def_setting['bg_color'],
        'register_font_color' => $capth_def_setting['font_color'],
        'register_bg_color' => $capth_def_setting['bg_color'],
        'lostpassword_font_color' => $capth_def_setting['font_color'],
        'lostpassword_bg_color' => $capth_def_setting['bg_color'],
        
        'question_type1' => 'yes',
        'question_type2' => 'yes',
        'question_type3' => 'yes',
        'question_type4' => 'yes',
        
        'captcha_login' => 'yes',
        'captcha_comments' => 'yes',
        'captcha_register' => 'yes',
        'captcha_lostpassword' => 'yes',
        'hide_register_user' => 'yes',
        
		'distorted' => 'med',
		'noise' => 'med',
		
    );
    
    //delete_option( 'capth_options' );
    
    if( !get_option( 'capth_options' ) )
    {
        add_option( 'capth_options', $option_defaults, '', 'yes' );
    }

    $options = get_option( 'capth_options' );
    $options = array_merge( $option_defaults, $options );
	
	if($options != get_option( 'capth_options' ) ){
		delete_option( 'capth_options' );
		add_option( 'capth_options', $options, '', 'yes' );
	}
	
} // end function setting

//display captcha in login form
$options = get_option( 'capth_options' );

if( 'yes' == $options['captcha_login']){
    add_action( 'login_form', 'login' );
    add_filter( 'login_errors', 'login_post' );
    add_filter( 'login_redirect', 'login_check'); 
}

if( 'yes' == $options['captcha_comments'] ){
	add_action( 'comment_form_after_fields', 'comment', 1 );
	add_action( 'comment_form_logged_in_after', 'comment', 1 );
    //add_action( 'comment_form', 'comment' );
    add_filter( 'preprocess_comment', 'comment_post' );
}

if( 'yes' == $options['captcha_register'] ){
    add_action( 'register_form', 'register' );
    add_action( 'register_post', 'register_post', 10, 3 );
}

if( 'yes' == $options['captcha_lostpassword'] ){
    add_action( 'lostpassword_form', 'lostpassword' );
    add_action( 'lostpassword_post', 'lostpassword_post', 10, 3 );
}


//function for add settings menu
function menu_link($links, $file)
{
    $this_plugin = plugin_basename(__FILE__);

    if ( $file == $this_plugin){
        $settings_link = '<a href="admin.php?page=capthsetting">Settings</a>';
        array_unshift( $links, $settings_link );
    }
    return $links;
} // end function menu_link

function login(){
    if( session_id() == "" ){
        session_start();
    }
	
    if( ! $_SESSION["login_failed"] ){
        // don't do anyting
    }else{
    	global $captcha_host;
		if( isset( $_SESSION["login"] ) ){
            unset( $_SESSION["login"]);
        }
        
        if( isset( $_SESSION['error'] ) ) {
            echo "<br /><span style='color:red'>". $_SESSION['error'] ."</span><br />";
            unset( $_SESSION['error'] );
        }

    	if( 0 == check_server( $captcha_host ) ){
    		display_offline_mode( "login" );
    	}else{
	        display( "login" );
    	}
    }

    return true;
}

function register(){
	global $captcha_host;
	if( 0 == check_server( $captcha_host ) ){
		display_offline_mode( "register" );
	}else{
		display( "register" );
	}
    return true;
}

function lostpassword(){
	global $captcha_host;
	if( 0 == check_server( $captcha_host ) ){
		display_offline_mode( "lostpassword" );
	}else{
		display( "lostpassword" );
	}
    return true;
}

function comment(){
    global $options;
	global $captcha_host;

    if ( is_user_logged_in() && 'yes' == $options['hide_register_user'] ) {
        return true;
    }
	
	if( 0 == check_server( $captcha_host ) ){
		display_offline_mode( "comment" );
	}else{
    	display( "comment" );
	}
	
    return true;
}

function display( $part ){
    global $options;
    global $capth_def_setting;
    $url = "http://www.captcha.in.th/generate/question.php";
    $url .= "?font_size={$capth_def_setting['font_size']}";
    $url .= "&width={$capth_def_setting['width']}";
    $url .= "&height={$capth_def_setting['height']}";
    
    if( "login" == $part ){
        $url .= "&font_color=".substr($options['login_font_color'], 1);
        $url .= "&bg_color=".substr($options['login_bg_color'], 1);
    }else if( "register" == $part ){
        $url .= "&font_color=".substr($options['register_font_color'], 1);
        $url .= "&bg_color=".substr($options['register_bg_color'], 1);
    }else if( "comment" == $part ){
        $url .= "&font_color=".substr($options['comment_font_color'], 1);
        $url .= "&bg_color=".substr($options['comment_bg_color'], 1);
    }else if( "lostpassword" == $part ){
		$url .= "&font_color=".substr($options['lostpassword_font_color'], 1);
        $url .= "&bg_color=".substr($options['lostpassword_bg_color'], 1);
	}

    $url .= "&question_type1={$options['question_type1']}";
    $url .= "&question_type2={$options['question_type2']}";
    $url .= "&question_type3={$options['question_type3']}";
	
	$url .= "&noise={$options['noise']}";
	$url .= "&distorted={$options['distorted']}";
	
	    
	$url .= "&hostname=".$_SERVER['SERVER_NAME'];
    $url .= "&user_ip=".$_SERVER['REMOTE_ADDR'];

?>
<br />
<iframe id="capth_iframe" src="<?= $url ?>" style="border:none" width="<?= $capth_def_setting['width'] * 1.5 ?>" height="<?= $capth_def_setting['height'] * 2.0 ?>" scrolling="yes"><br />
    <textarea name="ques" rows="3" cols="40">
</iframe>
<input type="text" name="answer" id="answer"  />
<input type="hidden" name="code" id="code" />

<?php
    return true;
} // end function display

function login_post($errors) {
    $_SESSION["login_failed"] = true;
    // Delete errors, if they set
    if( isset( $_SESSION['error'] ) )
        unset( $_SESSION['error'] );

    // If captcha not complete, return error
    if ( isset( $_REQUEST['answer'] ) && "" ==  $_REQUEST['answer'] ) {
        return $errors.'<strong>ERROR</strong>: กรุณากรอก CAPTCHA';
    }
    
    global $options;
	global $captcha_host;
	if( 0 == check_server( $captcha_host ) ){
		if( ( 0 == strcmp( $_REQUEST['ans_num']  , $_REQUEST['answer']) ) || ( 0 == strcmp( tran_num($_REQUEST['ans_num'])  , $_REQUEST['answer'] ) ) ){
    		        	
    	}
    	else {
        	return $errors.'<strong>ERROR</strong>: คุณกรอก CAPTCHA ไม่ถูกต้อง';
    	}
	}else{
    	$str = request_str( $_SERVER['SERVER_NAME'], $_SERVER['REMOTE_ADDR'], $_REQUEST['answer'] );
    	$res = check_ans( 'www.captcha.in.th' , '/check/index.php' , $str );    

    	if ( 0 == strcmp($res[0], 'true') ) {
        	// captcha was matched
    	} else {
        	return $errors."<strong>ERROR</strong>: คุณกรอก CAPTCHA ไม่ถูกต้อง<br />คำถาม : {$res[1]} <br /> เฉลย : {$res[2]}";
    	}
	}
  return($errors);
} // end function cptch_login_post

function login_check($url) {
    $_SESSION["login_failed"] = true;
    if( session_id() == "" ){
        session_start();
    }

    if ( isset( $_REQUEST['answer'] ) ){
        global $options;
		global $captcha_host;
		if( 0 == check_server( $captcha_host ) ){
			if( ( 0 == strcmp( $_REQUEST['ans_num']  , $_REQUEST['answer']) ) || ( 0 == strcmp( tran_num($_REQUEST['ans_num'])  , $_REQUEST['answer'] ) ) ){
            	$_SESSION['login'] = 'true';
            	unset( $_SESSION["login_failed"] );
            	return $url;
	    	}
	    	else {
	        	$_SESSION['error'] = 'คุณกรอก CAPTCHA ไม่ถูกต้อง';
	            wp_clear_auth_cookie();
	            return $_SERVER["REQUEST_URI"];
	    	}
		}else{
        	$str = request_str( $_SERVER['SERVER_NAME'], $_SERVER['REMOTE_ADDR'], $_REQUEST['answer'] );
        	$res = check_ans( 'www.captcha.in.th' , '/check/index.php' , $str );

        	if( 0 == strcmp($res[0], 'true') ){
           	 	$_SESSION['login'] = 'true';
            	unset( $_SESSION["login_failed"] );
            	return $url;
        	}
	        else {
	            $_SESSION['error'] = "คุณกรอก CAPTCHA ไม่ถูกต้อง <br />คำถาม : {$res[1]} <br /> เฉลย : {$res[2]}";
	            wp_clear_auth_cookie();
	            return $_SERVER["REQUEST_URI"];
        	}
		}
		
    }else{
        return $url;
    }
         
} // end function cptch_login_post

function register_post($login,$email,$errors) {

    // If captcha is blank - add error
    if ( isset( $_REQUEST['answer'] ) && "" ==  $_REQUEST['answer'] ) {
        $errors->add('captcha_blank', 'กรุณากรอก CAPTCHA');
        return $errors;
    }
    
    if ( isset( $_REQUEST['answer'] ) ){
        global $options;
		global $captcha_host;
		if( 0 == check_server( $captcha_host ) ){
			if( ( 0 == strcmp( $_REQUEST['ans_num']  , $_REQUEST['answer']) ) || ( 0 == strcmp( tran_num($_REQUEST['ans_num'])  , $_REQUEST['answer'] ) ) ){
	    			        
	    	}
	    	else {
	        	$errors->add( 'captcha_wrong' , 'คุณกรอก CAPTCHA ไม่ถูกต้อง' );
	    	}
		}else{
	        $str = request_str( $_SERVER['SERVER_NAME'], $_SERVER['REMOTE_ADDR'], $_REQUEST['answer'] );
	        $res = check_ans( 'www.captcha.in.th' , '/check/index.php' , $str );
	        if( 0 == strcmp($res[0], 'true') ){
	            
	        }
	        else {
	            $errors->add( 'captcha_wrong' , "คุณกรอก CAPTCHA ไม่ถูกต้อง<br />คำถาม : {$res[1]} <br /> เฉลย : {$res[2]}" );
	        }
		}
    }
    return($errors);
} // end function cptch_register_post

function lostpassword_post() {
	global $captcha_host;

	if ( isset( $_REQUEST['answer'] ) && "" ==  $_REQUEST['answer'] ) {
        wp_die( 'กรุณากรอก CAPTCHA.' );
    }
	
	if( 0 == check_server( $captcha_host ) ){
		if( ( 0 == strcmp( $_REQUEST['ans_num']  , $_REQUEST['answer']) ) || ( 0 == strcmp( tran_num($_REQUEST['ans_num'])  , $_REQUEST['answer'] ) ) ){
    		return;        
    	}
    	else {
        	wp_die( 'คุณกรอก CAPTCHA ไม่ถูกต้อง');
    	}
	}else{
        $str = request_str( $_SERVER['SERVER_NAME'], $_SERVER['REMOTE_ADDR'], $_REQUEST['answer'] );
        $res = check_ans( 'www.captcha.in.th' , '/check/index.php' , $str );
        if( 0 == strcmp($res[0], 'true') ){
            return;
        }
        else {
            wp_die( "คุณกรอก CAPTCHA ไม่ถูกต้อง<br />คำถาม : {$res[1]} <br /> เฉลย : {$res[2]}");
        }
	}
} // function cptch_lostpassword_post

function comment_post($comment) { 
    global $options;
	global $captcha_host;

    if ( is_user_logged_in() && 'yes' == $options['hide_register_user'] ) {
        return $comment;
    }
    
    // If captcha is empty
    if ( isset( $_REQUEST['answer'] ) && "" ==  $_REQUEST['answer'] )
        wp_die( 'กรุณากรอก CAPTCHA.' );

	if( 0 == check_server( $captcha_host ) ){
		if( ( 0 == strcmp( $_REQUEST['ans_num']  , $_REQUEST['answer']) ) || ( 0 == strcmp( tran_num($_REQUEST['ans_num'])  , $_REQUEST['answer'] ) ) ){
	        return $comment;
	    }
	    else {
	        wp_die( 'คุณกรอก CAPTCHA ไม่ถูกต้อง');
	    }
	}else{
	    $str = request_str( $_SERVER['SERVER_NAME'], $_SERVER['REMOTE_ADDR'], $_REQUEST['answer'] );
	    $res = check_ans( 'www.captcha.in.th' , '/check/index.php' , $str );
	    if( 0 == strcmp($res[0], 'true') ){
	        return $comment;
	    }
	    else {
	        wp_die( "คุณกรอก CAPTCHA ไม่ถูกต้อง<br />คำถาม : {$res[1]} <br /> เฉลย : {$res[2]}" );
	    }
	}
     
} // end function cptch_comment_post

function check_ans( $host, $path, $data )
{
    $port = 80;
    $http_request  = "POST $path HTTP/1.1\r\n";
    $http_request .= "Host: $host\r\n";
    $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
    $http_request .= "Content-Length: " . strlen($data) . "\r\n";
    $http_request .= "\r\n";
    $http_request .= $data;
    
    $response = '';
    if( false == ( $fs = @fsockopen( $host, $port, $errno, $errstr, 2) ) ) {
        die ('Could not open socket');
    }

    fwrite($fs, $http_request);

    while ( !feof($fs) )
            $response .= fgets($fs, 1160); // One TCP-IP packet
    fclose($fs);
    $response = explode("\r\n\r\n", $response, 2);
	$response = explode("\r\n", $response[1], 3);
    return $response;
}

function request_str ( $hostname, $ip, $answer )
{
    $str = "hostname=".urlencode( stripslashes($hostname) );
    $str .= "&ip=".urlencode( stripslashes($ip) );
    $str .= "&answer=".urlencode( stripslashes($answer) );
    return $str;
    
}

function check_server( $host ){
	$port = 80;
    if( false == ( $fs = @fsockopen( $host, $port, $errno, $errstr, 2) ) ) {
        return 0;
    }else{
    	return 1;
    }
}

function tran_num( $old ){
	$num = array(); 
	$num[0] = "๐";
	$num[1] = "๑";
	$num[2] = "๒";
	$num[3] = "๓";
	$num[4] = "๔";
	$num[5] = "๕";
	$num[6] = "๖";
	$num[7] = "๗";
	$num[8] = "๘";
	$num[9] = "๙";
	
	$new = "";
	if ( $old >= 100 ){
		$new .= $num[ $old / 100 ];
		$old %= 100;
	}
	
	if ( $old >= 10 ){
		$new .= $num[ $old / 10 ];
		$old %= 10;
	}
	
	$new .= $num[ $old ];
	return $new;
	
}

//สร้าง link ไปหน้า setting
add_filter( 'plugin_action_links', 'menu_link', 10, 2 );
?>