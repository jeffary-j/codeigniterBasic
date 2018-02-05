<?php
class Test_model extends CI_Model {

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
			regdate
		FROM
			test_table
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
		INSERT INTO  test_table (
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
}
?>