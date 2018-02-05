<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:24
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class FrontgateEm extends CI_Controller {

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
        $this->article_per_page = 20;

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
		// header에 추가할 데이터
		$header_data = array("css" => array("/assets/emJs/main.css")
		);
		
		// footer에 추가되는 데이터
		$footer_data = array('js' => array(	"/assets/emJs/imagesloaded.pkgd.min.js",
											"/assets/emJs/masonry.pkgd.min.js",
											"/assets/emJs/jquery.colorbox-min.js",
											"/assets/emJs/main.js")
		
		);
		
		
	    $this->load->helper('log');
		guest_login_log();

        $this->load->model('Category_model', '', true);
        $categorys = $this->Category_model->get_entries();
		
		$categoryHome = new stdClass;
		
		$categoryHome->idx = "";
		$categoryHome->name = "전체보기";
		$categoryHome->sort = 0;
		
		array_unshift($categorys, $categoryHome);
		
        $this->load->library('session');
        $user_idx = $this->session->userdata('user_idx');
		
		$header_data['categorys']	= $categorys;
		$header_datanav['c']	= $this->c;
		$header_data['k']	= $this->k;

        if(!empty($user_idx)){

            $this->load->model('User_model', '', true);
            $user = $this->User_model->get_entrie($user_idx);

            $header_data['user'] = $user;
        }
        
        $data = array();
        $data['page'] = $this->per_page;
       
        $this->load->view(VIEW_PAGE.'_front_header_em', $header_data);
        $this->load->view(VIEW_PAGE.'front_gate_index_em', $data);
        $this->load->view(VIEW_PAGE.'_front_footer_em', $footer_data);

		//post값넘어가는거 삭제
    }
    
    public function emData() {
	    
	    $code = '00';
	    
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
        
        if(!empty($posts) && $posts['total'] > 0)
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
        } else {
	        $code = '01';
        }
	   
		$result = array();
		
		$result['code'] 		= $code;
		$result['gallery'] 		= $posts;
	    $result['common_param']	= $this->common_param;
	    
	    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));

    }
    
}
