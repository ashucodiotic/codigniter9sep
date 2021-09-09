<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
        
	}

   public function get_all_report($page,$limit,$q=false,$industry_id=array(),$pub_status=array()){
			$page 	= $page ? intval($page) : 1;
			$limit  = $limit ? intval($limit) : 10;
	        $offset = ($page-1)*$limit;



	        $query  = "SELECT  url_key,
	                           report_title,
	                           /*table_of_content,*/
	                           date, 
	                           pages,
	                           report_tbl.industry_id as report_ind_id,
	                           pub_id,
	                           /*meta_title,
	                           meta_description,
	                           meta_keywords,*/
	                           report_id,
	                           is_featured,
	                           /*SUBSTRING(content_body, 1, LOCATE('.', content_body)) AS content_body,*/
	                           SUBSTRING_INDEX (content_body,'&nbsp;',25) AS content_body,
	                           industry_name 
	                   FROM report_tbl 
	                   LEFT JOIN industry_tbl ON report_tbl.industry_id = industry_tbl.industry_id
	                   WHERE report_id != 0";

	        if (!empty($industry_id)){
	    		$query .= " AND ( ";
	    		foreach ($industry_id as $key => $value) {
	    			if($key == 0){
                       	$query .= " report_tbl.industry_id = ".$value;
	    			}else{
                        $query .= " OR report_tbl.industry_id = ".$value;
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	    	if (!empty($pub_status)){
	    		$query .= " AND ( ";
	    		foreach ($pub_status as $key => $value) {
	    			if($key == 0){
                       	$query .= " pub_status = '".$value."'";
	    			}else{
                        $query .= " OR pub_status = '".$value."'";
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	    	

	    	if ($q){
	    		$query .= " AND report_title LIKE '%".$q."%' ";
	    	}
	        $query  .= " LIMIT ".$limit." OFFSET ".$offset;
	        
			$rows   =  $this->db->query($query)->result_array();
				

			//rows counting
			$query  = "SELECT  COUNT(*) count FROM report_tbl 
			           WHERE report_id != 0";
			if (!empty($industry_id)){
	    		$query .= " AND ( ";
	    		foreach ($industry_id as $key => $value) {
	    			if($key == 0){
                       	$query .= " report_tbl.industry_id = ".$value;
	    			}else{
                        $query .= " OR report_tbl.industry_id = ".$value;
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	    	if (!empty($pub_status)){
	    		$query .= " AND ( ";
	    		foreach ($pub_status as $key => $value) {
	    			if($key == 0){
                       	$query .= " pub_status = '".$value."'";
	    			}else{
                        $query .= " OR pub_status = '".$value."'";
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	       	if($q){
	        	$query .= " AND report_title LIKE '%".$q."%' ";
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

	public function get_all_featured_report($page,$limit,$q=false,$industry_id=array(),$pub_status=array()){
			$page 	= $page ? intval($page) : 1;
			$limit  = $limit ? intval($limit) : 10;
	        $offset = ($page-1)*$limit;



	        $query  = "SELECT  *,report_tbl.show_on_front as report_show_on_front  FROM report_tbl
	                   LEFT JOIN industry_tbl ON report_tbl.industry_id = industry_tbl.industry_id 
	                   WHERE is_featured = 1 ";

	        if (!empty($industry_id)){
	    		$query .= " AND ( ";
	    		foreach ($industry_id as $key => $value) {
	    			if($key == 0){
                       	$query .= " report_tbl.industry_id = ".$value;
	    			}else{
                        $query .= " OR report_tbl.industry_id = ".$value;
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	    	if (!empty($pub_status)){
	    		$query .= " AND ( ";
	    		foreach ($pub_status as $key => $value) {
	    			if($key == 0){
                       	$query .= " pub_status = '".$value."'";
	    			}else{
                        $query .= " OR pub_status = '".$value."'";
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	    	

	    	if ($q){
	    		$query .= " AND report_title LIKE '%".$q."%' ";
	    	}
	        $query  .= " ORDER BY report_tbl.report_id DESC LIMIT ".$limit." OFFSET ".$offset;
	        //_dx($query);
			$rows   =  $this->db->query($query)->result_array();	

			//rows counting
			$query  = "SELECT  COUNT(*) count FROM report_tbl 
			           LEFT JOIN industry_tbl ON report_tbl.industry_id = industry_tbl.industry_id
			           WHERE is_featured = 1 ";
			if (!empty($industry_id)){
	    		$query .= " AND ( ";
	    		foreach ($industry_id as $key => $value) {
	    			if($key == 0){
                       	$query .= " report_tbl.industry_id = ".$value;
	    			}else{
                        $query .= " OR report_tbl.industry_id = ".$value;
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	    	if (!empty($pub_status)){
	    		$query .= " AND ( ";
	    		foreach ($pub_status as $key => $value) {
	    			if($key == 0){
                       	$query .= " pub_status = '".$value."'";
	    			}else{
                        $query .= " OR pub_status = '".$value."'";
	    			}
	    		}
	    		$query .= " ) ";
	    	}
	       	if($q){
	        	$query .= " AND report_title LIKE '%".$q."%' ";
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

    public function get_all_publish_status(){
    	$query = "SELECT pub_status FROM report_tbl GROUP BY pub_status";
    	$data   =  $this->db->query($query)->result_array();
    	return $data;
    }

    public function get_report_by_id($Id){
    	$query = "SELECT *,report_tbl.show_on_front as report_show_on_front FROM report_tbl 
    	          LEFT JOIN industry_tbl ON report_tbl.industry_id = industry_tbl.industry_id
    	          WHERE report_id = ".$Id;
    	$data   =  $this->db->query($query)->result_array();
    	return $data;
    }	

}