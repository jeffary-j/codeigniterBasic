<?php
class Rc_history_medel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_already_entrie($user_idx, $article_idx)
    {
    	$prepare = array();
    	array_push($prepare, $user_idx);
    	array_push($prepare, $article_idx);

		$sql = '
		SELECT
			idx
		FROM
			tt_post_loveit
		WHERE
			user_idx=? AND article_idx=?
		';
		$res = $this->db->query(
			$sql,
			$prepare
		);
		return $res->result();
    }
   
    
        

    function insert_entry($param)
    {
		$sql = '
		INSERT INTO tt_post_loveit (
			idx,
			user_idx,
			article_idx
		)
		VALUES (
			NULL,
			?,
			?
		);
		';
		$res = $this->db->query(
			$sql,
			array(
				$param['user_idx'],
				$param['article_idx']
			)
		);
		$rc_idx = null;
		if($res){
			$rc_idx = $this->db->insert_id();
		}
		return $rc_idx;
    }
    
  
}
?>