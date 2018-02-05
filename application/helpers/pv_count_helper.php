<?
/**
 @file		encrypt_helper.php
 @desc		암호화 관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function pv_check(){
	$CI =& get_instance();
	if(empty($CI->uri->segments[1]) || empty($CI->uri->segments[3])){
		return false;
	}
	$pv_key = $CI->uri->segments[1].'_'.$CI->uri->segments[3];
	$CI->load->library('session');
	$user_data = $CI->session->userdata($pv_key);

	if(empty($user_data)){
		$session_items = array();
		$session_items[$pv_key] = 1;
		$CI->session->set_userdata($session_items);
		return true;
	} else {
		return false;
	}
}
?>