<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	/**
	 @method	index
	 @desc		로그인 폼
	*/
	function index()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_GUEST);
		
		$data = array();
		$data['ERU'] = GET_PARAM('ERU', '');
		
		$this->load->view(VIEW_PAGE.'front_auth', $data);

	}

	/**
	 @method	login
	 @desc		로그인 처리
	*/
	function login()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_GUEST);

		$email = POST_PARAM('email', null);
		$login_pw = POST_PARAM('login_pw', null);

		$this->load->helper('log');
		if($email && $login_pw){
			$this->load->model('User_model', '', true);
			$user = $this->User_model->get_entrie_login($email, $login_pw);
			if(!empty($user[0])){
			
				
			
				$user_info = $user[0];
/*
				$this->User_model->update_lastest_login($user_info->idx);

				$this->load->library('session');
*/
				
				$session_items = array();
				$session_items[USER_SESSION_KEY] = true;
		
				$session_items['user_idx'] = $user_info->idx;
				$session_items['user_type'] = $user_info->type;
				$session_items['user_email'] = $user_info->email;
				$session_items['user_name'] = $user_info->nick;
				

				//$this->load->library('session');
				$this->session->set_userdata($session_items);


				// 로그인 LOG DB저장
/*
				$login_date = date('Y-m-d');
				$login_time = date('H:i:s');
				$ip_addr = $_SERVER['REMOTE_ADDR'];
				$param = array(
					'email' 	=> $email,
					'ip_addr' 	=> $_SERVER['REMOTE_ADDR'],
					'login_date' => $login_date,
					'login_time' => $login_time,
					
				);
				$this->load->model(USER_MODEL_DIR.'Login_log_model', '', true);
				$log_idx = $this->Login_log_model->insert_entry($param);
*/				
				$get_url = POST_PARAM('ERU', '');

				if(empty($get_url)){
					$redirect_url = $this->config->item('base_url');
				} else {
					$redirect_url = $this->config->item('base_url').base64_decode(urldecode($get_url));
				}
				
				$this->load->helper('url');
				redirect($redirect_url, 'redirect');	
				
				
			} else {
				user_login_log($email, $login_pw, 'FAIL');
				$this->load->helper('alert');
				alert('아이디와 패스워드를 확인하세요.');
			}
		} else {
			user_login_log($email, $login_pw, 'FAIL');
			$this->load->helper('alert');
			alert('아이디와 패스워드를 입력하세요.');
		}
	}


	/**
	 @method	logout
	 @desc		로그아웃 처리
	*/
	function logout()
	{
		$this->load->helper('permission');

		check_user_type(USER_TYPE_MEMBER | USER_TYPE_TRAINER | USER_TYPE_LEDGER | USER_TYPE_ADMIN);

		$session_items = array();
		$session_items[USER_SESSION_KEY] = false;
		
		$session_items['user_idx'] = '';
		$session_items['user_type'] = '';
		$session_items['user_email'] = '';
		$session_items['user_name'] = '';
		$session_items['shop_idx'] = '';

		$this->load->library('session');
		$this->session->set_userdata($session_items);

		//$this->session->unset_userdata();

		//완전히 클리어 되지 않는 이느낌...
		$this->session->sess_destroy();


		$this->load->helper('url');
		redirect($this->config->item('base_url'), 'redirect');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */