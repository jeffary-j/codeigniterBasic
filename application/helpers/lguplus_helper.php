<?
/**
 @file		lguplus_helper.php
 @desc		SMS 관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function send_sms($TR_PHONE, $TR_CALLBACK, $TR_MSG){
	if(empty($TR_PHONE) || empty($TR_CALLBACK) || empty($TR_MSG)) return false;
	$CI =& get_instance();
	$CI->load->model(USER_MODEL_DIR.'Lguplus_model', '', true);
	$param = array(
		'TR_SENDDATE' => date('Y-m-d H:i:s'),
		'TR_PHONE' => $TR_PHONE,
		'TR_CALLBACK' => $TR_CALLBACK,
		'TR_MSG' => $TR_MSG
	);
	$tran_idx = $CI->Lguplus_model->insert_entry($param);
	if(empty($tran_idx)){
		return false;
	}
	if(empty($tran_idx)){
		return true;
	}
}
?>