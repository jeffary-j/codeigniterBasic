<?php
class Comment_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_entrie($comment_idx)
    {
		$sql = '
		SELECT
			idx,
			contents,
			reg_date,
			user_idx,
			article_idx
		FROM
			tt_post_comment
		WHERE
			idx=?
		';
		$res = $this->db->query(
			$sql,
			array($comment_idx)
		);
		return $res->result();
    }


    function get_group_entries($article_idx)
    {

 		$prepare = array();
    	array_push($prepare, $article_idx);

		//row
		$sql = '
		SELECT
			cmt.idx,
			cmt.contents,
			cmt.reg_date,
			cmt.user_idx,
			cmt.article_idx,
			
			user.nick AS user_nick,
			user.type AS user_type,
			user.profile_image AS user_pf
		FROM
			tt_post_comment cmt, tt_user user
		WHERE
			cmt.user_idx=user.idx AND
			cmt.status IN(\'A\') AND
			cmt.article_idx=?
		ORDER BY
			cmt.idx ASC
		';
		$res = $this->db->query(
			$sql,
			$prepare
		);
		$row = $res->result();
		return array('total'=>count($row), 'row'=>$row);
    }

    function insert_entry($param)
    {
		$sql = '
		INSERT INTO tt_post_comment (
			idx,
			contents,
			user_idx,
			article_idx
		)
		VALUES (
			NULL ,
			?,
			?,
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$param['contents'],
				$param['user_idx'],
				$param['article_idx']
			)
		);
		$comment_idx = null;
		if($res){
			$comment_idx = $this->db->insert_id();
		}
		return $comment_idx;
    }

    function update_entry($param)
    {
		$prepare = array();
		$sql = '
		UPDATE  tt_post_comment  SET
			contents=?
		WHERE
			idx=?
		LIMIT
			1
		';

		$res = $this->db->query(
			$sql,
			array($param['contents'], $param['comment_idx'])
		);
		return $res;
    }

    function update_status($comment_idx, $status)
    {
		$prepare = array();
		$sql = '
		UPDATE  tt_post_comment  SET
			status=?
		WHERE
			idx=?
		';

		$res = $this->db->query(
			$sql,
			array($status, $comment_idx)
		);
		return $res;
    }

    function update_group_sort($order_group, $order_sort)
    {
		$prepare = array();
		array_push($prepare, $order_group);
		array_push($prepare, $order_sort);

		$sql = '
		UPDATE  tt_post_comment  SET
			order_sort=order_sort+1
		WHERE
			order_group=? AND
			order_sort>?

		';

		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res;
    }
    
    
    function update_count($comment_idx, $field, $rev=false)
    {
    	$sign = ($rev == true) ? '-' : '+';
    	
		$sql = '
		UPDATE  tt_post_comment  SET
			'.$field.'='.$field.$sign.'+1
		WHERE
			idx=? LIMIT 1

		';
		$res = $this->db->query(
			$sql,
			array($comment_idx)
		);
		return $res;
    }    
}
?>