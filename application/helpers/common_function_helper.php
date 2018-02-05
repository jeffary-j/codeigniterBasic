<?
/**
 @file		common_function_helper.php
 @desc		공통함수
 @author	dodars <dodars@hotmail.com>
 @data		2005-07-22
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function print_v($value){
	echo '<pre style="font-size:10px">';
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

function USER_GRADE_ICON($key, $type = USER_TYPE_MEMBER){


	$CI =& get_instance();
	$icon = '';
	if($type == USER_TYPE_MEMBER){
		$user_grades = $CI->config->item('user_grades');
		if(array_key_exists ($key , $user_grades)){
			$icon = '<img src="/images/user_grade_'.sprintf("%02d", $key).'.gif" align="absmiddle" alt="" />';
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
			$icon = '<img src="/images/user_type_'.sprintf("%02d", $ef_type).'.gif" align="absmiddle" alt="" />';
		}		
	}
	return $icon;
}

function SHOP_ICON($key){
	if($key == '2'){
		return '<img src="/images/icon_rec.gif" alt="" align="absmiddle" />';
	} else {
		return '';
	}
}


function MANAGER_ON_TABLE_ICON($key){
	if($key == 'Y'){
		return '<img src="/images/icon_on.gif" alt="" align="absmiddle" />';
	} else {
		return '';
	}
}


//$manager->idx.DS.$manager->profile_image_tn;

function MANAGER_PROFILE_IMAGE($idx, $image){
	if($image){
		return MANAGER_IMAGE_PATH.DS.$idx.DS.$image;
	} else {
		return DS.'images'.DS.'no_picture.gif';
	}
}

function MANAGER_ICON($key){
	if($key != ''){
		return '<img src="/images/icon_'.strtolower($key).'.gif" alt="" align="absmiddle" />';
	} else {
		return '';
	}
}

function DISPLAY_NEW_ICON($date, $hour = 24){
	if(strtotime('-'.$hour.' hour') < strtotime($date)){
		$icon = '<img src="/images/icon4.png">';
		return $icon;
	} else {
		return '';
	}
}

function DISPLAY_UPDATE_ICON($date, $hour = 24){
	if(strtotime('-'.$hour.' hour') < strtotime($date)){
		$icon = '<img src="/images/icon_update.gif" alt="" align="absmiddle" style="margin:0;" />';
		return $icon;
	} else {
		return '';
	}
}

function DISPLAY_IMAGE_ICON($cnt){
	if($cnt > 0){
		$icon = '<img src="/images/icon_pic.gif" align="absmiddle" style="margin:0 1px 0 1px;" />';
		return $icon;
	} else {
		return '';
	}
}

function DISPLAY_BLAME_ICON($is_blame){
	if($is_blame == 'Y'){
		return '<img src="/images/icon_damage.gif" align="absmiddle" style="margin:0 1px 0 1px;" />';
	} else {
		return '';
	}
}

function DISPLAY_RATE_AVG($avg){
	return sprintf("%01.1f", floor($avg * 10) / 10);
}

function DISPLAY_POSTSCRIPT_COUNT($cnt){
	if($cnt > 0){
		return '<span class="postscript_num" style="margin:0; padding:0;">['.$cnt.']</span>';
	} else {
		return '';
	}

}

function DISPLAY_COMMENT_COUNT($cnt){
	if($cnt > 0){
		//return '<span class="comment_num" style="margin:0; padding:0;">['.$cnt.']</span>';
		return '<span class="new">['.$cnt.']</span>';
	} else {
		return '';
	}
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

//등록시간 표시 이사님이 원하는 스타일인데 이걸 노가다로 해야하나...
function SIMPLE_DATE($date, $format = 'Y-m-d H:i:s'){
	
	if(empty($date) || $date == '0000-00-00 00:00:00'){
		return '-';
	} else {
		$sec_reg = strtotime($date);
		$sec_time = time();
		//반복문으로 할수있을꺼같은데...
		$second = 60;
		$res = array(
			'지금',
			'1분 전',
			'5분 전',
			'10분 전',
			'15분 전',
			'30분 전',
			'1시간 전',
			'2시간 전',
			'3시간 전',
			'6시간 전',
			'12시간 전',
			'1일 전',
			'2일 전',
			'3일 전',
			'7일 전',
			'15일 전',
			'1달 전',
			'2달 전',
			'3달 전',
			'6달 전',
			'1년 전',
			'2년 전',
			'3년 전',
			'4년 전',
			'5년 전',
			'10년 전'
		);
		
/*
		foreach($res as $key => $val){

		}
*/
		if($sec_time >= $sec_reg && $sec_time < ($sec_reg+60)){
			return '지금';
		} elseif($sec_time >= ($sec_reg+60) && $sec_time < ($sec_reg+300)) {
			return '1분 전';
		} elseif($sec_time >= ($sec_reg+300) && $sec_time < ($sec_reg+600)){
			return '5분 전';
		} elseif($sec_time >= ($sec_reg+600) && $sec_time < ($sec_reg+900)){
			return '10분 전';
		} elseif($sec_time >= ($sec_reg+900) && $sec_time < ($sec_reg+1800)){
			return '15분 전';
		} elseif($sec_time >= ($sec_reg+1800) && $sec_time < ($sec_reg+3600)){
			return '30분 전';
		} elseif($sec_time >= ($sec_reg+3600) && $sec_time < ($sec_reg+7200)){
			return '1시간 전';
		} elseif($sec_time >= ($sec_reg+7200) && $sec_time < ($sec_reg+10800)){
			return '2시간 전';			
		} elseif($sec_time >= ($sec_reg+10800) && $sec_time < ($sec_reg+21600)){
			return '3시간 전';			
		} elseif($sec_time >= ($sec_reg+21600) && $sec_time < ($sec_reg+43200)){
			return '6시간 전';			
		} elseif($sec_time >= ($sec_reg+43200) && $sec_time < ($sec_reg+86400)){
			return '12시간 전';			
		} elseif($sec_time >= ($sec_reg+86400) && $sec_time < ($sec_reg+172800)){
			return '1일 전';			
		} elseif($sec_time >= ($sec_reg+172800) && $sec_time < ($sec_reg+172800)){
			return '2일 전';			
		} elseif($sec_time >= ($sec_reg+259200) && $sec_time < ($sec_reg+604800)){
			return '3일 전';			
		} elseif($sec_time >= ($sec_reg+604800) && $sec_time < ($sec_reg+1296000)){
			return '7일 전';			
		} elseif($sec_time >= ($sec_reg+1296000) && $sec_time < ($sec_reg+2592000)){
			return '15일 전';			
		} elseif($sec_time >= ($sec_reg+2592000) && $sec_time < ($sec_reg+5184000)){
			return '1달 전';
		} elseif($sec_time >= ($sec_reg+5184000) && $sec_time < ($sec_reg+7776000)){
			return '2달 전';
		} elseif($sec_time >= ($sec_reg+7776000) && $sec_time < ($sec_reg+15552000)){
			return '3달 전';
		} elseif($sec_time >= ($sec_reg+15552000) && $sec_time < ($sec_reg+31104000)){
			return '6달 전';
		} elseif($sec_time >= ($sec_reg+31104000) && $sec_time < ($sec_reg+62208000)){
			return '1년 전';
		} elseif($sec_time >= ($sec_reg+62208000) && $sec_time < ($sec_reg+93312000)){
			return '2년 전';
		} elseif($sec_time >= ($sec_reg+93312000) && $sec_time < ($sec_reg+124416000)){
			return '3년 전';
		} elseif($sec_time >= ($sec_reg+124416000) && $sec_time < ($sec_reg+155520000)){
			return '4년 전';
		} elseif($sec_time >= ($sec_reg+155520000) && $sec_time < ($sec_reg+311040000)){
			return '5년 전';
		} else {
			return '10년 전';
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
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24 * 365.242199, 'year');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
         * This means that the time difference is 1 month or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24 * 30.4368499, 'month');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 7)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
         * This means that the time difference is 1 week or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24 * 7, 'week');
    }
    elseif ($time_difference >= 60 * 60 * 24)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day
         * This means that the time difference is 1 day or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60 * 24, 'day');
    }
    elseif ($time_difference >= 60 * 60)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour
         * This means that the time difference is 1 hour or more
         */
        return GET_TIME_AGO_STRING($time_stamp, 60 * 60, 'hour');
    }
    else
    {
        /*
         * 60 seconds/minute
         * This means that the time difference is a matter of minutes
         */
        return GET_TIME_AGO_STRING($time_stamp, 60, 'minute');
    }
}

function GET_TIME_AGO_STRING($time_stamp, $divisor, $time_unit)
{
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = floor($time_difference / $divisor);

    settype($time_units, 'string');

    if ($time_units === '0')
    {
        return 'less than 1 ' . $time_unit . ' ago';
    }
    elseif ($time_units === '1')
    {
        return '1 ' . $time_unit . ' ago';
    }
    else
    {
        /*
         * More than "1" $time_unit. This is the "plural" message.
         */
        // TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
        return $time_units . ' ' . $time_unit . 's ago';
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
	$CI->load->model(USER_MODEL_DIR.'Category_model', '', true);
	$category_link = $CI->Category_model->get_ac_entry($article_idx);
	
	
	$CI->load->model(USER_MODEL_DIR.'Keyword_model', '', true);
	$keyword_link = $CI->Keyword_model->get_ak_entry($article_idx);
	
	$CI->load->model(USER_MODEL_DIR.'Post_model', '', true);
	$hit_count = $CI->Post_model->get_hit_entrie($article_idx);
	
	$view_count = $hit_count[0]->hit;
	
	$CI->load->model(USER_MODEL_DIR.'Comment_model', '', true);
	$comment_count = $CI->Comment_model->get_group_entries($article_idx);
	
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