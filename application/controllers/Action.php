<?php
/**
 @class		Action
 @desc		컨텐츠 액션 (추천, 신고)
 @author	jeff <elisau4@gmail.com>
 @data		2015-08-18
*/
class Action extends CI_Controller {
	
	
	/**
	 @method	rc
	 @desc		추천
	*/
	function rc()
	{	
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$post_idx = POST_PARAM('post_idx'); //post로 보낼꺼니까 이렇게 받으면 되겠지?
		
		if(empty($user_idx)){
			//비로그인
			$result = array(
				'response' => array(
					'code' => 'notlogin', 
					'idx' => $post_idx,
					'cnt' => '0'
				)
			);

		} else {
			$this->load->model(USER_MODEL_DIR.'Rc_history_medel', '', true);
			$already_entrie = $this->Rc_history_medel->get_already_entrie($user_idx, $post_idx);
			
			if(!empty($already_entrie[0]->idx)){
				//중복
				$result = array(
					'response' => array(
						'code' => 'overlap', 
						'idx' => $post_idx,
						'cnt' => '0'
					)
				);
			} else {
				$param = array(
					'user_idx' => $user_idx,
					'article_idx' => $post_idx
				);
				
				$rc_idx = $this->Rc_history_medel->insert_entry($param);
				
				if($rc_idx){
	
					$this->load->model(USER_MODEL_DIR.'Post_model', '', true);
					$post = $this->Post_model->get_entrie($post_idx);
					
					if(empty($post[0]->idx)){
						$result = array(
							'response' => array(
								'code' => 'false',
								'idx' => $post_idx,
								'cnt' => '0'
							)
						);
					} else {
						$this->Post_model->update_count($post_idx, 'love');
						$post = $this->Post_model->get_entrie($post_idx);
						
						$result = array(
							'response' => array(
								'code' => 'success', //loveit 을 성공했을경우 (실패의 경우는 뭐 비로그인,중복,DB에러 등 다양한 경우가 있겠지...
								'idx' => $post_idx,
								'cnt' => $post[0]->love //이건 처리후에 따로 가져와서 넣어줌
							)
						);	
					}
				}
			}
		}
		
		echo json_encode($result);
		exit;
		
		/*
		이제 처리해야 할일
		1.Rc_history_medel 에 입력
		2.해당 게시물 loveit 카운트 +1
		3.결과값 json 리턴		
		*/

		
/*
		echo json_encode($result);
		exit;
*/
		/********************************************************************************************************/
		/********************************************************************************************************/
		/********************************************************************************************************/		
		//실제 DB처리는 안했으니까 구현해 보렴 (처리 해야할 post_idx는 위에서 처럼 받으면 되고 회원정보는 세션에서 찾으면 됨
		/********************************************************************************************************/
		/********************************************************************************************************/
		/********************************************************************************************************/

/*
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER|USER_TYPE_ARTIST|USER_TYPE_ADMIN);

		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');

		$tb = (empty($_GET['tb'])) ? '' : $_GET['tb'];
		$article_idx = (empty($_GET['article_idx'])) ? '' : $_GET['article_idx'];
		$ip_addr = $_SERVER['REMOTE_ADDR'];



		$required_fields = array('tb', 'article_idx');
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

		$this->load->model(USER_MODEL_DIR.'Rc_history_medel', '', true);

		$already_entrie = $this->Rc_history_medel->get_already_entrie($user_idx, $article_idx);

		if(!empty($already_entrie[0]->idx)){
			$this->load->helper('alert');
			alert('이미 추천한 컨텐츠 입니다.');
		}

		$param = array(
			'ip_addr' => $ip_addr,
 			'tb' => $tb,
			'user_idx' => $user_idx,
			'article_idx' => $article_idx
		);
		
		$rc_idx = $this->Rc_history_medel->insert_entry($param);

		if($rc_idx){

			if($tb == 'article'){
				//이제 게시물 밖에 없음...
				
				$this->load->model(USER_MODEL_DIR.'Post_model', '', true);
				
				//게시물 가져와서
				$article = $this->Post_model->get_entrie($article_idx);
				
				
				if(empty($article[0]->idx)){
					$this->load->helper('alert');
					alert('게시물이 존재하지 않습니다.');					
				} else {
					//게시판 정보 가져와서 설정에 따라.
					$this->load->model(USER_MODEL_DIR.'Bbs_model', '', true);
					$bbs = $this->Bbs_model->get_entrie($article[0]->bbs_idx);
					
					if($bbs[0]->p_recom != 0){
						$this->load->helper('user_point');
						user_point_add($user_idx, POINT_CONTENTS_ACTION, $bbs[0]->p_recom, $rc_idx);						
					}
					
					$this->load->helper('user_cash');
					user_cash_add($user_idx, CASH_ADJUST_CMRC, 0, $rc_idx);						
	
					$this->Article_model->update_count($row_idx, 'rc_cnt');					
				}
			
			}
			$this->load->helper('url');
			$ERI = (empty($_GET['ERI'])) ? '' : $_GET['ERI'];
			redirect($this->config->item('base_url').DECODED_REQUEST_URI($ERI));
		} else {
			$this->load->helper('alert');
			alert('저장에 실패하였습니다.');
		}
*/
	}


