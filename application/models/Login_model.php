<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
        $this->load->model('Misc_model','misc');
	}

	public function checklogin($email, $password,$type){
		
		if ($type == 'ADMIN'){
			$this->db->where('admin_email', $email);
			$this->db->where('admin_password', $password);
			$res = $this->db->get('admin_tbl')->result_array();
			if (!empty($res)) {
				$res[0]['is_admin'] = 1;
			}	
		}else if($type == 'EMPLOYEE'){
			$this->db->where('employee_email', $email);
			$this->db->where('employee_password', $password);
			//$this->db->where('is_deleted', 0);			
			$res = $this->db->get('employee_tbl')->result_array();
			if (!empty($res)) {
				$res[0]['is_admin'] = 0;
			}			
		}

        // $query = "select (party_contact_mobile) from party_tbl";		
		// $rows   =  $this->db->query($query)->result_array();

		// foreach ($rows as $mobile) {

		// 	$party_contact_mobile = md5($mobile["party_contact_mobile"]);

		// 	$result = $this->misc->update("party_tbl",array('party_password' => $party_contact_mobile), array('party_contact_mobile' => $mobile["party_contact_mobile"] ));
		// }

		
		if (empty($res)) {
			$this->dataToSend['status']		 =	'ERR';
			$this->dataToSend['msg']		 =	array('Incorrect username or password');
		}else{			
			if($res[0]['is_admin'] == 0){					
				if(!$res[0]['is_deleted']){	
					// if(!$res[0]['is_loged_in']){ 
						// $this->db->where('employee_email', $email);
						// $this->db->where('employee_password', $password);
						// $this->db->update('employee_tbl',array('is_loged_in'=>1));

						$this->dataToSend['msg']		 =	array('Data Get Successfully');
						$this->dataToSend['result']		 =	$res[0];
					// }else{
					// 	$this->dataToSend['status']		 =	'ERR';
					// 	$this->dataToSend['msg']		 =	array('User Already logged in');
					// }
				}else{
					$this->dataToSend['status']		 =	'ERR';
					$this->dataToSend['msg']		 =	array('Your account is Deactivated');
				}
			}else{
				$this->db->where('employee_email', $email);
				$this->db->where('employee_password', $password);
				$this->db->update('employee_tbl',array('is_loged_in'=>1));

				$this->dataToSend['msg']		 =	array('Data Get Successfully');
				$this->dataToSend['result']		 =	$res[0];
			}
		}

		return $this->dataToSend;
		
	}

	public function checkPartyLogin($email, $password){

		$this->db->where('party_email', $email);
		$this->db->where('is_deleted', 0);
		$this->db->where('party_password', $password);
		$res = $this->db->get('party_tbl')->result_array();
		 
		
		if (empty($res)) {
			$this->dataToSend['status']		 =	'ERR';
			$this->dataToSend['msg']		 =	'Incorrect username or password';
		}else{			
			$this->dataToSend['msg']		 =	'Data Get Successfully';
		    $this->dataToSend['result']		 =	$res[0];
		}

		return $this->dataToSend;
		
	}
}