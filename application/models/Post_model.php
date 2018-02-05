<?php
class Post_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

 
    function get_top_entrie($bbs_idx = null)
    {
    	$prepare = array();
    	if(!empty($bbs_idx)){
	    	$bbs_idx_sql = ' AND at.bbs_idx=? ';
	    	array_push($prepare, $bbs_idx);
    	} else {
	    	$bbs_idx_sql = '';
    	}

		$sql = '
		SELECT
			idx,
			subject,
			reg_date
		FROM
			tt_post_article
		WHERE
			1
		ORDER BY
			idx DESC
			LIMIT
			1
		';
		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res->result();
    }
	
	function get_entrie($article_idx)
    {
    	$prepare = array();

		$sql = '
		SELECT
			article.idx,
			article.photo,
			article.love,
			article.contents,
			article.reg_date,
			article.user_idx,
			
			user.idx AS user_idx,
			user.nick AS user_nick,
			user.profile_image AS user_profile,
			user.profile_text AS user_info
		FROM
			tt_post_article article, tt_user user
		WHERE
			article.user_idx=user.idx AND
			article.idx=?
		ORDER BY
			article.idx DESC
		LIMIT
			1
		';
		$res = $this->db->query(
			$sql,
			array($article_idx)
		);
		return $res->result();
    }
	
	function get_hit_entrie($article_idx)
    {
    	$prepare = array();

		$sql = '
		SELECT
			idx,
			hit
		FROM
			tt_post_article
		WHERE
			idx=?
		LIMIT
			1
		';
		$res = $this->db->query(
			$sql,
			array($article_idx)
		);
		return $res->result();
    }
	
	//검색 포함 후
	function get_entries($param)
    {
		$prepare = array();
		
		$from = 'FROM tt_post_article article, tt_user user';
    	$where = ' WHERE article.user_idx=user.idx ';
	 	
	 	if(empty($param['c']) == false){
		 	$from .= ', tt_post_ac_link ac_link';
		 	$where .= ' AND article.idx=ac_link.article_idx AND ac_link.category_idx='.$param['c'];
	 	}
		
		if(empty($param['k']) == false){
			$from .= ', tt_post_ak_link ak_link, tt_post_keyword keyword';
		 	$where .= ' AND article.idx=ak_link.article_idx AND ak_link.keyword_idx=keyword.idx AND keyword.keyword = ?';
		 	$param['k'] = ''.$param['k'].'';
			array_push($prepare, $param['k']);
		}
		
		if(!empty($param['q'])){
			$where .= ' AND contents like ? ';
			$param['q'] = '%'.$param['q'].'%';
			array_push($prepare, $param['q']);
		}

		//row
		$sql = '
		SELECT
			article.idx,
			article.photo,
			article.photo_t,
			article.love,
			article.contents,
			article.reg_date,
			article.user_idx,
			
			user.nick AS user_nick
		'.$from.'
		'.$where.'
		ORDER BY
			idx DESC
		LIMIT
			? , ?
		';
		array_push($prepare, (int)$param['per_page'], (int)$param['article_per_page']);
		$res = $this->db->query(
			$sql,
			$prepare
		);
		$row = $res->result();

		//total
		$sql = '
		SELECT
			COUNT(article.idx) AS total
		'.$from.'
		'.$where.'
		';
		array_pop($prepare);
		array_pop($prepare);
		$res = $this->db->query(
			$sql,
			$prepare
		);
		$total_row = $res->result();
		$total = $total_row[0]->total;

		return array('total'=>$total, 'row'=>$row);
    }
	
