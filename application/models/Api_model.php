<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_cms_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';

	}


	// public function get_all_grid($page,$limit,$q=false){
	// 	$page 	= intval($page);
	// 	$limit  = intval($limit);
 //        $offset = ($page-1)*$limit;


 //        $query  = "SELECT  * FROM product_grid_tbl WHERE product_grid_tbl.is_deleted = 0";
 //    	if ($q){
 //    		$query .= " AND grid_title LIKE '%".$q."%' ";
 //    	}

 //    	$queryCount = $query;

 //        $query  .= " ORDER BY product_grid_tbl.inserted_at ASC LIMIT ".$limit." OFFSET ".$offset;
	// 	$rows   =  $this->db->query($query)->result_array();	

	// 	$count  = 	count($this->db->query($queryCount)->result_array());	
 //        $pages  =   ceil($count/$limit);
 //        $from   =   intval($offset+1);
 //        $to     =   intval(($page-1)*$limit)+$limit;
 //        if ($count == 0) {
 //        	$from = 0;
 //        }

	// 	$data 		= array(			
	// 					'rows' => $rows,
	// 					'pages'=>$pages < 1 ? 1 : $pages,
	// 					'page'=>$page,
	// 					'showing_from'=>$from < 0 ? 1 : $from,
	// 					'showing_upto'=>$to >= $count ? $count : $to,
	// 					'count'=>$count,
	// 					'limit'=>$limit,
	// 					'offset'=>$offset,
	// 				);

	// //	_dx($data);
	// 	return $data;
	// }


	// public function get_all_grid_items($grid_id,$page,$limit,$q=false){
	// 	$page 	= intval($page);
	// 	$limit  = intval($limit);
 //        $offset = ($page-1)*$limit;


 //        $query  = "SELECT * 
 //                   FROM grid_item_tbl 
 //                   LEFT JOIN stock_tbl 
 //                   ON grid_item_tbl.item_id = stock_tbl.item_id 
 //                   WHERE stock_tbl.is_deleted = 0 
 //                   AND grid_item_tbl.is_deleted = 0 
 //                   AND product_grid_id = ".$grid_id;
 //    	if ($q){
 //    		$query .= " AND stock_tbl.item_name LIKE '%".$q."%' OR stock_tbl.item_code LIKE '%".$q."%' OR stock_tbl.item_keyword LIKE '%".$q."%'";
 //    	}

 //    	$queryCount = $query;

 //        $query  .= " ORDER BY grid_item_tbl.inserted_at ASC LIMIT ".$limit." OFFSET ".$offset;
	// 	$rows   =  $this->db->query($query)->result_array();	

	// 	$count  = 	count($this->db->query($queryCount)->result_array());	
 //        $pages  =   ceil($count/$limit);
 //        $from   =   intval($offset+1);
 //        $to     =   intval(($page-1)*$limit)+$limit;
 //        if ($count == 0) {
 //        	$from = 0;
 //        }

	// 	$data 		= array(			
	// 					'rows' => $rows,
	// 					'pages'=>$pages < 1 ? 1 : $pages,
	// 					'page'=>$page,
	// 					'showing_from'=>$from < 0 ? 1 : $from,
	// 					'showing_upto'=>$to >= $count ? $count : $to,
	// 					'count'=>$count,
	// 					'limit'=>$limit,
	// 					'offset'=>$offset,
	// 				);

	// //	_dx($data);
	// 	return $data;
	// }

	// public function get_grid_products($grid_id){
		
 //        $query = "SELECT grd.grid_item_id, grd.product_grid_id, grd.item_id, grd.is_deleted, stk.item_id, stk.item_name, stk.item_code, stk.without_water_sunlight
 //                    FROM grid_item_tbl grd
 //                    LEFT JOIN stock_tbl stk ON grd.item_id = stk.item_id
 //                    WHERE grd.is_deleted = 0 AND product_grid_id = ".$grid_id ;
        
 //        //_dx($query);
        
        
	// 	$data   =  $this->db->query($query)->result_array();
	// 	return $data;   
	// }

	// public function get_items_for_update_grid($exist_item_id){

	// 	if (!empty($exist_item_id)) {
	// 	   $item_string = implode(',', $exist_item_id);
		
 //           $query = "SELECT item_id,item_name,item_code,insert_at
 //                    FROM stock_tbl 
 //                    WHERE is_deleted = 0 AND item_id NOT IN ( ".$item_string.")
 //                    ORDER BY insert_at DESC " ;
	// 	}else{
	// 		$query = "SELECT item_id,item_name,item_code,insert_at
 //                    FROM stock_tbl 
 //                    WHERE is_deleted = 0 
 //                    ORDER BY insert_at DESC " ;
	// 	}        
        
	// 	$data   =  $this->db->query($query)->result_array();
	// 	return $data;   
	// }

}