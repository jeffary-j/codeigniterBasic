<?
/**
 @file		paging_helper.php
 @desc		페이징
 @author	dodars <dodars@hotmail.com>
 @data		2005-07-22
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PagingHelper{
	private $page;
	private $block;
	private $pgsize;
	private $blsize;
	private $total_cnt;
	private $total_page;
	private $total_block;
	#construct
	public function __construct($page, $pgsize, $blsize){
		$this->page			= ($page) ? $page : 1;
		$this->pgsize		= $pgsize;
		$this->blsize		= $blsize;
	}
	
	#setTotalCnt
	public function setTotalCnt($total_cnt){
		$this->total_cnt	= $total_cnt;
		$this->total_page	= ceil($this->total_cnt	/ $this->pgsize);
		$this->total_block	= ceil($this->total_page/ $this->blsize);
		if($this->page > $this->total_page){ 
			$this->page	= ($this->total_page > 0) ? $this->total_page : 1;
		}
		$this->block		= $this->page  ? ceil($this->page / $this->blsize) : 1;
	}
	
	#getStart
	public function getStart(){
		return (($this->page - 1) * $this->pgsize);
	}
	#getLimit
	public function getLimit(){
		return $this->pgsize;
	}

	#getPaging
	public function getPaging(){
		$start		= (($this->block - 1) * $this->blsize) + 1;
		$limit		= $this->blsize * $this->block;
		for($i=$start; $i <= $limit; $i++){
			$paging[] = $i;
			if($i >= $this->total_page) break;
		}
		$return = array(
			'paging'	=> $paging,
			'current_page'	=> $this->page,
			'total_page'=> $this->total_page,
			'prev_page'	=> ($this->page - 1 > 0) ? $this->page - 1 : NULL,
			'next_page'	=> ($this->page < $this->total_page) ? $this->page + 1 : NULL,
			'prev_block'=> ($this->block - 1 > 0) ? (($this->block - 2) * $this->blsize) + 1 : NULL,
			'next_block'=> ($this->block < $this->total_block) ? ($this->block * $this->blsize) + 1 : NULL
		);
		return $return;
	}
}
?>