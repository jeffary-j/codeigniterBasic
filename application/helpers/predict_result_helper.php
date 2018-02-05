<?
/**
 @file		predict_result_helper.php
 @desc		예상조합 결과
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function update_predict_result($frequency){

	$CI =& get_instance();

	$CI->load->model(USER_MODEL_DIR.'Lottery_result_model', '', true);
	$lottery_result = $CI->Lottery_result_model->get_entrie_by_frequency($frequency);
	
	if(empty($lottery_result[0]->frequency)) return;
		
	$CI->load->model(USER_MODEL_DIR.'Predict_model', '', true);
	$predicts = $CI->Predict_model->get_entries(
		array(
			'per_page'=>0,
			'article_per_page'=>100000,
			'frequency' => $frequency
		)
	);

	$lottery_ball_nums = array(
		$lottery_result[0]->ball_01,
		$lottery_result[0]->ball_02,
		$lottery_result[0]->ball_03,
		$lottery_result[0]->ball_04,
		$lottery_result[0]->ball_05,
		$lottery_result[0]->ball_06
	);
	
	$predict_records = array(
		'r1st' => 0,
		'r2nd' => 0,
		'r3rd' => 0,
		'r4th' => 0,
		'r5th' => 0
	);
	
	//print_v($lottery_ball_nums);
	
	$lottery_ball_bonus = $lottery_result[0]->ball_bonus;
	
	//print_v($predicts['total']);
	
	foreach($predicts['row'] as $predict){
		//print_v($lottery_ball_nums);
		
		$predict_balls = $predict->ball_nums;
		$predict_balls = explode(',', $predict_balls);
		
		//print_v($predict_balls);
		
		$merged_arr = array_merge ($lottery_ball_nums,  $predict_balls);
		
		$uniqued_arr = array_unique($merged_arr);
		
		//print_v($uniqued_arr);
		
		$uniqued_num = count($uniqued_arr);
		
		//print_v($uniqued_num);
		
		$correct_count = ($uniqued_num - 12) * -1;
		
		//print_v($correct_count);
		
		//print_v('------------------');
		
		if($correct_count == 3){
			$predict_records['r5th']++;
		} else if($correct_count == 4){
			$predict_records['r4th']++;
		} else if($correct_count == 5){
			if(in_array($lottery_ball_bonus, $predict_balls)){
				$predict_records['r2nd']++;
			} else {
				$predict_records['r3rd']++;
			}
		} else if($correct_count == 6){
			$predict_records['r1st']++;
		}
	}
	
	//print_v($predict_records);
	//결과 업데이트
	$param = array(
		'p_rs_1st' => $predict_records['r1st'],
		'p_rs_2nd' => $predict_records['r2nd'],
		'p_rs_3rd' => $predict_records['r3rd'],
		'p_rs_4th' => $predict_records['r4th'],
		'p_rs_5th' => $predict_records['r5th'],
		'frequency' => $frequency
	);
	$CI->Lottery_result_model->update_predict_rs($param);
	

/*

    function update_predict_rs($param)
    {
    	$prepare = array();
    	array_push($prepare, $param['p_rs_1st']);
		array_push($prepare, $param['p_rs_2nd']);
		array_push($prepare, $param['p_rs_3rd']);
		array_push($prepare, $param['p_rs_4th']);
		array_push($prepare, $param['p_rs_5th']);
		array_push($prepare, $param['frequency']);
*/


/*
	$predict_records = array(
		'r1st' => 0,
		'r2nd' => 0,
		'r3rd' => 0,
		'r4th' => 0,
		'r5th' => 0
	);
*/	
	
	
}
?>