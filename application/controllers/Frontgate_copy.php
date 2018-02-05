<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:24
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Frontgate_copy extends CI_Controller {

    var $w_types; //검색항목
    var $w_type;
    var $per_page;
    var $article_per_page;
    var $w;
    var $q;

    var $common_param;

    public function __construct(){
        parent::__construct();

        //$this 키워드는 클래스 자신
        /*
                $this->w_types 	= array(
                    'category' 	=> array('카테고리' ,'category'),
                    'keyword ' 	=> array('키워드'	,'keyword')
                );
        */

        $this->per_page = GET_PARAM('per_page', 0);
        $this->article_per_page = 12;

        $this->c = GET_PARAM('c', '');
        $this->k = GET_PARAM('k', '');
        $this->q = GET_PARAM('q', '');

        $common_params = array();
        array_push($common_params, 'c='.$this->c);
        array_push($common_params, 'k='.$this->k);
        array_push($common_params, 'q='.$this->q);
        array_push($common_params, 'per_page='.$this->per_page);
        $this->common_param = implode('&', $common_params);

/*
		if(empty($this->c) == false && empty($this->k)){
			$this->load->helper('alert');
			alert('승인되지 않은 검색조건 입니다.');
        }
*/
/*
		if(empty($this->c) == false || empty($this->k) == false){
			$this->load->helper('permission');
			check_user_type(USER_TYPE_MEMBER | USER_TYPE_ARTIST | USER_TYPE_ADMIN);
		}
*/
    }


    public function index()
    {

	    $this->inflow_ctr();
	    
        $this->load->model('Post_model', '', true);
        $posts = $this->Post_model->get_entries(
            array(
                'per_page'=>$this->per_page,
                'article_per_page'=>$this->article_per_page,
                'c'=>$this->c,
                'k'=>$this->k,
                'q'=>$this->q
            )
        );

        $this->load->library('pagination');
        $config['base_url'] = '/?'
            .'c='.$this->c
            .'&k='.$this->k
            .'&q='.$this->q
        ;
        $config['total_rows'] = $posts['total'];
        $config['per_page'] = $this->article_per_page;
        $config['page_query_string'] = true;
        $config['num_links'] = 5;
        $config['cur_tag_open'] = '&nbsp;&nbsp;<strong>';
        $config['cur_tag_close'] = '</strong>&nbsp;&nbsp;';
        $config['next_tag_open'] = '&nbsp;&nbsp;';
        $config['next_tag_close'] = '&nbsp;&nbsp;';
        $config['prev_tag_open'] = '&nbsp;&nbsp;';
        $config['prev_tag_close'] = '&nbsp;&nbsp;';
        $config['num_tag_open'] = '&nbsp;&nbsp;';
        $config['num_tag_close'] = '&nbsp;&nbsp;';

        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        $this->load->model('Category_model', '', true);
        $categorys = $this->Category_model->get_entries();
		
		$categoryHome = new stdClass;
		
		$categoryHome->idx = "";
		$categoryHome->name = "전체보기";
		$categoryHome->sort = 0;
		
		array_unshift($categorys, $categoryHome);
		
        $this->load->library('session');
        $user_idx = $this->session->userdata('user_idx');

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

		$nav = array(
			'categorys'	=> $categorys
		);
        $data = array(
	        'posts'			=> $posts,
	        'c'				=> $this->c,
	        'k'				=> $this->k,
	        'common_param'	=> $this->common_param,
	        'pagination'	=> $pagination
        );

        if(!empty($user_idx)){

            $this->load->model('User_model', '', true);
            $user = $this->User_model->get_entrie($user_idx);

            $data['user'] = $user;
        }

        $this->load->view(VIEW_PAGE.'_front_header', $nav);
        $this->load->view(VIEW_PAGE.'front_gate_index', $data);
        $this->load->view(VIEW_PAGE.'_front_footer');

		//post값넘어가는거 삭제
    }


    public function inflow_ctr()
    {
		$this->load->helper('log');
		guest_login_log();	
		
		//나중에 ip차단이나 특정접속자 제한등... 여기서 걸자...
    }
}