/*
	//검색 전
    function get_entries($param)
    {
		$prepare = array();

    	$where = ' WHERE post_article.user_idx=user.idx ';
	 		 	
		if(!empty($param['w']) && !empty($param['q'])){
			$where .= ' AND '.$param['w'].' like ? ';
			$param['q'] = '%'.$param['q'].'%';
			array_push($prepare, $param['q']);
		}

		//row
		$sql = '
		SELECT
			post_article.idx,
			post_article.photo,
			post_article.photo_t,
			post_article.love,
			post_article.contents,
			post_article.reg_date,
			post_article.user_idx,
			user.nick AS user_nick
		FROM
			tt_post_article post_article, tt_user user
		'.$where.'
		ORDER BY
			idx DESC
		LIMIT
			? , ?
		';
		array_push($prepare, (int)$param['per_page'], (int)$param['article_per_page']);
		$res = $this->db->query(
			$sql,
			$prepare
		);
		$row = $res->result();

		//total
		$sql = '
		SELECT
			COUNT(post_article.idx) AS total
		FROM
			tt_post_article post_article, tt_user user
		'.$where.'
		';
		array_pop($prepare);
		array_pop($prepare);
		$res = $this->db->query(
			$sql,
			$prepare
		);
		$total_row = $res->result();
		$total = $total_row[0]->total;

		return array('total'=>$total, 'row'=>$row);
    }
*/
	
	
    function insert_entry($param)
    {
		$sql = '
		INSERT INTO tt_post_article (
			idx,
			photo,
			photo_t,
			contents,
			user_idx
		)
		VALUES (
			NULL,
			?,
			?,
			?,
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$param['photo'],
				$param['photo_t'],
				$param['contents'],
				$param['user_idx']
			)
		);
		$idx = null;
		if($res){
			$idx = $this->db->insert_id();
		}
		return $idx;
    }

    function update_entry($param)
    {
		$prepare = array(); 		
		array_push($prepare, $param['contents']);
		array_push($prepare, $param['article_idx']);
/*
		array_push($prepare, $param['subject']);
		array_push($prepare, $param['sort']);
		array_push($prepare, $param['status']);
		
		subject=?,
		sort=?,
		status=?
*/

		$sql = '
		UPDATE  tt_post_article  SET
			contents=?,
			lastest_update=NOW()
		WHERE
			idx=? LIMIT 1

		';

		$res = $this->db->query(
			$sql,
			$prepare
		);
		if($res){
			$idx = $param['article_idx'];
		}
		return $idx;
    }


    function update_photo($param)
    {
		$prepare = array();
		array_push($prepare, $param['photo']);
		array_push($prepare, $param['photo_t']);
		array_push($prepare, $param['post_idx']);

		$sql = '
		UPDATE  tt_post_article  SET
			photo=?,
			photo_t=?
		WHERE
			idx=? 
		LIMIT 1
		';

		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res;
    }

    function update_contents($article_idx, $contents)
    {
		$sql = '
		UPDATE  tt_post_article  SET
			contents=?
		WHERE
			idx=? LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($contents, $article_idx)
		);
		return $res;
    }
    
    function update_status($article_idx, $status)
    {
		$sql = '
		UPDATE  tt_post_article  SET
			status=?
		WHERE
			idx=? LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($status, $article_idx)
		);
		return $res;
    }
    
    function update_bbs_idx($article_idx, $bbs_idx)
    {
		$sql = '
		UPDATE  tt_post_article  SET
			bbs_idx=?
		WHERE
			idx=? LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($bbs_idx, $article_idx)
		);
		return $res;
    }

    function update_image_cnt($article_idx, $image_cnt)
    {
		$sql = '
		UPDATE  tt_post_article  SET
			image_cnt=?
		WHERE
			idx=? LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($image_cnt, $article_idx)
		);
		return $res;
    }

    function update_count($article_idx, $field, $rev=false)
    {
    	$sign = ($rev == true) ? '-' : '+';
    	
		$sql = '
		UPDATE  tt_post_article  SET
			'.$field.'='.$field.$sign.'+1
		WHERE
			idx=? LIMIT 1

		';
		$res = $this->db->query(
			$sql,
			array($article_idx)
		);
		return $res;
    }

    function delete_entry($article_idx)
    {
		$sql = '
		DELETE FROM  tt_post_article
		WHERE
			idx=?
		LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($article_idx)
		);
		return $res;
    }
}
?>