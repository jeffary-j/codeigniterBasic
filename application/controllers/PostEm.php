<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:24
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PostEm extends CI_Controller {
	
	/**
	 @method	index
	 @desc		포스트 상세
	*/
	function index()
	{
		
		$article_idx = GET_PARAM('no', '');
		
		$this->load->model('post_model', '', true);
		$post = $this->post_model->get_entrie($article_idx);

        if(empty($article_idx)|| empty($post)){
            $this->load->helper('alert');
            alert('게시물정보가 옳바르지 않습니다.');
        }

		$this->load->helper('pv_count');
		if(pv_check()){
			$this->post_model->update_count($article_idx, 'hit');
		}		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$this->load->model('user_model', '', true);
		$user = $this->user_model->get_entrie($user_idx);
		
/*
		$this->load->model('category_model', '', true);
		$categorys = $this->category_model->get_entries();
*/

        $related_data = GET_RELATED_DATA($post[0]->idx);

        if(empty($related_data['category_links']) == false)
        {
            $post[0]->categorys = array();
            foreach($related_data['category_links'] as $category_links){
                array_push($post[0]->categorys, $category_links);
            }
        }
        if(empty($related_data['keyword_links']) == false)
        {
            $post[0]->keywords = array();
            foreach($related_data['keyword_links'] as $keyword_links){
                array_push($post[0]->keywords, $keyword_links);
            }
        }

        $post[0]->view_count = $related_data['view_count'];
        $post[0]->reply_count = $related_data['reply_count'];

		$data = array();
		$data['post'] = $post[0];
		$data['user'] = $user;
//		$data['categorys'] = $categorys;

//        print_v($data);
        $this->load->view(VIEW_PAGE.'_front_header');
		$this->load->view(VIEW_PAGE.'front_post', $data);
        $this->load->view(VIEW_PAGE.'_front_footer');
	}
	
	
	// 은미 상세페이지
	function emview(){
		$this->load->view(VIEW_PAGE.'_front_header_em');
		$this->load->view(VIEW_PAGE.'front_post_em');
        $this->load->view(VIEW_PAGE.'_front_footer_em');
	}
	
	
	
	/**
	 @method	get_list
	 @desc		포스트 리스트 가져오기
	*/
	function get_list()
	{
        //$this 키워드는 클래스 자신
        /*
                $w_types 	= array(
                    'category' 	=> array('카테고리' ,'category'),
                    'keyword ' 	=> array('키워드'	,'keyword')
                );
        */

/*
        $per_page				=	POST_PARAM('per_page', 0);
        $article_per_page		=	12;

        $c = POST_PARAM('c', '');
        $k = POST_PARAM('k', '');
        $q = POST_PARAM('q', '');

        $common_params		=	array();
        array_push($common_params, 'c='.$c);
        array_push($common_params, 'k='.$k);
        array_push($common_params, 'q='.$q);
        array_push($common_params, 'per_page='.$per_page);
        $common_param		=	implode('&', $common_params);
        
        $this->load->model('Post_model', '', true);
        $posts = $this->Post_model->get_entries(
            array(
                'per_page'			=>	$per_page,
                'article_per_page'	=>	$article_per_page,
                'c'					=>	$c,
                'k'					=>	$k,
                'q'					=>	$q
            )
        );
        
        if(empty($posts) == false && $posts['total'] >= 1)
        {
            foreach($posts['row'] as $post)
            {
                $related_data = GET_RELATED_DATA($post->idx);

                if(empty($related_data['category_links']) == false)
                {
                    $post->categorys = array();
                    foreach($related_data['category_links'] as $category_links){
                        array_push($post->categorys, $category_links);
                    }
                }
                if(empty($related_data['keyword_links']) == false)
                {
                    $post->keywords = array();
                    foreach($related_data['keyword_links'] as $keyword_links){
                        array_push($post->keywords, $keyword_links);
                    }
                }

                $post->view_count = $related_data['view_count'];
                $post->reply_count = $related_data['reply_count'];
            }
        }
        
        $response = array(
	        'common_param'		=>	$common_param,
	        'data'				=>	$posts
        );
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
*/
	}
	
	/**
	 @method	register
	 @desc		포스트 등록 폼
	*/
	function register()
	{
		// header에 추가할 데이터
		$header_data = array("css" => array("/assets/css/fileinput.css",
											"/assets/css/plugins/dropzone/basic.css")
		);
		
		// footer에 추가되는 데이터
		$footer_data = array('js' => array(	"/assets/js/form.post.js",
											"/assets/js/fileinput.js",
											"/assets/emJs/lib/iCheck/iCheck.js",
											"/assets/emJs/lib/iCheck/icheck.min.js")
		
		);
		
		$this->load->helper('permission');
//		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$this->load->model('user_model', '', true);
		$user = $this->user_model->get_entrie($user_idx);

		$this->load->model('category_model', '', true);
		$categorys = $this->category_model->get_entries();
		
		$data = array();
		$data['categorys'] = $categorys;
		$data['user'] = $user;

        $this->load->view(VIEW_PAGE.'_front_header_em', $header_data);
		$this->load->view(VIEW_PAGE.'front_post_register_em', $data);
        $this->load->view(VIEW_PAGE.'_front_footer_em', $footer_data);
	
	}
	
	/**
	 @method	modify
	 @desc		포스트 수정 폼
	*/
	function modify()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		if(empty($this->uri->segments[3])){
			$this->load->helper('alert');
			alert('해당 게시글 정보를 확인할 수 없습니다.');
		}
		
		$article_idx = $this->uri->segments[3];
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$this->load->model('post_model', '', true);
		$post = $this->post_model->get_entrie($article_idx);
		
		if($user_idx!==$post[0]->user_idx){
			$this->load->helper('alert');
			alert('잘못된 접근입니다.');
		}
		
		$this->load->model('user_model', '', true);
		$user = $this->user_model->get_entrie($user_idx);
		
		$this->load->model('category_model', '', true);
		$categorys = $this->category_model->get_entries();

		
		$data = array();
		$data['post'] = $post;
		$data['user'] = $user;
		$data['categorys'] = $categorys;

        $this->load->view(VIEW_PAGE.'_front_header');
        $this->load->view(VIEW_PAGE.'front_post_modify', $data);
        $this->load->view(VIEW_PAGE.'_front_footer');
	}
	
	/**
	 @method	input
	 @desc		포스트 등록 처리
	*/
	function input()
	{
		
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);

		$contents = POST_PARAM('contents', '');
		$keyword = POST_PARAM('keyword', '');
		$category = POST_PARAM('category', ''); 
		
		$required_fields = array('keyword', 'category');
		$empty_count = 0;
		foreach($required_fields as $required_field){
			if(empty(${$required_field})) $empty_count++;
		}
		if($empty_count > 0){
			$this->load->helper('alert');
			alert($empty_count.' 개의 필수항목이 누락되었습니다.');
		}		
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');

		$this->load->model('post_model', '', true);
		$param = array(
			'photo' => '',
			'photo_t' => '',
			'contents' => $contents,
			'user_idx' => $user_idx
		);
		
		$idx = $this->post_model->insert_entry($param);
		
		
		if($idx){

			//키워드 처리
			if(empty($keyword) == false){
				$this->load->model('keyword_model', '', true);
				$keywords = explode(',', $keyword);
				foreach($keywords as $keyword){
					$keyword_idx = $this->keyword_model->check_entrie($keyword);
					$this->keyword_model->insert_ak_entry($idx, $keyword_idx);
				}
			}

			
			//카테고리 처리
			if(empty($category) == false){
				$this->load->model('category_model', '', true);
				foreach($category as $category_idx){
					$this->category_model->insert_ac_entry($idx, $category_idx);
				}
			}
			
			//첨부파일 처리
			if(empty($_FILES['photo']['tmp_name']) == false){
				$this->load->helper('file');
				$file_save_path = DOT.POST_UPFILE_PATH.DS.$user_idx;
				check_dir($file_save_path);

				$config['upload_path'] = $file_save_path;
				$config['allowed_types'] = 'png|jpg|jpeg|gif';
				$config['max_size']	= '102400';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('photo')){
					$data = array('upload_data' => $this->upload->data());
					$upload_file_name = $data['upload_data']['file_name'];
					$save_file_name = uniqid().'.'.substr(strrchr($upload_file_name, "."), 1);
					@rename ($file_save_path.'/'.$upload_file_name, $file_save_path.'/'.$save_file_name);

					$ong_file_name = make_thumbnail($file_save_path, $save_file_name, MAX_POST_ONG_IMG_W, MAX_POST_ONG_IMG_H, true, '', true);
					$tn_file_name = make_thumbnail($file_save_path, $ong_file_name, MAX_POST_TN_IMG_W, MAX_POST_TN_IMG_H);
					$param = array(
						'photo' => $ong_file_name,
						'photo_t' => $tn_file_name,
						'post_idx' => $idx,
					);
					$rs = $this->post_model->update_photo($param);
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
	 @method	update
	 @desc		포스트 수정 처리
	*/
	function update()
	{
		$this->load->helper('permission');
		check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		
		if(empty($this->uri->segments[3])){
			$this->load->helper('alert');
			alert('해당 게시글 정보를 확인할 수 없습니다.');
		}
		
		$contents = POST_PARAM('contents', '');
		$keyword = POST_PARAM('keyword', '');
		$category = POST_PARAM('category', '');
		
		$article_idx = $this->uri->segments[3];
		
		$this->load->library('session');
		$user_idx = $this->session->userdata('user_idx');
		
		$this->load->model('post_model', '', true);
		$post = $this->post_model->get_entrie($article_idx);
		
		if(empty($user_idx) | $user_idx!=$post[0]->user_idx){
			$this->load->helper('alert');
			alert('게시글을 수정 하실 수 없습니다.');
		}
		
		if($article_idx==$post[0]->idx){
			$param = array(
				'contents' => $contents,
				'article_idx' => $article_idx
			);
			$idx = $this->post_model->update_entry($param);
			
			if($idx){
				//키워드 처리
				if(empty($keyword) == false){
					$this->load->model('keyword_model', '', true);
					$keywords = explode(',', $keyword);
					foreach($keywords as $keyword){
						$keyword_idx = $this->keyword_model->check_entrie($keyword);
						$ak_links = $this->keyword_model->get_ak_entry($idx);
					}
					$tmp_keywords= array();
					foreach($ak_links as $ak_link){
						//기존 링크에는 있고 새로들어온 키워드에는 없다면 해당 링크삭제
						$ak_old_check = false;
						if(in_array($ak_link->keyword_name, $keywords)){
							$ak_old_check = true;
						}
						if($ak_old_check==false){
							$this->keyword_model->delete_ak_entry($ak_link->article_idx, $ak_link->keyword_idx);
						}
						array_push($tmp_keywords, $ak_link->keyword_name);
						
					}
					foreach($keywords as $keyword){
						//기존 링크에는 없고 새로들어온 키워드에는 있다면 해당 링크 추가
						$ak_new_check = false;
						if(in_array($keyword, $tmp_keywords)){
							$ak_new_check = true;
						}
						if($ak_new_check==false){
							$keyword_idx = $this->keyword_model->check_entrie($keyword);
							$this->keyword_model->insert_ak_entry($idx, $keyword_idx);
						}
					}
				}
	
				
				//카테고리 처리
				if(empty($category) == false){
					$this->load->model('category_model', '', true);
					foreach($category as $category_idx){
						$ac_links = $this->category_model->get_ac_entry($idx, $category_idx);
					}
					$tmp_categorys = array();
					foreach($ac_links as $ac_link){
						$ac_old_check = false;
						if(in_array($ac_link->category_idx, $category)){
							$ac_old_check = true;
						}
						if($ac_old_check==false){
							$this->category_model->delete_ac_entry($idx, $ac_link->category_idx);
						}
						array_push($tmp_categorys, $ac_link->category_idx);
					}
					foreach($category as $category_idx){
						$ac_new_check = false;
						if(in_array($category_idx, $tmp_categorys)){
							$ac_new_check = true;
						}
						if($ac_new_check==false){
							$this->category_model->insert_ac_entry($idx, $category_idx);
						}
					}
				}
			
				//첨부파일 처리
				if(empty($_FILES['photo']['tmp_name']) == false){
					$this->load->helper('file');
					$file_save_path = DOT.POST_UPFILE_PATH.DS.$user_idx;
					check_dir($file_save_path);
	
					$config['upload_path'] = $file_save_path;
					$config['allowed_types'] = 'png|jpg|jpeg|gif';
					$config['max_size']	= '102400';
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('photo')){
						$data = array('upload_data' => $this->upload->data());
						$upload_file_name = $data['upload_data']['file_name'];
						$save_file_name = uniqid().'.'.substr(strrchr($upload_file_name, "."), 1);
						@rename ($file_save_path.'/'.$upload_file_name, $file_save_path.'/'.$save_file_name);
	
						$ong_file_name = make_thumbnail($file_save_path, $save_file_name, MAX_POST_ONG_IMG_W, MAX_POST_ONG_IMG_H, true, '', true);
						$tn_file_name = make_thumbnail($file_save_path, $ong_file_name, MAX_POST_TN_IMG_W, MAX_POST_TN_IMG_H);
						$param = array(
							'photo' => $ong_file_name,
							'photo_t' => $tn_file_name,
							'post_idx' => $idx,
						);
						$rs = $this->post_model->update_photo($param);
						//기존 사진파일 삭제
						if(file_exists($file_save_path.DS.$post[0]->photo)) @unlink($file_save_path.DS.$post[0]->photo);
						if(file_exists($file_save_path.DS.$post[0]->photo_t)) @unlink($file_save_path.DS.$post[0]->photo_t);
					}
				}
			}
			
			$this->load->helper('url');
			redirect($this->config->item('base_url').'/post?&info='.$idx);
			
		} else {
			$this->load->helper('alert');
			alert('저장에 실패하였습니다.');
		}		
/*
		print_gpf();
		exit;
*/
		/*
		처리 순서
		
		1. 기존 게시물 정보 가져옴
		2. 본인이 작성한 게시물인지 확인 (user_idx) 비교
		3. 게시물 정보 업데이트
		4. 기존 키워드 정보 가져옴
			- 기존 키워드에는 있으나 수정된 키워드에는 없을경우 link 정보 삭제
			- 기존 키워드에는 없으나 수정된 키워드에는 있을경우 link 정보 추가
		5. 기존 카테고리 정보 가져옴
			- 기존 카테고리에는 있으나 수정된 카테고리에는 없을경우 link 정보 삭제
			- 기존 카테고리에는 없으나 수정된 카테고리에는 있을경우 link 정보 추가
		6. 첨부파일 처리
			- 새로 첨부된 파일이 있을경우 업로드 및 사진정보 업데이트 처리
			- 기존 첨부파일 삭제
		7. 페이지로 이동.
		*/	
	}
	
	/**
	 @method	check_update
	 @desc		포스트 수정 체크
	*/
	function check_update()
	{	
		
		$old_post = POST_PARAM('old_post');
		
		$result = array(
			'response' => array(
				'code' => 'success', 
				'info' => $old_post
			)
		);
		
		echo json_encode($result);
		exit;
		
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
			$this->load->model('rc_history_medel', '', true);
			$already_entrie = $this->rc_history_medel->get_already_entrie($user_idx, $post_idx);
			
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
				
				$rc_idx = $this->rc_history_medel->insert_entry($param);
				
				if($rc_idx){
	
					$this->load->model('post_model', '', true);
					$post = $this->post_model->get_entrie($post_idx);
					
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
	}
}

