<?
/**
 @file		common_helper.php
 @desc		공통함수
 @author	jeffary <elisau4@gmail.com>
 @data		2016-04-06
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function print_v($value){
	echo '<pre style="font-size:14px">';
	print_r($value);
	echo '</pre>';
}

function print_gpf()
{
	echo '_GET';
	print_v($_GET);
	echo '_POST';
	print_v($_POST);
	echo '_FILES';
	print_v($_FILES);
}

function truncate_mb($string, $length = 80, $etc = '..', $type='length' , $encoding='utf-8'){
	if($type == 'length'){
		if(mb_strlen($string, $encoding) > $length){
			return mb_substr($string, 0, $length, $encoding).$etc;
		}else{
			return $string;
		}
	}else if($type == 'width'){
		if(mb_strwidth($string, $encoding) > $length){
			return mb_strimwidth($string, 0, $length, $etc, $encoding);
		}else{
			return $string;
		}
	}
}

function GET_PARAM($key, $default = null){
	if(empty($_GET[$key])){
		return $default;
	} else {
		return $_GET[$key];
	}
}

function POST_PARAM($key, $default = null){
	if(empty($_POST[$key])){
		return $default;
	} else {
		return $_POST[$key];
	}
}

function CUP_SIZE_STRING($key){
	$CI =& get_instance();
	$cup_sizes = $CI->config->item('km_cup_sizes');
	if(@array_key_exists ($key , $cup_sizes)){
		return $cup_sizes[$key];
	} else {
		return '';
	}
}

function USER_GRADE_STRING($key, $type = USER_TYPE_MEMBER){
	$CI =& get_instance();
	$str = '';
	if($type == USER_TYPE_MEMBER){
		$user_grades = $CI->config->item('user_grades');
		if(array_key_exists ($key , $user_grades)){
			$str = $user_grades[$key][0];
		}		
	} else {
		$ef_type = 0;
		if($type & USER_TYPE_ADMIN){
			$ef_type = USER_TYPE_ADMIN;
		} else if($type & USER_TYPE_SPECIALIST){
			$ef_type = USER_TYPE_SPECIALIST;
		}
		$user_types = $CI->config->item('user_types');
		if(array_key_exists ($ef_type , $user_types)){
			$str = $user_types[$ef_type];
		}		
	}
	return $str;
}



function FORMFUL_DATE($date, $format = 'Y-m-d H:i:s'){

	if(empty($date) || $date == '0000-00-00 00:00:00'){
		return '-';
	} else {
		$timestamp = strtotime($date);
		if(date('Y-m-d', $timestamp) != date('Y-m-d')){
			return date('Y.m.d', $timestamp);
		} else {
			return date('H:i:s', $timestamp);
		}
	}
}

function POST_LIST_DATE($date, $format = 'Y-m-d H:i:s'){
	
	if(empty($date) || $date == '0000-00-00 00:00:00'){
		return '-';
	} else {
		$timestamp = strtotime($date);
		if(date('d', $timestamp) == date('d')){
			if(date('H', $timestamp)>='00' && date('H', $timestamp)<'12'){
				return '오늘 '.' 오전 '.date('H시 i분', $timestamp);
			} else {
				$date_pm = (date('H', $timestamp))-(12).'시 ';
				return '오늘 '.' 오후 '.$date_pm.date('i분', $timestamp);
			}
		} else {
			return date('y년 m월 d일 H시 i분', $timestamp);
		}
	}
}

function GET_TIME_AGO($date)
{
	$time_stamp = strtotime($date);

    $time_difference = strtotime('now') - $time_stamp;

    if ($time_difference >= 60 * 60 * 24 * 365.242199)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
         * This means that the time difference is 1 year or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24 * 365.242199, '년');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
         * This means that the time difference is 1 month or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24 * 30.4368499, '개월');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 7)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
         * This means that the time difference is 1 week or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24 * 7, '주');
    }
    elseif ($time_difference >= 60 * 60 * 24)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day
         * This means that the time difference is 1 day or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24, '일');
    }
    elseif ($time_difference >= 60 * 60)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour
         * This means that the time difference is 1 hour or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60, '시간');
    }
    else
    {
        /*
         * 60 seconds/minute
         * This means that the time difference is a matter of minutes
         */
        return GET_TIME_AGO_STRING($time_stamp, 60, '분');
    }
}

function GET_TIME_AGO_STRING($time_stamp, $divisor, $time_unit)
{
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = floor($time_difference / $divisor);

    settype($time_units, 'string');

    if ($time_units === '0')
    {
        return '1 ' . $time_unit . ' 전';
    }
    elseif ($time_units === '1')
    {
        return '1 ' . $time_unit . ' 전';
    }
    else
    {
        /*
         * More than "1" $time_unit. This is the "plural" message.
         */
        // TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
        return $time_units . ' ' . $time_unit . ' 전';
    }
}


function MANAGER_WORK_HOUR($hour){
	$return = ($hour <= 24) ? sprintf('%02d', $hour) : sprintf('AM%02d', $hour-24);
	return $return;
}

function STATUS_STRING($key, $flags_key){
	$CI =& get_instance();
	$flags = $CI->config->item($flags_key);
	$return = '';
	if(array_key_exists($key, $flags)){
		$return	= $flags[$key];
	} else {
		$return = $key;
	}
	return $return;
}

function STATUS_VARS($flags_key){
	$CI =& get_instance();
	$flags = $CI->config->item($flags_key);
	return $flags;
}

function LOCALIZED_STRING($lang_file, $lang_key) {
	$CI =& get_instance();
	static $lang_files = array();
	if (!in_array($lang_file, $lang_files)) {
		$CI->lang->load($lang_file, SERVICE_LANG);
		array_push($lang_files, $lang_file);
	}


	return $CI->lang->line($lang_file.'.'.$lang_key);
}


function DECODED_REQUEST_URI($URI){
	return ($URI) ? substr(base64_decode(urldecode($URI)), 1) : '';
}


function GET_RELATED_DATA($article_idx){
	$CI =& get_instance();
	$CI->load->model('category_model', '', true);
	$category_link = $CI->category_model->get_ac_entry($article_idx);
	
	
	$CI->load->model('keyword_model', '', true);
	$keyword_link = $CI->keyword_model->get_ak_entry($article_idx);
	
	$CI->load->model('post_model', '', true);
	$hit_count = $CI->post_model->get_hit_entrie($article_idx);
	
	$view_count = $hit_count[0]->hit;
	
	$CI->load->model('comment_model', '', true);
	$comment_count = $CI->comment_model->get_group_entries($article_idx);
	
	$reply_count = $comment_count['total'];
	
	$return = array(
		'category_links' => $category_link,
		'keyword_links' => $keyword_link,
		'view_count' => $view_count,
		'reply_count' => $reply_count
		
	);
	return $return;
}  
?>