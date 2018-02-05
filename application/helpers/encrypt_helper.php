<?
/**
 @file		encrypt_helper.php
 @desc		암호화 관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
define('ENCRTYPT_KEY', '1234567890abcdefghijklmnopqrstuv');
function test()
{
		// 복호화
		$body = post_value('data');
		$json_body = fnDecrypt($body, ENCRTYPT_KEY);

		// 암호화
		$data = array(
	           'code' => $status,
	           'message' => $message
		);

		$data = fnEncrypt(json_encode($data), ENCRTYPT_KEY);
}
*/


function fnEncrypt($sValue, $sSecretKey)
{
	$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
	$input = pkcs5_pad($sValue, $size);

	$key = $sSecretKey;
	$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
	$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	mcrypt_generic_init($td, $key, $iv);
	$data = mcrypt_generic($td, $input);
	mcrypt_generic_deinit($td);
	mcrypt_module_close($td);
	$data = base64_encode($data);

	return $data;
}

function fnDecrypt($sValue, $sSecretKey)
{
	return pkcs5_unpad(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $sSecretKey, base64_decode($sValue), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

function pkcs5_pad ($text, $blocksize)
{
	$pad = $blocksize - (strlen($text) % $blocksize);
	return $text . str_repeat(chr($pad), $pad);
}

function pkcs5_unpad($text) {
	$pad = ord($text{strlen($text)-1});
	if ($pad > strlen($text)) {
	 	return false;
	}
	if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
	  	return false;
	}
	return substr($text, 0, -1 * $pad);
}

?>