	/**
	 @method	dis
	 @desc		신고
	*/
	function dis()
	{

		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER|USER_TYPE_ARTIST|USER_TYPE_ADMIN);

		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');

		$tb = (empty($_GET['tb'])) ? '' : $_GET['tb'];
		$row_idx = (empty($_GET['row_idx'])) ? '' : $_GET['row_idx'];
		$ip_addr = $_SERVER['REMOTE_ADDR'];



		$required_fields = array('tb', 'row_idx');
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

		$this->load->model(USER_MODEL_DIR.'Dis_history_medel', '', true);

		$already_entrie = $this->Dis_history_medel->get_already_entrie($user_idx, $tb, $row_idx);

		if(!empty($already_entrie[0]->idx)){

			$this->load->helper('alert');
			alert('이미 신고한 컨텐츠 입니다.');
		}

		$param = array(
			'ip_addr' => $ip_addr,
			'user_idx' => $user_idx,
			'tb' => $tb,
			'row_idx' => $row_idx
		);

		$dis_idx = $this->Dis_history_medel->insert_entry($param);

		if($dis_idx){

			$this->load->helper('user_point');
			user_point_add($user_idx, POINT_CONTENTS_ACTION, 0, $dis_idx);

			if($tb == 'article'){
				$this->load->model(USER_MODEL_DIR.'Article_model', '', true);
				$this->Article_model->update_count($row_idx, 'dis_cnt');
			} else if($tb == 'shop'){
				$this->load->model(USER_MODEL_DIR.'Shop_model', '', true);
				$this->Shop_model->update_count($row_idx, 'dis_cnt');
			} else if($tb == 'manager'){
				$this->load->model(USER_MODEL_DIR.'Manager_model', '', true);
				$this->Manager_model->update_count($row_idx, 'dis_cnt');
			} else if($tb == 'postscript'){
				$this->load->model(USER_MODEL_DIR.'Postscript_model', '', true);
				$this->Postscript_model->update_count($row_idx, 'dis_cnt');
			} else if($tb == 'schedule'){
				$this->load->model(USER_MODEL_DIR.'Schedule_model', '', true);
				$this->Schedule_model->update_count($row_idx, 'dis_cnt');
			} else if($tb == 'comment'){
				$this->load->model(USER_MODEL_DIR.'Comment_model', '', true);
				$this->Comment_model->update_count($row_idx, 'dis_cnt');
			}
			
			
			
			$this->load->helper('alert');
			$ERI = (empty($_GET['ERI'])) ? '' : $_GET['ERI'];
			alert('신고가 접수되었습니다. ', $this->config->item('base_url').DECODED_REQUEST_URI($ERI));				

/*
			$this->load->helper('url');
			$ERI = (empty($_GET['ERI'])) ? '' : $_GET['ERI'];
			redirect($this->config->item('base_url').DECODED_REQUEST_URI($ERI));
*/
			
			
			
		} else {
			$this->load->helper('alert');
			alert('저장에 실패하였습니다.');
		}
	}
}
?>