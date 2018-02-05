<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 @class		User
 @desc		회원정보
 @author	jeff <elisau4@gmail.com>
 @data		2015-07-07
*/
class User extends CI_Controller {
	
	
	
	/**
	 @method	profile
	 @desc		회원 프로필
	*/
	function profile()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$this->load->model(USER_MODEL_DIR.'User_model', '', true);
		$user = $this->User_model->get_entrie($user_idx);
		
		$this->load->model(USER_MODEL_DIR.'Category_model', '', true);
		$categorys = $this->Category_model->get_entries();
		
		$data = array();
		
		$data['user'] = $user;
		$data['categorys'] = $categorys;
		
		$this->load->view(VIEW_PAGE.'front_user_profile', $data);
	
	}

	/**
	 @method	profile_update
	 @desc		회원 프로필 사진입력
	*/
	function profile_update()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		
		$idx = POST_PARAM('idx', '');
		
		$this->load->model(USER_MODEL_DIR.'User_model', '', true);
		$user = $this->User_model->get_entrie($idx);
		
		if($idx){
		
		//프로필사진 처리
			if(empty($_FILES['profile_image']['tmp_name']) == false){
				$this->load->helper('file');
				$file_save_path = DOT.PROFILE_UPFILE_PATH.DS.$idx;
				check_dir($file_save_path);
	
				$config['upload_path'] = $file_save_path;
				$config['allowed_types'] = 'png|jpg|jpeg|gif';
				$config['max_size']	= '102400';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('profile_image')){
					$data = array('upload_data' => $this->upload->data());
					$upload_file_name = $data['upload_data']['file_name'];
					$save_file_name = uniqid().'.'.substr(strrchr($upload_file_name, "."), 1);
					@rename ($file_save_path.'/'.$upload_file_name, $file_save_path.'/'.$save_file_name);
	
					$ong_file_name = make_thumbnail($file_save_path, $save_file_name, MAX_POST_ONG_IMG_W, MAX_POST_ONG_IMG_H, true, '', true);
					$param = array(
						'profile_image' => $ong_file_name,
						'user_idx' => $idx
					);
					$rs = $this->User_model->update_profile($param);
					//기존 사진파일 삭제
					if(file_exists($file_save_path.DS.$user[0]->profile_image)) @unlink($file_save_path.DS.$user[0]->profile_image);
				}
			}
		
			$this->load->helper('url');
			redirect($this->config->item('base_url'));
		} else {
			$this->load->helper('alert');
			alert('저장에 실패하였습니다.');
		}
	}

	
	/**
	 @method	register
	 @desc		회원가입 처리
	*/
	function register()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_GUEST);

		$email = POST_PARAM('email', '');
		$nick = POST_PARAM('nick', '');
		$login_pw = POST_PARAM('login_pw', '');
		$login_pw_repeat = POST_PARAM('login_pw_repeat', '');
		$type = USER_TYPE_MEMBER;

		$resultType = false;
		$message = '회원가입에 실패하였습니다';

		//중복체크
		$this->load->model('User_model', '', true);

		if(!empty($email)){
			$email_check_rs = $this->User_model->get_check_entrie($email, 'email');
			if(empty($email_check_rs[0]->idx)){
				
				if(!empty($nick)){
					$nick_check_rs = $this->User_model->get_check_entrie($nick, 'nick');
					if(empty($nick_check_rs[0]->idx)){
						if(!empty($login_pw) && $login_pw == $login_pw_repeat){
							$param = array(
								'type' => $type,
								'email' => $email,
								'login_pw' => $login_pw,
								'nick' => $nick
							);

							$idx = $this->User_model->insert_entry($param);
		
							if($idx){
								$resultType = true;
								$message = '회원가입에 성공하였습니다';
							} else {
								$resultType = false;
								$message = '회원가입에 실패했습니다. 다시시도해주세요';
							}
						}
						else {
							$message = '비밀번호가 일치하지 않거나 입력되지 않았습니다';
						}
					}
					else {
						$message = $nick.'은(는) 이미 사용중입니다';
					}
				}
				else {
					$message = '별명이 입력되지 않았습니다';
				}
			}
			else {
				$message = $email.'은(는) 이미 사용중입니다';
			}
		}
		else {
			$message = '이메일이 입력되지 않았습니다';
		}

		$result = array();
		$result["result"] = $resultType;
		$result["message"] = $message;

		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
	}
	
	
	/**
	 @method	exist_check
	 @desc		중복체크 (아이디, 닉네임, 이메일)
	*/
	function exist_check()
	{

		$check_target = '';
		$check_str = (empty($_POST['check_str'])) ? '' : $_POST['check_str'];
		if(!empty($this->uri->segments[3])){
			switch ($this->uri->segments[3]) {
				case 'email':
					$check_target = 'email';
					break;
				
				case 'value':
					$check_target = 'nick';
					break;
			}
		}

		$check_result = false;
		if($check_target != '' && $check_str){
			$this->load->model('User_model', '', true);
			$check_rs = $this->User_model->get_check_entrie($check_str, $check_target);
			if(empty($check_rs[0]->idx)){
				$check_result = true;
			}
		}
		//echo $check_result;
		
		
		//{"useable":"YES"}		
		
		$arr = array ('useable'=>$check_result);

		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($arr));
	}
}

