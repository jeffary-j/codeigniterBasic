<?
/**
 @file		user_point_helper.php
 @desc		사용자 포인트 관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function user_point_add($user_idx, $config_idx, $adjust_point = 0, $derived = 0){
	if(empty($user_idx) || empty($config_idx)) return false;

	$CI =& get_instance();

	$CI->load->model(USER_MODEL_DIR.'Point_model', '', true);

	//포인트 설정값 가져옴
	$point_config = $CI->Point_model->get_config_entrie($config_idx);
	if(empty($point_config[0]->idx)){
		return;//설정값 없음
	}

	//설정에 제한값이 있을경우
	if($point_config[0]->limit_per_day > 0){
		$history_count = $CI->Point_model->get_history_count($config_idx, $user_idx, date('Y-m-d'));
		//갯수 제한에 걸릴 경우
		if($history_count[0]->cnt >= $point_config[0]->limit_per_day){
			return;//갯수제한
		}
	}

	//회원 포인트&등급 가져옴
	$CI->load->model(USER_MODEL_DIR.'User_model', '', true);
	$user = $CI->User_model->get_entrie($user_idx);
	if(empty($user[0]->idx)){
		return;//회원없음
	}

	$adjust_point = (empty($adjust_point)) ? $point_config[0]->basic_adjust : $adjust_point;
	$before_point = $user[0]->point;
	$after_point = $before_point + $adjust_point;

	//포인트 내역 저장
	$param = array(
		'adjust_point' => $adjust_point,
		'before_point' => $before_point,
		'after_point' => $after_point,
		'row_idx' => $derived,
		'config_idx' => $config_idx,
		'user_idx' => $user_idx
	);
	$history_idx = $CI->Point_model->insert_history_entry($param);
	if(empty($history_idx)){
		return; //포인트 내역 저장 실패
	}




	$rs = $CI->User_model->update_point(array('point'=>$after_point, 'idx'=>$user_idx));
	if($adjust_point > 0){ //합계 조절
		$CI->User_model->update_point_t(array('point'=>$adjust_point, 'idx'=>$user_idx));
	}
	
	if(empty($rs)){
		return; //포인트 지급 실패
	}
	
	if($user[0]->grade < MAX_USER_GRADE){
		$user_grades = $CI->config->item('user_grades');
		$next_grade = $user[0]->grade + 1;
		if(empty($user_grades[$next_grade]) == false){
			$user = $CI->User_model->get_entrie($user_idx);
			$point_t = $user[0]->point_t;
			$next_point = $user_grades[$next_grade][1];
			if($next_point <= $point_t){
				$rs = $CI->User_model->update_grade(array('grade'=>$next_grade, 'idx'=>$user_idx));
			}
		}
	}	


}
?>