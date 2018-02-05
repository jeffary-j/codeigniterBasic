<?
/**
 @file		gmail_helper.php
 @desc		gmail 전송 관련
 @author	dodars <dodars@hotmail.com>
 @data		2012-02-01
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//path to PHPMailer class
require_once('../lib/phpmailer/class.phpmailer.php');
// optional, gets called from within class.phpmailer.php if not already loaded
include('../lib/phpmailer/class.smtp.php');


define('MAIL_USER_ID', 'kisstimenet@gmail.com');
define('MAIL_USER_PW', 'kisstime3416');
define('MAIL_USER_NAME', 'KissTime');


function gmail($to, $subject, $message){

	/*
    [mail_user_id] => mobile@iwindy.com
    [mail_user_pw] => iwindy04
    [mail_user_name] => iWindy Co.,Ltd.
	*/

	$mail_user_id = MAIL_USER_ID;
	$mail_user_pw = MAIL_USER_PW;
	$mail_user_name = MAIL_USER_NAME;

    $mail = new PHPMailer();
    $mail->CharSet = "UTF-8";
    // telling the class to use SMTP
    $mail->IsSMTP();
    // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPDebug  = 0;
    // enable SMTP authentication
    $mail->SMTPAuth   = true;
    // sets the prefix to the servier
    $mail->SMTPSecure = "ssl";
    // sets GMAIL as the SMTP server
    $mail->Host       = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port       = 465;
    // GMAIL username
    $mail->Username   = $mail_user_id;
    // GMAIL password
    $mail->Password   = $mail_user_pw;//-----------------------
    //Set reply-to email this is your own email, not the gmail account
    //used for sending emails
    $mail->SetFrom($mail_user_id);
    $mail->FromName = $mail_user_name;
    // Mail Subject
    $mail->Subject    = $subject;

    //Main message
    $mail->MsgHTML($message);

    //Your email, here you will receive the messages from this form.
    //This must be different from the one you use to send emails,
    //so we will just pass email from functions arguments
    $mail->AddAddress($to, "");
    if(!$mail->Send())
    {
        //couldn't send
        return false;
    }
    else
    {
        //successfully sent
        return true;
    }
}
?>