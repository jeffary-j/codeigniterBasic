<?
/**
 @file		extract_num_helper.php
 @desc		
 @author	dodars <dodars@hotmail.com>
 @data		2005-07-22
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  ExtractLotteryNum {
	var $ext_cnt;
	var $haystacks;
	var $haystacks_cnt;
	var $ext_results;
	var $tmp_arr;
	
	function initialize($ext_cnt, $haystacks){
		$this->ext_cnt = $ext_cnt;
		$this->haystacks = $haystacks;
		$this->haystacks_cnt = count($this->haystacks);
		$this->ext_results = array();
		$this->tmp_arr = array();
	}
	
	function nextBallNums($index, $n_depth){
		$this->tmp_arr[$n_depth] = $this->haystacks[$index];
		if( $n_depth < 1 ){
			$this->ext_results[] = $this->tmp_arr;
			return;
		}
		for( $i = $index + 1 ; $i < $this->haystacks_cnt ; $i++ ){
			$this->nextBallNums($i, $n_depth - 1);
		}
	}	
	
	function getExtractNum(){
		for( $i = 0 ; $i < $this->haystacks_cnt ; $i++ ){
			$this->nextBallNums($i, $this->ext_cnt - 1);
		}
		return $this->ext_results;
	}
}
?>