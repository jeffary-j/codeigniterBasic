<?
//alert_helper.php
//http://codeigniter-kr.org => ci사랑
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// json 전송
function sendJson($msg='', $url='') {
	$CI =& get_instance();
	if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'>alert('".$msg."');";
	if ($url)
		echo "location.replace('".$url."');";
	else
		echo "history.go(-1);";
	echo "</script>";
	exit;
}

?>