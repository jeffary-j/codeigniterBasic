<?php
class User_model extends CI_Model {

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
			tt_user
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
	
	function get_entrie_login($email, $login_pw)
    {
		$sql = '
		SELECT
			idx,
			type,
			email,
			login_pw,
			nick,
			profile_image,
			profile_text,
			regdate,
			status
		FROM
			tt_user
		WHERE
			email=? AND
			login_pw=password(?) AND
			status=\'A\'

		';
		$res = $this->db->query(
			$sql,
			array($email, $login_pw)
		);
		return $res->result();
    }
  
	function get_check_entrie($str, $field)
    {


		$sql = '
		SELECT
			idx
		FROM
			tt_user
		WHERE
			'.$field.'=?
		';
		$res = $this->db->query(
			$sql,
			array($str)
		);
		return $res->result();
    }
	

	function get_entrie($user_idx)
    {
 		$prepare = array();
 		array_push($prepare, $user_idx);
    	
		$sql = '
		SELECT
			idx,
			type,
			email,
			nick,
			profile_image,
			profile_text,
			regdate,
			status
		FROM
			tt_user
		WHERE
			idx=?
		';
		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res->result();
	}
	
    function get_test_entries($param)
    {

 		$prepare = array();

 		

		//row
		$sql = '
		SELECT
			idx,
			subject,
			regdate
		FROM
			tt_user
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
			tt_user
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
		INSERT INTO tt_user (
			idx,
			type,
			email,
			login_pw,
			nick
		)
		VALUES (
			NULL ,
			?,
			?,
			password(?),
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$param['type'],
				$param['email'],
				$param['login_pw'],
				$param['nick']
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
		array_push($prepare, $param['subject']);
		array_push($prepare, $param['contents']);
		array_push($prepare, $param['sort']);
		array_push($prepare, $param['status']);
		array_push($prepare, $param['article_idx']);

		$sql = '
		UPDATE  tt_user  SET
			subject=?,
			contents=?,
			sort=?,
			lastest_update=NOW(),
			status=?
		WHERE
			idx=?
		LIMIT
			1
		';

		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res;
    }
	
	function update_profile($param)
    {
		$prepare = array();
		array_push($prepare, $param['profile_image']);
		array_push($prepare, $param['user_idx']);

		$sql = '
		UPDATE  tt_user  SET
			profile_image=?
		WHERE
			idx=? 
		LIMIT
			1
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
		UPDATE  tt_user  SET
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
		UPDATE  tt_user  SET
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
		UPDATE  tt_user  SET
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
		UPDATE  tt_user  SET
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
		UPDATE  tt_user  SET
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
		DELETE FROM  tt_user
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