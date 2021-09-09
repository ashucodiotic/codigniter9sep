<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misc_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->dataToSend = array();
		date_default_timezone_set('Asia/Kolkata');
		$this->db->query("SET time_zone='+5:30';");
		$this->db->reconnect();
	}

	public function execute($query){	
		
		return $this->db->query($query)->result_array();
		
	}

	public function insertData($data, $tbl){
		
			$res 		= $this->db->insert($tbl,$data);

			$rows 		= $this->db->affected_rows();

			$insertId 	= $this->db->insert_id();

			$this->dataToSend['results'] 	= $rows;

			$this->dataToSend['insert_id'] 	= $insertId;

			return $this->dataToSend;

	}
	public function add_and_get_id($tbl, $data){
		//add single entry in table
		$data['res'] = $this->db->insert($tbl, $data);
		$data['insert_id'] = $this->db->insert_id();

        return  $data;
	}

	public function isExist($tblname,$data){			
		if(empty($data)) {
			$this->dataToSend['status']	=	false;
			$this->dataToSend['msg']		=	'No Data Found';
			return $this->dataToSend;
		}

		foreach ($data as $key => $val) {
			$this->db->where($key,$val);
		}

		$res = $this->db->get($tblname)->result_array();
		
		if (!empty($res)){
			$this->dataToSend['result']	=	$res;
			$this->dataToSend['status']	=	true;
			$this->dataToSend['msg']		=	'Exist';
		}else{			
			$this->dataToSend['result']	=	$res;
			$this->dataToSend['status']	=	false;
			$this->dataToSend['msg']		=	'Not Exist';
		}
		return $this->dataToSend;

	}


	public function isExistMultipale($tblname,$data){			
		if(empty($data)) {
			$this->dataToSend['status']	=	false;
			$this->dataToSend['msg']		=	'No Data Found';
			return $this->dataToSend;
		}

		foreach ($data as $key => $val) {
			$this->db->or_where($key,$val);
		}

		$this->db->get($tblname);
		$res 			=  $this->db->affected_rows();		
		if ($res>0){
			$this->dataToSend['status']	=	true;
			$this->dataToSend['msg']		=	'Exist';
		}else{			
			$this->dataToSend['status']	=	false;
			$this->dataToSend['msg']		=	'Not Exist';
		}
		return $this->dataToSend;

	}

	public function updateIsExist($tblname,$data,$dataIsNot){

		if (empty($data)) {
			$this->dataToSend['status']	=	false;
			$this->dataToSend['msg']		=	'No Data Found';
			return $this->dataToSend;

		}

		foreach ($data as $key => $val) {
			$this->db->where($key,$val);
		}

		foreach ($dataIsNot as $key => $value){
			$this->db->where($key.'!=',$value);
		}

		$this->db->get($tblname);
		$res 			=  $this->db->affected_rows();
		if ($res>0){

			$this->dataToSend['status']		=	true;
			$this->dataToSend['msg']		=	'Exist';

		}else{			

			$this->dataToSend['status']		=	false;
			$this->dataToSend['msg']		=	'Not Exist';

		}
		return $this->dataToSend;
	}


	public function updateIsExistMultipale($tblname,$data,$dataIsNot){

		if (empty($data)) {
			$this->dataToSend['status']	=	false;
			$this->dataToSend['msg']		=	'No Data Found';
			return $this->dataToSend;

		}
		$query 	=	"SELECT * FROM ".$tblname." WHERE ( ";
		$i 		=	1;
		$count	=	sizeof($data);
		foreach ($data as $key => $val) {
			$query .= $key." = '".$val."' ";
			if ($count != $i) {
				$query .= " OR ";
			}
			$i++;
		}

		$query .=" ) ";

		foreach ($dataIsNot as $key => $value){
			$query .= " AND ".$key." != '".$value."' ";
		}
		
		$res  	=  $this->db->query($query);
		$res 	=  $this->db->affected_rows();
		if ($res>0){

			$this->dataToSend['status']		=	true;
			$this->dataToSend['msg']		=	'Exist';

		}else{			

			$this->dataToSend['status']		=	false;
			$this->dataToSend['msg']		=	'Not Exist';

		}
		return $this->dataToSend;
	}


	public function update($tbl,$data,$conditionalData){		

		foreach ($conditionalData as $key => $value) {
			$this->db->where($key,$value);
		}

		$res 		= $this->db->update($tbl,$data);
		$rows 		= $this->db->affected_rows();

		$this->dataToSend['results'] 	= $rows;			
		return $this->dataToSend;
	}
	
	public function insertBulk($table, $data){
		 $this->db->insert_batch($table,$data);
		 return	$this->db->affected_rows();
	}

	public function delete($tbl,$data){	

		foreach ($data as $key => $value) {

			$this->db->where($key,$value);

		}			 

		$res 		= $this->db->delete($tbl);

		$rows 		= $this->db->affected_rows();

		$this->dataToSend['results'] 	= $rows;			

		return $this->dataToSend;

	}


	public function getAll($tblname){

		$res = $this->db->get($tblname)->result_array();
		return $res;
	}

	public function getSelectedData($tblname,$selectArray){
		
		for ($i=0; $i < sizeof($selectArray)  ; $i++) { 
			$this->db->select($selectArray[$i]);
		}

		$res = $this->db->get($tblname)->result_array();
		return $res;
	}

	public function getSelectedDataWithCondition($tblname,$selectArray,$conditions){
		//_dx($conditions);

		for ($i=0; $i < sizeof($selectArray)  ; $i++) { 
			$this->db->select($selectArray[$i]);
		}

		if($conditions){
			foreach ($conditions as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		$res = $this->db->get($tblname)->result_array();
		return $res;
	}

	public function insertReturnlastId($data, $tbl){

		$res 		= $this->db->insert($tbl, $data);
		$rows 		= $this->db->affected_rows();
		$insertId 	= $this->db->insert_id();
		$this->dataToSend['results'] 	= $rows;
		$this->dataToSend['insert_id'] 	= $insertId;
		return $this->dataToSend;
	}


	public function update_batch($tbl,$data,$key){
		return $this->db->update_batch($tbl, $data, $key);
	}

	public function lastRowData($tbl,$keyName,$condition=false){

		if ($condition) {
			foreach ($condition as $key => $val) {
				$this->db->where($key,$val);
			}
		}

		$query = $this->db->query("SELECT * FROM $tbl ORDER BY $keyName DESC LIMIT 1");
		$result = $query->result_array();		
		return $result;
	}

	public function get_distirct_city($state_id ,$district_id){
		$res['state'] 	= $this->db->get('state_tbl')->result_array();		

		$this->db->where('state_id',$state_id);
		$res['district'] = $this->db->get('district_tbl')->result_array();

		$this->db->where('district_id',$district_id);
		$res['city'] 	 = $this->db->get('city_tbl')->result_array();
		return $res;

	}


	//getAllAccessRouts
	public function getAllAccessRouts($userID){		
		$query = "SELECT employee_group_access FROM employee_tbl emp LEFT JOIN employee_type_tbl  empgrp ON empgrp.employee_group_id = emp.employee_group_id WHERE employee_id = $userID AND emp.is_deleted = 0";		
		$res = $this->db->query($query)->result_array();
		if(!empty($res)) {
			$userAccess = unserialize($res[0]['employee_group_access']);
			$this->db->select('module_route');		
			$this->db->where_in('module_key',$userAccess);
			$res = $this->db->get('module_tbl')->result_array();
		}
		

		return $res;
	}


	//getAllAccessRoutsId
	public function getAllAccessRoutsId($userID){		
		$query = "SELECT employee_group_access FROM employee_tbl emp LEFT JOIN employee_type_tbl  empgrp ON empgrp.employee_group_id = emp.employee_group_id WHERE employee_id = $userID AND emp.is_deleted = 0";		
		$res = $this->db->query($query)->result_array();
		if(!empty($res)) {
			$userAccess = unserialize($res[0]['employee_group_access']);
			$this->db->select('module_id');		
			$this->db->where_in('module_key',$userAccess);
			$res = $this->db->get('module_tbl')->result_array();
		}
		

		return $res;
	}

	public function add($tbl, $data){
		//add single entry in table
		return $this->db->insert($tbl, $data);
	}

}

