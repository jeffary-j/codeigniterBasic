<?php
class Keyword_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

 
    function check_entrie($keyword)
    {
		$sql = '
		SELECT
			idx
		FROM
			tt_post_keyword
		WHERE
			keyword=?
		';
		$res = $this->db->query(
			$sql,
			array($keyword)
		);
		$rs = $res->result();
		$keyword_idx = 0;
		if(empty($rs[0]->idx) == false){
			$keyword_idx = $rs[0]->idx;
		} else {
			$keyword_idx = $this->insert_entry(array('keyword' => $keyword));
		}
		return $keyword_idx;
    }

    function get_entries($param)
    {

 		$prepare = array();

 		

		//row
		$sql = '
		SELECT
			idx,
			subject,
			regdate
		FROM
			test_table
		WHERE
			1
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
			COUNT(idx) AS total
		FROM
			test_table
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
    
    
    

    function insert_entry($param)
    {
		$sql = '
		INSERT INTO tt_post_keyword (
			idx,
			keyword
		)
		VALUES (
			NULL ,
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$param['keyword']
			)
		);
		$keyword_idx = null;
		if($res){
			$keyword_idx = $this->db->insert_id();
		}
		return $keyword_idx;
    }

	function get_ak_entry($article_idx)
    {
 		$prepare = array();


		$sql = '
		SELECT
			ak_link.article_idx,
			ak_link.keyword_idx,
			
			keyword.keyword AS keyword_name,
			keyword.sort AS keyword_sort
		FROM
			tt_post_ak_link ak_link, tt_post_keyword keyword
		WHERE 
			ak_link.keyword_idx=keyword.idx AND 
			ak_link.article_idx=?
		';
		$res = $this->db->query(
			$sql,
			array($article_idx)
		);
		return $res->result();
	}

    function insert_ak_entry($article_idx, $keyword_idx)
    {
		$sql = '
		INSERT INTO tt_post_ak_link (
			article_idx,
			keyword_idx
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
				$keyword_idx
			)
		);
		return $res;
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
		UPDATE  test_table  SET
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
		UPDATE  test_table  SET
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
		UPDATE  test_table  SET
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
		UPDATE  test_table  SET
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
		UPDATE  test_table  SET
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
		UPDATE  test_table  SET
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
		DELETE FROM  test_table
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
    
    function delete_ak_entry($article_idx, $keyword_idx)
    {
		$sql = '
		DELETE FROM tt_post_ak_link
		WHERE
			article_idx=? AND
			keyword_idx=?
		LIMIT 1
		';
		$res = $this->db->query(
			$sql,
			array($article_idx, $keyword_idx)
		);
		return $res;
    }
}
?>