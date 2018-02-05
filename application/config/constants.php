<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|--------------------------------------------------------------------------
| customer code
|--------------------------------------------------------------------------
*/

define('SUPERUSER_ID', '21232f297a57a5a743894a0e4a801fc3');
define('SUPERUSER_PW', '81dc9bdb52d04dc20036dbd8313ed055');

define('SUPERUSER_SESSION_KEY', '7a5a743894a0dc9bdb52d04dw');
define('USER_SESSION_KEY', '7a5a743894a0dc9bdb52d04dc');

define('USER_TYPE_GUEST', 		0);
define('USER_TYPE_MEMBER', 		1 << 0);
define('USER_TYPE_ARTIST', 		1 << 1);
define('USER_TYPE_ADMIN', 		1 << 2);

define('DOT', '.');
define('DS', '/');

define('LOG_FILE_PATH', $_SERVER['DOCUMENT_ROOT'].'/log/');
define('VIEW_FILE_APATH', $_SERVER['DOCUMENT_ROOT'].'/views/');

define('POST_UPFILE_PATH', '/attach_file/post');
define('PROFILE_UPFILE_PATH', '/attach_file/profile');
define('ARTICLE_UPFILE_PATH', '/attach_file/article');
define('POPUP_UPFILE_PATH', '/attach_file/popup');
define('TEMP_UPLOAD_PATH', '/attach_file/temp');
define('TEMP_THUMB_PATH', '/attach_file/thumb');
define('WATER_MARK_IMAGE', '/attach_file/sys/water_mark.png');



define('MESSAGE_ALL_USER_KEY', '52d04dc20036dbd831');
define('SEARCH_NAVER_KEY', 'abd04dc2003abd04c20');

define('SMS_CALLBACK_NUM', 		'07076869377');
define('MMS_CALLBACK_NUM', 		'07076869377');


#캐쉬 설정 (DB추가 필수)
define('CASH_ADJUST_ADMIN', 		1);
define('CASH_ADJUST_CHARGE', 		2);
define('CASH_ADJUST_EXST', 			3);
define('CASH_SEARCH_NAVER', 		4);
define('CASH_ADJUST_BBS_01',		0); //게시물작성 (1등,2등,3등 당첨)
define('CASH_ADJUST_BBS_02',		0); //게시물작성 (4등)
define('CASH_ADJUST_BBS_0343',		7);  //게시물작성 (로또러브 분석 공유, 끝수 및 필터분석 공유)
define('CASH_ADJUST_BBS_04',		8);  //게시물작성 (자동&반자동 공유 게시물)
define('CASH_ADJUST_CMRC',			9);  //댓글작성,추천


#포인트 설정 (DB추가 필수)
define('POINT_ADJUST_ADMIN', 		1);
define('POINT_ADJUST_JOIN', 		2);
define('POINT_ADJUST_LOGIN', 		3);
define('POINT_ADJUST_ATTENT', 		4);
define('POINT_ADJUST_ARTICLE', 		5);
define('POINT_ADJUST_COMMENT', 		6);
define('POINT_CONTENTS_ACTION', 	7);
define('POINT_ADJUST_RECOM', 		8);
define('POINT_ADJUST_ARTICLE_VIEW', 9);

define('ENCODED_REQUEST_URI', urlencode(base64_encode($_SERVER['REQUEST_URI'])));

define('MAX_POST_ONG_IMG_W', 600);
define('MAX_POST_ONG_IMG_H', 600);
define('MAX_POST_TN_IMG_W', 300);
define('MAX_POST_TN_IMG_H', 300);


define('MAX_ATC_ONG_IMG_W', 700);
define('MAX_ATC_ONG_IMG_H', 5000);


define('BBS_ROYAL_GROUP_IDX', 3);
define('BBS_ADAS_GROUP_IDX', 4);

define('BBS_WINCER123_BBS_IDX', 1);
define('BBS_WINCER45_BBS_IDX', 2);
define('BBS_RSHARE_BBS_IDX', 4);




define('BALL_NUM_NEEDLE', 23);

define('MAX_NUM_REPO_CNT', 99999999);
define('USING_EXST_CASH', 200);

define('ADMIN_PAGE', 'admin/');
define('VIEW_PAGE', 'front/');

define('ASSETS_CSS', 'assets/css/');
define('ASSETS_JS', 'assets/js/');

define('API_SUCCES', 7);
define('API_DIE', 4);

$config['user_status_flags'] = array(
    'A'=>'활성',
    'R'=>'보류',
    'L'=>'탈퇴',
    'D'=>'삭제'
);

$config['cm_status_flags'] = array(
    'A'=>'공개',
    'R'=>'보류',
    'D'=>'삭제'
);

$config['cp_status_flags'] = array(
    'A'=>'진행중',
    'R'=>'보류',
    'E'=>'종료',
    'D'=>'삭제'
);

$config['pm_status_flags'] = array(
    'W'=>'입금대기',
    'A'=>'승인완료',
    'R'=>'승인대기'
);

$config['cach_types'] = array(
    'CASH'=>'캐쉬충전'
);



define('MAX_USER_GRADE', 17); //회원 활동으로 최대로 올라갈수 있는 계급


$config['user_grades'] = array(
    //사병
    1 	=> array('이등병',	0),
    2 	=> array('일병',		100),
    3 	=> array('상병',		200),
    4 	=> array('병장',		400),

    //부사관
    5 	=> array('하사',		700),
    6 	=> array('중사',		1100),
    7 	=> array('상사',		1600),

    //위관장교
    8 	=> array('소위',		2300),
    9 	=> array('중위',		3200),
    10 	=> array('대위',		4200),

    //영관장교
    11 	=> array('소령',		5300),
    12 	=> array('중령',		6500),
    13 	=> array('대령',		7800),

    //장군
    14 	=> array('준장',		9400),
    15 	=> array('소장',		12000),
    16 	=> array('중장',		14700),
    17 	=> array('대장',		17400),
    //18 	=> array('원수',		50000000),
    19 	=> array('원사',		1000000000)

);



$config['user_types'] = array(
    USER_TYPE_GUEST 		=> '손님',
    USER_TYPE_MEMBER 		=> '일반회원',
    USER_TYPE_ARTIST 		=> '타투아티스트',
    USER_TYPE_ADMIN 		=> '운영자'
);

