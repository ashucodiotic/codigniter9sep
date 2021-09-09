<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Industry_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';

	}

	public function get_all_industry($page,$limit,$q=false){
			$page 	= $page ? intval($page) : 1;
			$limit  = $limit ? intval($limit) : 10;
	        $offset = ($page-1)*$limit;



	        $query  = "SELECT  *  FROM industry_tbl WHERE is_deleted = 0";
	    	if ($q){
	    		$query .= " AND industry_name LIKE '%".$q."%' ";
	    	}
	        $query  .= " ORDER BY created_at DESC LIMIT ".$limit." OFFSET ".$offset;
			$rows   =  $this->db->query($query)->result_array();	

			//rows counting
			$query  = "SELECT  COUNT(*) count FROM industry_tbl WHERE is_deleted = 0";
	       	if($q){
	        	$query .= " AND industry_name LIKE '%".$q."%' ";
	        }

			$count  = 	$this->db->query($query)->row()->count;	
	        $pages  =   $count ? ceil($count/$limit) : 1;
	        $from   =   intval($offset+1);
	        $to     =   intval(($page-1)*$limit)+$limit;
	        if ($count == 0) {
	        	$from = 0;
	        }

	        
			$data 		= array(			
							'rows' => $rows,
							'pages'=>$pages < 1 ? 1 : $pages,
							'page'=>$page,
							'showing_from'=>$from < 0 ? 1 : $from,
							'showing_upto'=>$to >= $count ? $count : $to,
							'count'=>$count,
							'limit'=>$limit,
							'offset'=>$offset,
						);

		//	_dx($data);
			return $data;
	}

	public function get_all_popular_industry($page,$limit,$q=false){
			$page 	= $page ? intval($page) : 1;
			$limit  = $limit ? intval($limit) : 10;
	        $offset = ($page-1)*$limit;



	        $query  = "SELECT  *  FROM industry_tbl WHERE is_deleted = 0 AND is_popular = 1";
	    	if ($q){
	    		$query .= " AND industry_name LIKE '%".$q."%' ";
	    	}
	        $query  .= " ORDER BY created_at DESC LIMIT ".$limit." OFFSET ".$offset;
			$rows   =  $this->db->query($query)->result_array();	

			//rows counting
			$query  = "SELECT  COUNT(*) count FROM industry_tbl WHERE is_deleted = 0 AND is_popular = 1";
	       	if($q){
	        	$query .= " AND industry_name LIKE '%".$q."%' ";
	        }

			$count  = 	$this->db->query($query)->row()->count;	
	        $pages  =   $count ? ceil($count/$limit) : 1;
	        $from   =   intval($offset+1);
	        $to     =   intval(($page-1)*$limit)+$limit;
	        if ($count == 0) {
	        	$from = 0;
	        }

	        
			$data 		= array(			
							'rows' => $rows,
							'pages'=>$pages < 1 ? 1 : $pages,
							'page'=>$page,
							'showing_from'=>$from < 0 ? 1 : $from,
							'showing_upto'=>$to >= $count ? $count : $to,
							'count'=>$count,
							'limit'=>$limit,
							'offset'=>$offset,
						);

		//	_dx($data);
			return $data;
	}
	

}