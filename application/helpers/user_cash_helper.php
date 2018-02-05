<?
/**
 @file		user_cash_helper.php
 @desc		사용자 포인트 관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function user_cash_add($user_idx, $config_idx, $adjust_cash = 0, $derived = 0){
	if(empty($user_idx) || empty($config_idx)) return false;

	$CI =& get_instance();

	$CI->load->model(USER_MODEL_DIR.'Cash_model', '', true);

	//포인트 설정값 가져옴
	$cash_config = $CI->Cash_model->get_config_entrie($config_idx);
	if(empty($cash_config[0]->idx)){
		return;//설정값 없음
	}

	//설정에 제한값이 있을경우
	if($cash_config[0]->limit_per_day > 0){
		$history_count = $CI->Cash_model->get_history_count($config_idx, $user_idx, date('Y-m-d'));
		//갯수 제한에 걸릴 경우
		if($history_count[0]->cnt >= $cash_config[0]->limit_per_day){
			return;//갯수제한
		}
	}

	//회원 포인트&등급 가져옴
	$CI->load->model(USER_MODEL_DIR.'User_model', '', true);
	$user = $CI->User_model->get_entrie($user_idx);
	if(empty($user[0]->idx)){
		return;//회원없음
	}

	$adjust_cash = (empty($adjust_cash)) ? $cash_config[0]->basic_adjust : $adjust_cash;
	$before_cash = $user[0]->cash;
	$after_cash = $before_cash + $adjust_cash;

	//포인트 내역 저장
	$param = array(
		'adjust_cash' => $adjust_cash,
		'before_cash' => $before_cash,
		'after_cash' => $after_cash,
		'row_idx' => $derived,
		'config_idx' => $config_idx,
		'user_idx' => $user_idx
	);
	$history_idx = $CI->Cash_model->insert_history_entry($param);
	if(empty($history_idx)){
		return; //포인트 내역 저장 실패
	}




	$rs = $CI->User_model->update_cash(array('cash'=>$after_cash, 'idx'=>$user_idx));
	if($adjust_cash > 0){ //합계 조절
		//$CI->User_model->update_cash_t(array('cash'=>$adjust_cash, 'idx'=>$user_idx));
	}
	
	if(empty($rs)){
		return; //포인트 지급 실패
	}
	
}
?>