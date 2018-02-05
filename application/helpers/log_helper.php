<?
/**
 @file		log_helper.php
 @desc		로고관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 @function	admin_login_log
 @desc
 @param
*/
function admin_login_log() {
	$str_log = date("Y-m-d H:i:s").' '.$_SERVER['REMOTE_ADDR'].'';
     for($i=0,$icnt=func_num_args(); $i<$icnt; $i++) {
         $str_log .= '|'.func_get_arg($i);
     }
	$fp = @fopen(LOG_FILE_PATH.'login_admin.log', 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

/**
 @function	user_login_log
 @desc
 @param
*/
function user_login_log() {
	$CI =& get_instance();
	$CI->load->helper('file');

	$save_file_path = LOG_FILE_PATH.'login_user_'.date("Y_m_d").'.log';
	check_dir($save_file_path);

	$str_log = date("Y-m-d H:i:s").' | '.$_SERVER['REMOTE_ADDR'];
	
	if(isset($_SERVER['HTTP_REFERER'])) $str_log .= ' | '.$_SERVER['HTTP_REFERER'];
    
    for($i=0,$icnt=func_num_args(); $i<$icnt; $i++) {
         $str_log .= ' | '.func_get_arg($i);
    }
    
	$fp = fopen($save_file_path, 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

/**
 @function	guest_login_log
 @desc
 @param
*/
function guest_login_log() {
	
	$save_file_path = LOG_FILE_PATH.'join_guest.log';
	
	$str_log = date("Y-m-d H:i:s").' - '.$_SERVER['REMOTE_ADDR'];
	
	if(isset($_SERVER['HTTP_REFERER'])) $str_log .= ' - '.$_SERVER['HTTP_REFERER'];
    
    for($i=0,$icnt=func_num_args(); $i<$icnt; $i++) {
         $str_log .= '|'.func_get_arg($i);
    }
    
    $fp = fopen($save_file_path, 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

/**
 @function	payment_log
 @desc
 @param
*/
function payment_log() {
	$str_log = date("Y-m-d H:i:s").' '.$_SERVER['REMOTE_ADDR'].'';
     for($i=0,$icnt=func_num_args(); $i<$icnt; $i++) {
         $str_log .= '|'.func_get_arg($i);
     }
	$fp = fopen(LOG_FILE_PATH.'payment.log', 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

/**
 @function	mnbank_feedback_log
 @desc
 @param
*/
function mnbank_feedback_log() {
	$str_log = date("Y-m-d H:i:s").' '.$_SERVER['REMOTE_ADDR'].'';
     for($i=0,$icnt=func_num_args(); $i<$icnt; $i++) {
         $str_log .= '|'.func_get_arg($i);
     }
	$fp = fopen(LOG_FILE_PATH.'mnbank_feedback.log', 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

/**
 @function	paypal_log
 @desc
 @param
*/
function paypal_log($seed) {
	$str_log = date("Y-m-d H:i:s").' '.$_SERVER['REMOTE_ADDR'].'';
    $str_log .= ' '.$seed;
	$fp = fopen(LOG_FILE_PATH.'paypal.log', 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

/**
 @function	paypal_error_log
 @desc
 @param
*/
function paypal_ipn_log($seed) {
	$str_log = date("Y-m-d H:i:s").' '.$_SERVER['REMOTE_ADDR'].'';
    $str_log .= ' '.$seed;
	$fp = fopen(LOG_FILE_PATH.'paypal_ipn.log', 'a');
	@fwrite($fp, $str_log . "\r\n");
	@fclose($fp);
}

?>