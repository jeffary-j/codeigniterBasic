<?
/**
 @file		permission_helper.php
 @desc		권한체크
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 @function	check_user_type
 @desc		로그인 폼
 @param		seed : 0=>로그인 상태인지 체크,
*/


/*
function check_user_type($seed = 0) {
	$CI =& get_instance();
	$CI->load->library('session');
	$logged_in = $CI->session->userdata('logged_in');

	if($seed == 0){
		if(!$logged_in){
			$CI->load->helper('url');
			redirect($CI->config->item('base_url').'auth', 'redirect');
		}
	}else{
		if($logged_in){
			$CI->load->helper('url');
			redirect($CI->config->item('base_url').'faq', 'redirect');
		}
	}
}
*/

function check_user_type($type = USER_TYPE_GUEST) {
	$CI =& get_instance();
	$CI->load->library('session');
	$user_type = $CI->session->userdata('user_type');
	$user_type = (empty($user_type)) ? USER_TYPE_GUEST : $user_type;
	

	if($type == 0) {
		if($user_type > $type){
			$CI->load->helper('alert');
			alert('해당 페이지 접근 권한이 없습니다.', '/');
		}
	} else {
		if($user_type == USER_TYPE_GUEST){
			$CI->load->helper('url');
			redirect(base_url('auth?ERU='.ENCODED_REQUEST_URI));
		}
		if($type & $user_type){
			//echo true;
		} else {
			//echo false;
			$user_types = $CI->config->item('user_types');
			
			$allow_types = array();
			
			if($type & USER_TYPE_GUEST) array_push($allow_types, $user_types[USER_TYPE_GUEST]);
			if($type & USER_TYPE_MEMBER) array_push($allow_types, $user_types[USER_TYPE_MEMBER]);
			
			if($type & USER_TYPE_ARTIST) array_push($allow_types, $user_types[USER_TYPE_ARTIST]);
			if($type & USER_TYPE_ADMIN) array_push($allow_types, $user_types[USER_TYPE_ADMIN]);
			
			$CI->load->helper('alert');
			alert(implode(",", $allow_types).' 만 접근가능합니다.', '/');
		}
	}
}

/*
$config['user_types'] = array(
	USER_TYPE_GUEST 	=> '손님',
	USER_TYPE_MEMBER 	=> '일반회원',
	USER_TYPE_SPECIALIST 	=> '업소회원',
	USER_TYPE_ADMIN 	=> '운영자'
);
*/

function check_user_grade($grade = 0) {
	$CI =& get_instance();
	$CI->load->library('session');
	$user_grade = $CI->session->userdata('user_grade');
	
	$user_grades = $CI->config->item('user_grades');

	if($user_grade < $grade) {
		$CI->load->helper('alert');
		
		if(empty($user_grades[$grade])){
			$alert_msg = '해당 페이지 접근 권한이 없습니다.';
		} else {
			$alert_msg = $user_grades[$grade][0].' 계급 이상 회원만 접근가능합니다.';
		}
		alert($alert_msg, '/');
	} else {
		//echo true;
	}
}
?>