<?php 
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:24
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

    /**
    @method	    get_list
    @desc		리스트목록 보내기
     */
	public function get_list_json()
    {
        $article_idx = POST_PARAM('article_idx', '');

        $this->load->model('comment_model', '', true);
        $comments = $this->comment_model->get_group_entries($article_idx);

        $data = array();


        if(empty($comments) || $comments['total'] < 1){
            $code = API_DIE;
        } else {
            $code = API_SUCCES;
            $data = $comments;
        }

        $response = array(
            'code' => $code,
            'data' => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

	/**
	 @method	input
	 @desc		등록처리
	*/
	function input()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		$contents = POST_PARAM('contents', '');
		$article_idx = POST_PARAM('article_idx', '');
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		
		$required_fields = array('contents', 'article_idx');
		$empty_count = 0;
		foreach($required_fields as $required_field){
			if(empty(${$required_field}))
			{
				echo $required_field;
				$empty_count++;
			}
		}
		if($empty_count > 0){
			$this->load->helper('alert');
			alert($empty_count.' 개의 필수항목이 누락되었습니다.');
		}

		$this->load->model('comment_model', '', true);

		$param = array(
			'contents' => $contents,
			'user_idx' => $user_idx,
			'article_idx' => $article_idx
		);
		$comment_idx = $this->comment_model->insert_entry($param);


		if($comment_idx){
			$this->load->helper('url');
			$ERI = (empty($_GET['ERI'])) ? '' : $_GET['ERI'];
			redirect($this->config->item('base_url').DECODED_REQUEST_URI($ERI));
		} else {
			$this->load->helper('alert');
			alert('저장에 실패하였습니다.');
		}
	}	
	
	
	
	
	
	
	/**
	 @method	input3
	 @desc		댓글 등록 처리 (옛날꺼.... 쓰지 않음)
	*/
	function input3()
	{
		print_gpf();
		exit;
	
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		$_POST['photo'] = '1111'; 
		$_POST['photo_t'] = '1111'; 
		
		$photo = POST_PARAM('photo', '');
		$photo_t = POST_PARAM('photo_t', '');
		$contents = POST_PARAM('contents', '');

		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		//$ip_addr = $_SERVER['REMOTE_ADDR'];

/*
		$required_fields = array('login_id', 'login_pw', 'name');
		$empty_count = 0;
		foreach($required_fields as $required_field){
			if(empty(${$required_field})) $empty_count++;
		}
		if($empty_count > 0){
			$this->load->helper('alert');
			alert($empty_count.' 개의 필수항목이 누락되었습니다.');

		}		
*/		
		$this->load->model(USER_MODEL_DIR.'Post_model', '', true);
		$param = array(
			'photo' => $photo,
			'photo_t' => $photo_t,
			'contents' => $contents,
			'user_idx' => $user_idx
		);


		
		$idx = $this->Post_model->insert_entry($param);
		
		if($idx){
			$this->load->helper('url');
			redirect($this->config->item('base_url'));
		} else {
			$this->load->helper('alert');
			alert('저장에 실패하였습니다.');
		}
	}
	
	/**
	 @method	delete
	 @desc		댓글 삭제
	*/
	function delete()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		if(empty($this->uri->segments[3])){
			$this->load->helper('alert');
			alert('댓글 정보를 확인 할 수 없습니다.');
		}
		$idx = $this->uri->segments[3];
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$this->load->model(USER_MODEL_DIR.'Comment_model', '', true);
		$comment = $this->Comment_model->get_entrie($idx);
		
		if($comment[0]->user_idx == $user_idx){

			$rs = $this->Comment_model->update_status($comment[0]->idx, 'D');
			if($rs){
				$this->load->helper('url');
				$ERI = (empty($_GET['ERI'])) ? '' : $_GET['ERI'];
				redirect($this->config->item('base_url').DECODED_REQUEST_URI($ERI).'post/info/'.$comment[0]->article_idx);
			} else {
				$this->load->helper('alert');
				alert('댓글 삭제에 실패하였습니다.');
			}
		} else {
			$this->load->helper('alert');
			alert('본인이 작성한 댓글만 삭제 할 수 있습니다.');
		}
	}
}

