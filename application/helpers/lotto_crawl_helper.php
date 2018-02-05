<?
/**
 @file		lotto_craw_helper.php
 @desc		로고관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curl_class {
	var $url = '';                // 접속 URL
	var $cookie = 'cookie.txt';  // 쿠키파일 입니다.
	var $post = 0;                // post 값 여부
	var $parms = '';                // 전송할 파라미터
	var $parms_type = '';                // 전송할 파라미터 타입
	var $recive = '';                // 결과값 저장
	var $return = 1;                // Curl 옵션
	var $timeout = 30;                // Curl 옵션
	var $addopt = '';                  // 추가 Curl 옵션
	function action(){
		/* 배열로 저장된 파리미터 값을 Get 타입으로 변경 해줌 */
		if($this->parms_type == 'get'){
			if(sizeof($this->parms) > 0){
				$datas = '';
				foreach ($this->parms as $obj=>$val){
					$datas .= $obj.'='.$val.'&';
				}
				$this->parms = substr($datas,0,-1);
			}
		}
		// Curl 실행
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL,$this->url);
		curl_setopt ($ch, CURLOPT_POST, $this->post);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $this->parms);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, $this->return);

        // 추가 Curl옵션이 있을경우 이를 적용 시켜줌
        if($this->addopt) curl_setopt_array($ch, $this->addopt);
        $this->recive = curl_exec ($ch);
        curl_close($ch);
   }

}

//LOG_FILE_PATH

function get_lotto_data($frequency){
	$return = array();
	
	$curl_obj = new Curl_class();
	
	$data['mb_id'] 			= 'khasar02';
	$data['mb_password'] 	= 'rafael02';
	
	//다음 SSL 추가 옵션
	$curl_opt[CURLOPT_SSL_VERIFYPEER] = 0;
	$curl_opt[CURLOPT_SSLVERSION] = 1;
	
	// 다음 로그인 URL
	$curl_obj->url = "https://www.lottostar.kr/bbs/login_check.php";
	
	$curl_obj->parms = $data;
	$curl_obj->addopt = $curl_opt;
	
	// 쿠키가 저장될 위치 및 파일명 지정
	$curl_obj->cookie = LOG_FILE_PATH.mktime().'_cookie.txt';
	
	// 1은 POST 값이 있다는 의미
	$curl_obj->post = 1;
	
	// POST 값이 폼데이터 형식이 아닌 GET 형식으로 전송
	$curl_obj->parms_type = 'get';
	
	//로그인 실행
	$curl_obj->action();
	
	//위 로그인된 쿠키 이용하기
	$curl = new Curl_class();
	
	
	
	////////-----------------------------------당첨점 정보
	//다음 메인 페이지 (회차별 당첨점 정보 페이지)
	
	
	//이전에 로그인된 쿠키 적용
	$curl->cookie = $curl_obj->cookie;
	
	//페이지 이동
	$curl->url = "http://www.lottostar.kr/analysis/panmaejeom.php?cha=".$frequency;
	$curl->action();
	$html =  $curl->recive;

	
	$html = iconv("EUC-KR", "UTF-8", $html);
	$html = str_replace('&nbsp;', '', $html);
	$rex_data_table="/\<table border=0 cellpadding=0 cellspacing=0 width=100% class=\'data_view\'\>(.*)\<\/table\>/isU";
	preg_match_all($rex_data_table, $html, $o,PREG_PATTERN_ORDER );
	
	$table_elems = $o[1];
	$store_1st_trs = $table_elems[0];
	$store_2nd_trs = $table_elems[1];
	
	$rex_1st_tr="/\<tr.*\>(.*)\<\/tr\>/isU";
	preg_match_all($rex_1st_tr,$store_1st_trs,$o_1st,PREG_PATTERN_ORDER );
	
	$store_1st_tds = $o_1st[1];
	$rex_1st_td="/\<td.*\>(.*)\<\/td\>/isU";
	
	$store_1st_arr = array();
	foreach($store_1st_tds as $store_1st_td){
		preg_match_all($rex_1st_td,$store_1st_td,$o_1st_td,PREG_PATTERN_ORDER );
		if(empty($o_1st_td[1])) continue;
	
		$store_name = strip_tags($o_1st_td[1][1]);
		$extract_type = strip_tags($o_1st_td[1][2]);
		$store_addr = strip_tags($o_1st_td[1][3]);
		$store_info = array(trim($store_name), trim($store_addr), trim($extract_type));
		array_push($store_1st_arr, implode('|', $store_info));
	}
	$return['store_1st'] = implode("\n", $store_1st_arr);
	
	$rex_2cd_tr="/\<tr.*\>(.*)\<\/tr\>/isU";
	preg_match_all($rex_2cd_tr,$store_2nd_trs,$o_2cd,PREG_PATTERN_ORDER );
	$store_2cd_tds = $o_2cd[1];
	$rex_2cd_td="/\<td.*\>(.*)\<\/td\>/isU";
	
	$store_2nd_arr = array();
	foreach($store_2cd_tds as $store_2cd_td){
		preg_match_all($rex_2cd_td,$store_2cd_td,$o_2cd_td,PREG_PATTERN_ORDER );
		if(empty($o_2cd_td[1])) continue;

		$store_name = strip_tags($o_2cd_td[1][1]);
		$store_addr = strip_tags($o_2cd_td[1][2]);
		$store_info = array(trim($store_name), trim($store_addr));
		array_push($store_2nd_arr, implode('|', $store_info));		
	}
	$return['store_2nd'] = implode("\n", $store_2nd_arr);



	////////-----------------------------------당첨정보
	//다음 메인 페이지
	$curl->url = "http://www.lottostar.kr/sub_pg/lotto_prize.html";
	$data = array(
		'sround' => $frequency,
		'eround' => $frequency,
		'hogiis' => '',
		'hoiguiis' => ''
	
	);
	
	$curl->parms = $data;
	// 1은 POST 값이 있다는 의미
	$curl->post = 1;
	// POST 값이 폼데이터 형식이 아닌 GET 형식으로 전송
	$curl->parms_type = 'get';
	
	//이전에 로그인된 쿠키 적용
	$curl->cookie = $curl_obj->cookie;
	
	//페이지 이동
	$curl->action();
	$html =  $curl->recive;
	$html = iconv("EUC-KR", "UTF-8", $html);
	$html = str_replace('&nbsp;', '', $html);
	
	$rex_data_summary="/\<tr onclick=\'showInfo\(.*\);\' style=\'cursor:hand\'\>(.*)\<\/tr\>/isU"; //횟차 정보
	$rex_data_score="/\<table .*class=\'info_list\'\>(.*)\<\/table\>/isU"; //회차별 1~5등 명수, 금액

	preg_match_all($rex_data_summary, $html, $o,PREG_PATTERN_ORDER );
	preg_match_all($rex_data_score, $html, $o2,PREG_PATTERN_ORDER );
	
	$summary_rows = $o[1];
	$score_rows = $o2[1];
	
	$rex_num = "/[^0-9]*/s";
	$rex_summary_td = "/\<td.*\>(.*)\<\/td.*\>/isU";
	$rex_ball_img = "/<img src=\'\/image\/ball_img_small1\/n_(.*).png\'\>/isU";
	
	
	$icnt = count($summary_rows);

	$lottery_result = array();
	
	for($i=0;$i<$icnt;$i++){
		$summary_row = $summary_rows[$i];
		$score_row = $score_rows[$i];
		
		preg_match_all($rex_summary_td,$summary_row,$summary_td,PREG_PATTERN_ORDER);
		//if(empty($o_1st_td[1])) continue;
		/* print_r($summary_td[1]); */
		
		if($frequency == $summary_td[1][0]) continue;	
	
		
		$ext_device	= $summary_td[1][1];//3
	    $ext_date	= $summary_td[1][2];//015-01-17
	    $ball_images= $summary_td[1][3];//
	    $amt_1st 	= $summary_td[1][4];//1,217,257,094 원 
	    $cnt_1st	= $summary_td[1][5];//12 명	
	
	    preg_match_all($rex_ball_img,$ball_images,$ball_nums,PREG_PATTERN_ORDER);
	    
		$ball_01 = $ball_nums[1][0];
		$ball_02 = $ball_nums[1][1];
		$ball_03 = $ball_nums[1][2];
		$ball_04 = $ball_nums[1][3];
		$ball_05 = $ball_nums[1][4];
		$ball_06 = $ball_nums[1][5];
		$ball_bonus = $ball_nums[1][6];
	
	    $ext_device = preg_replace($rex_num, "", $ext_device);
	    $ext_date 	= trim($ext_date);
	    $amt_1st 	= preg_replace($rex_num, "", $amt_1st);
	    $cnt_1st 	= preg_replace($rex_num, "", $cnt_1st);
	    
		$rex_cbb_td = "/\<td class=\'cbb\'\>(.*)\<\/td\>/isU";
		$rex_cbc_td = "/\<td class=\'cbc\'\>(.*)\<\/td\>/isU";
	
		preg_match_all($rex_cbb_td,$score_row,$cbb_td,PREG_PATTERN_ORDER);
		preg_match_all($rex_cbc_td,$score_row,$cbc_td,PREG_PATTERN_ORDER);
		
		$amt_2nd = $cbb_td[1][1];
		$cnt_2nd = $cbc_td[1][1];
		$amt_3rd = $cbb_td[1][2];
		$cnt_3rd = $cbc_td[1][2];
		$amt_4th = $cbb_td[1][3];
		$cnt_4th = $cbc_td[1][3];
		$amt_5th = $cbb_td[1][4];
		$cnt_5th = $cbc_td[1][4];
		
		$amt_2nd 	= preg_replace($rex_num, "", $amt_2nd);
		$cnt_2nd 	= preg_replace($rex_num, "", $cnt_2nd);
		$amt_3rd 	= preg_replace($rex_num, "", $amt_3rd);
		$cnt_3rd 	= preg_replace($rex_num, "", $cnt_3rd);
		$amt_4th 	= preg_replace($rex_num, "", $amt_4th);
		$cnt_4th 	= preg_replace($rex_num, "", $cnt_4th);
		$amt_5th 	= preg_replace($rex_num, "", $amt_5th);
		$cnt_5th 	= preg_replace($rex_num, "", $cnt_5th);
		
		$lottery_result['ext_device'] = $ext_device;
		$lottery_result['ext_date'] = $ext_date;
		
		$ball_num =array($ball_01, $ball_02, $ball_03, $ball_04, $ball_05, $ball_06);
		
		$lottery_result['ball_num'] = implode(",", $ball_num);
		$lottery_result['ball_bonus'] = $ball_bonus;
		
		$lottery_result['amt_1st'] = $amt_1st;
		$lottery_result['cnt_1st'] = $cnt_1st;
		$lottery_result['amt_2nd'] = $amt_2nd;
		$lottery_result['cnt_2nd'] = $cnt_2nd;
		$lottery_result['amt_3rd'] = $amt_3rd;
		$lottery_result['cnt_3rd'] = $cnt_3rd;
		$lottery_result['amt_4th'] = $amt_4th;
		$lottery_result['cnt_4th'] = $cnt_4th;
		$lottery_result['amt_5th'] = $amt_5th;
		$lottery_result['cnt_5th'] = $cnt_5th;
		
		break;
		
	}
	$return['lottery_result'] = $lottery_result;
	
	
	////////-----------------------------------공나온 순서
	//다음 메인 페이지
	$curl->url = "http://www.lottostar.kr/analysis/gongchulsun.php?rows=1&page=1";
	
	// 1은 POST 값이 있다는 의미
	$curl->post = 0;
	// POST 값이 폼데이터 형식이 아닌 GET 형식으로 전송
	$curl->parms_type = '';

	
	//이전에 로그인된 쿠키 적용
	$curl->cookie = $curl_obj->cookie;
	//페이지 이동
	$curl->action();
	
	$html =  $curl->recive;
	$html = iconv("EUC-KR", "UTF-8", $html);
	$html = str_replace('&nbsp;', '', $html);
	
	$rex_data_seq="/\<tr class=\"tt5\"\>(.*)\<\/tr\>/isU"; //공나온 순서 tr
	preg_match_all($rex_data_seq, $html, $o,PREG_PATTERN_ORDER);
	$seq_rows = $o[1];
	$rex_num = "/[^0-9]*/s";
	
	$rex_tt3_td = "/\<td class=\"tt3\".*\>(.*)\<\/td\>/isU";
	$rex_tt1_td = "/\<td class=\"tt1\".*\>(.*)\<\/td\>/isU";
	$rex_tt4_td = "/\<td class=\"tt4\".*\>(.*)\<\/td\>/isU";
	
	$icnt = count($seq_rows);
	
	
	
	for($i=0;$i<$icnt;$i++){
		$seq_row = $seq_rows[$i];
		
		preg_match_all($rex_tt3_td,$seq_row,$tt3_td,PREG_PATTERN_ORDER);
		preg_match_all($rex_tt1_td,$seq_row,$tt1_td,PREG_PATTERN_ORDER);
		preg_match_all($rex_tt4_td,$seq_row,$tt4_td,PREG_PATTERN_ORDER);
		
		if($frequency == $tt3_td[1][0]) continue;
		
		$ball_01 = $tt1_td[1][0];
		$ball_02 = $tt1_td[1][1];
		$ball_03 = $tt1_td[1][2];
		$ball_04 = $tt1_td[1][3];
		$ball_05 = $tt1_td[1][4];
		$ball_06 = $tt1_td[1][5];
		
		$ball_01 = strip_tags($ball_01);
		$ball_02 = strip_tags($ball_02);
		$ball_03 = strip_tags($ball_03);
		$ball_04 = strip_tags($ball_04);
		$ball_05 = strip_tags($ball_05);
		$ball_06 = strip_tags($ball_06);
		
		$ball_seq = array((int)$ball_01, (int)$ball_02, (int)$ball_03, (int)$ball_04, (int)$ball_05, (int)$ball_06);
		
		$return['ball_seq'] = implode(",", $ball_seq);
			
		break;
	}
	
	$return['frequency'] = $frequency;
	
	return $return;
	
}

?>








