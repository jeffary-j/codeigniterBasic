<?php
class Category_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

 

    function get_entries()
    {
 		$prepare = array();
    	
		$sql = '
		SELECT
			idx,
			name,
			sort
		FROM
			tt_post_category
		ORDER BY
			idx ASC
		';
		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res->result();
	}
	
	function get_ac_entry($article_idx)
    {
 		$prepare = array();

/*
SELECT
	article.*
FROM
	TT_POST_ARTICLE article,
	tt_post_ac_link article_link,
	tt_post_category category
WHERE
	article.idx=article_link.article_idx AND
	category.idx=article_link.category_idx AND
	category.name='이레즈미'
*/


/*
    SELECT
    	article.*
    FROM
    	TT_POST_ARTICLE article,
		tt_post_ak_link ak_link,
		TT_POST_KEYWROD keyword
    WHERE
    	article.idx=ak_link.article_idx AND
    	keyword.idx=ak_link.keyword_idx AND
    	keyword.keyword='담배'
*/

		$sql = '
		SELECT
			ac_link.article_idx,
			ac_link.category_idx,
			
			category.name AS category_name,
			category.sort AS category_sort,
			(SELECT count(a.category_idx) FROM tt_post_ac_link a WHERE a.category_idx = ac_link.category_idx) AS category_cnt
		FROM
			tt_post_ac_link ac_link, tt_post_category category
		WHERE 
			ac_link.category_idx=category.idx AND 
			ac_link.article_idx=?
		';
		$res = $this->db->query(
			$sql,
			array($article_idx)
		);
		return $res->result();
	}
	
    function insert_ac_entry($article_idx, $category_idx)
    {
		$sql = '
		INSERT INTO tt_post_ac_link (
			article_idx,
			category_idx
		)
		VALUES (
			?,
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$article_idx,
				$category_idx
			)
		);
		return $res;
    }
    
    
    


    function insert_entry($param)
    {
		$sql = '
		INSERT INTO  tt_post_category (
			idx,
			subject,
			contents,
			sort,
			ip_addr,
			user_idx,
			bbs_idx
		)
		VALUES (
			NULL ,
			?,
			?,
			?,
			?,
			?,
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$param['subject'],
				$param['contents'],
				$param['sort'],
				$param['ip_addr'],
				$param['user_idx'],
				$param['bbs_idx']
			)
		);
		$article_idx = null;
		if($res){
			$article_idx = $this->db->insert_id();
		}
		return $article_idx;
    }

    function update_entry($param)
    {
		$prepare = array();
		array_push($prepare, $param['subject']);
		array_push($prepare, $param['contents']);
		array_push($prepare, $param['sort']);
		array_push($prepare, $param['status']);
		array_push($prepare, $param['article_idx']);

		$sql = '
		UPDATE  tt_post_category  SET
			subject=?,
			contents=?,
			sort=?,
			lastest_update=NOW(),
			status=?
		WHERE
			idx=? LIMIT 1

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
		UPDATE  tt_post_category  SET
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
		UPDATE  tt_post_category  SET
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
		UPDATE  tt_post_category  SET
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
		UPDATE  tt_post_category  SET
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
		UPDATE  tt_post_category  SET
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

    function delete_ac_entry($article_idx, $category_idx)
    {
		$sql = '
		DELETE FROM  tt_post_ac_link
		WHERE
			article_idx=? AND
			category_idx=?
		LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($article_idx, $category_idx)
		);
		return $res;
    }
}
?>