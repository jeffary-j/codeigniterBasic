<?
/**
 @file		file_helper.php
 @desc		파일관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 @function	check_dir
 @desc		디렉토리 체크
 @param		path : 경로
*/
function check_dir($path) {
	if(is_dir($path) == false){
		$path_arr = explode('/', $path);
		$dir = '.';
		for($i=1,$icnt=count($path_arr);$i<$icnt;$i++){
			$dir .= '/'.$path_arr[$i];
			//CI에서 업로드시 예외 발생할테니 여기선 하지 않음.
			if(!is_dir($dir)) @mkdir($dir, 0777);
		}
	}
}


function scan_dir($path){
		$dir = @opendir($path);
		if(!$dir) return;
		$return = array();
		while (false !== ($handle = readdir($dir))){
			if($handle != '.' && $handle != '..'){
				$time = filectime($path.'/'.$handle);
				$time = date('Y-m-d H:i:s', $time);
				$size = round((filesize($path.'/'.$handle) / 1024),1);

				if(!is_dir($path.'/'.$handle)){
					$return[] = array(
						'name' => $handle,
						'path' => $path,
						'size' => $size,
						'time' => $time
					);
				}
			}
		}
		closedir($dir);
		return $return;
}

/**
 @function
 @desc		파일 이동
 @param
*/
function file_move($src_file, $save_path, $file_name = null){
	check_dir($save_path);
	if(empty($file_name)){
		$file_name = strtolower(substr(strrchr($src_file, "/"), 1));
	}else{
		$file_name = $file_name.'.'.strtolower(substr(strrchr($src_file, "."), 1));
	}
	if(file_exists($src_file)){
		if(rename($src_file, $save_path.'/'.$file_name) == true){
			return $file_name;
		}else{
			//throw new Exception($src_file.' 파일을 '.$save_path.'/'.$file_name.' 로 이름바꾸기에 실패하였습니다.');
			//die('rename error:'.$src_file);
		}
	}else{
		//die('file not exists:'.$src_file);
	}

}

/**
 @function	rmdir_recursive
 @desc		디렉토리 삭제(재귀)
 @param		dir : 경로
*/
function rmdir_recursive($dir){
	if(is_dir($dir)){
		$directory = dir($dir);
		while($entry = $directory->read()) {
			if($entry != '.' && $entry != '..') {
				if(is_dir($dir.'/'.$entry)) {
					rmdir_recursive($dir.'/'.$entry);
				}else{
					@unlink($dir.'/'.$entry);
				}
			}
		}
		$directory->close();
		@rmdir($dir);
	}
}

/**
 @function	_thumbnail
 @desc		썸네일 생성
 @param		save_path : 저장경로
 			file_name : 파일명
 			max_width : 최대 크기
 			max_height : 최대 높이
 			overwrite : 덮어쓰기
 			suffix : 덮어쓰기가 아닐 경우 파일명 접미사
*/
function make_thumbnail($save_path, $file_name, $max_width, $max_height, $overwrite = false, $suffix = 't', $convertPngToJpg=false){

		$img_file = $save_path.'/'.$file_name;
		$img_info	= @getImageSize($img_file);
		$img_width	= $img_info[0];
		$img_height	= $img_info[1];
		$img_type	= $img_info[2];

		if(!$convertPngToJpg){
			if($img_width <= $max_width && $img_height <= $max_height) return $file_name;
		}

		switch($img_type) {
			case 1:
				$src_img = @imageCreateFromGIF($img_file);
				break;
			case 2:
				$src_img = @imageCreateFromJPEG($img_file);
				break;
			case 3:
				$src_img = @imageCreateFromPNG($img_file);
				break;
		}

		if(($img_width/$max_width) == ($img_height/$max_height)){
			$dst_width	= $max_width;
			$dst_height	= $max_height;
		}elseif(($img_width/$max_width) < ($img_height/$max_height)){
			$dst_width	= $max_height*($img_width/$img_height);
			$dst_height = $max_height;
		}else{
			$dst_width=$max_width;
			$dst_height=$max_width*($img_height/$img_width);
		}

		$dst_img = @imagecreatetruecolor($dst_width, $dst_height);

		@imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height);

		//PNG파일을 jpg로 변환을 원할 경우
		if($convertPngToJpg == true && $img_type == 3){
			$img_type = 2;
			$ext = substr(strrchr($file_name, "."), 1);
			$name = substr($file_name, 0, strlen($file_name) - strlen($ext)-1);
			$file_name = $name.'.jpg';
		}

		if($overwrite == true){
			@unlink($img_file);
			$save_file_name = $file_name;
		}else{
			$ext = substr(strrchr($file_name, "."), 1);
			$name = substr($file_name, 0, strlen($file_name) - strlen($ext)-1);
			$save_file_name = $name.'_'.$suffix.'.'.$ext;
		}



		switch($img_type) {
			case 1:
				$rs = @imagegif($dst_img, $save_path.'/'.$save_file_name);
				break;
			case 2:
				$rs = @imagejpeg($dst_img, $save_path.'/'.$save_file_name, 80);
				break;
			case 3:
				$rs = @imagepng($dst_img, $save_path.'/'.$save_file_name, 9);
				break;
			default :
				$rs = false;
		}
		@ImageDestroy($dst_img);
		@ImageDestroy($src_img);


		return ($rs) ? $save_file_name : false;
}

function file_download($dir, $file, $file_name = null){
	$fullsrc  = $dir.'/'.$file;
	if (!file_exists($fullsrc)){
		return false;
	}else{
		
		if(empty($file_name)) $file_name = $file;
		
		
		
		Header("Content-type:application/octet-stream");
		Header('Content-type: file/unknown');
		Header('Content-Length: '.(string)(filesize($fullsrc)));
		//Header('Content-Disposition: attachment; filename='.rawurlencode($file_name));
		header("Content-Disposition: attachment; filename*=UTF-8''" . rawurlencode($file_name) . '; filename="' . rawurlencode($file_name) . '"');
		Header('Content-Description: PHP4 Generated Data');
		header('Cache-Control: private');#ie6
		Header('Pragma: no-cache');
		Header('Expires: 0');
		$fp = fopen($fullsrc, 'rb');
		fpassthru($fp);
		fclose($fp);
	}
}

?>