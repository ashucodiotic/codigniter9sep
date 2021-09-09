<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		_lgback($this,'admin');
		$this->load->model('login_model','login');
		$this->load->model('Sms_model','sms');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}
	public function index(){
		$this->load->view('login/login');
	}

	
	//check login authantication
	public function auth(){
		$email 	= $this->input->post('email');
		$pass 	= $this->input->post('password');
		$type 	= $this->input->post('type');


		if($email == '' || $pass == ''){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msgs'] 		= array('Invalid email or password');
			echo json_encode($this->dataToSend);
			die();
		}

		
		$user = $this->login->checklogin($email, md5($pass),$type);	

		if($user['status'] == 'OK'){
			$this->session->set_userdata('admin',$user['result']);	
			$this->dataToSend['msgs'] = array('Welcome Back');									
		}else{
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msgs'] = $user['msg'];	
		}

		echo json_encode($this->dataToSend);

	}

	public function logout(){
		if ($this->session->userdata('user')) {
			$res 	=	_log($this, 'Logged out');
			$this->session->unset_userdata('user');	
			redirect('home');
		}else{
			redirect('home');
		}	
	}

	public function adminForgetPassword(){
		$this->dataToSend['userType'] = 'admin';
		$this->load->view('login/recover-password',$this->dataToSend);	
	}

	public function employeeForgetPassword(){
		$this->dataToSend['userType'] = 'employee';
		$this->load->view('login/recover-password',$this->dataToSend);		
	}

	public function send_link(){

		$email = trim($this->input->post('email'));
		$type  = trim($this->input->post('user-type'));

		if($email == '') {
			 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'Email is required';
			 echo json_encode($this->dataToSend);
			 die();
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'Invalid Email id';
			 echo json_encode($this->dataToSend);
			 die();
		}

		if($type == '') {
			 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'something want wrong';
			 echo json_encode($this->dataToSend);
			 die();
		}

		$type = strtolower($type);
		$admin_id ='';
		if($type == 'admin') {
			$condition = array(
							'admin_email'=>$email,
						);	
			$isExist = $this->misc->isExist('admin_tbl',$condition);
			if(!$isExist['status']) {
			 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'This email is not exist';
			 echo json_encode($this->dataToSend);
			 die();
			}else{
				$admin_id = $isExist['result'][0]['admin_id'];
				$userName = $isExist['result'][0]['admin_name'];
			}
		}else if($type == 'employee'){
			$condition = array(
							'employee_email'=>$email,
						);	
			$isExist = $this->misc->isExist('employee_tbl',$condition);
			if(!$isExist['status']) {
			 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'This email is not exist';
			 echo json_encode($this->dataToSend);
			 die();
			}else{
				$admin_id = $isExist['result'][0]['employee_id'];
				$userName = $isExist['result'][0]['employee_name'];
			}
		}else{
			 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'something want wrong';
			 echo json_encode($this->dataToSend);
			 die();
		}

		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            if ($admin_id != '' || !(is_numeric($admin_id)) || $admin_id < 1){
              
              $admin_id = md5($admin_id);
              $key_1 = md5(rand(1,1000));
              $key_2 = md5(rand(1,2000));
           	  $created_at = date("Y-m-d-h-i-s");
           	  $expire_time = date("Y-m-d-h-i-s", strtotime("+15 minutes"));

           	  $data_to_tbl = array(
           	  	                   'admin_id' => $admin_id,
           	  	                   'key_1' => $key_1,
           	  	                   'key_2' => $key_2,
           	  	                   'key_3' => $type,
           	  	                   'created_at' => $created_at,
           	  	                   'is_used' => '',
           	  	                   'expire_time' => $expire_time 
           	  	                  );

           	  $reset_id = $this->misc->add_and_get_id('admin_reset_password', $data_to_tbl);
           	  //_dx($reset_id['insert_id']);
           	  if($type == 'admin') {
					$res = $this->misc->update('admin_tbl',array('reset_key_id' => $reset_id['insert_id']),array('admin_email' => $email));
				}

				if ($type == 'employee') {
					$res = $this->misc->update('employee_tbl',array('reset_key_id' => $reset_id['insert_id']),array('employee_email' => $email));
				}
           	  

           	  $link = site_url('check-key?abc='.$admin_id.'&pqr='.$key_1.'&xyz='.$key_2);

				$subject = "Password reset instructions";
				$txt = "Hi ".strtoupper($userName).",\nNeed to reset your Hanumant plywood password? Click here:".$link."\nIf you think you received this email by mistake, feel free to ignore it. \nThanks,\nThe SYS-SecCon Team";
				
				
				$res = $this->sms->email($email,$subject,$txt);
				
				if ($res) {
					$this->dataToSend['msg'] 	 = 'Link send your email id please check it';					 
				}else{	
					//_dx('yo');
					$this->dataToSend['status'] = 'ERR';
					$this->dataToSend['msg'] 	 = 'something want wrong';					 
				}

				echo json_encode($this->dataToSend);
				die();
           }else{
           	 $this->dataToSend['status'] = 'ERR';
			 $this->dataToSend['msg'] 	 = 'something want wrong';
			 echo json_encode($this->dataToSend);
			 die();
			}
		}else{
             
             $data['msg'] = 'please enter a valid email';
			$this->load->view('login/recover-password',$data);

		}

			
	}


	public function check_admin_key(){
		
		$abc = $this->input->get('abc');
		$key_1 = $this->input->get('pqr');
		$key_2 = $this->input->get('xyz');

		if ($key_1 == '') {
			redirect('login');
        	die();
		}

		if ($abc == '') {
			redirect('login');
        	die();
		}

		if ($key_2 == '') {
			redirect('login');
        	die();
		}



		$condition = array(						
						'admin_id'	=> $abc,
						'key_1'		=> $key_1,
						'key_2'		=> $key_2,
						'is_used'	=> '0',
					);


        $data = $this->misc->getSelectedDataWithCondition('admin_reset_password',array('ad_reset_pwd_id','is_used','key_3','expire_time'),$condition);		
        if (!empty($data)) {
            if ($data[0]['expire_time'] > date("Y-m-d-h-i-s")) {
                $data[0]['reset_id'] = $data[0]['ad_reset_pwd_id'];  
                $this->dataToSend['result'] = $data;

        	    $this->load->view('login/set-password',$this->dataToSend);
            }

        }else{
        	redirect('login');
        	die();
        }  	
	}

	public function update_user_password(){
		$reset_id = $this->input->post('reset_id');
		$newPassword = $this->input->post('new-password');
		$confirmPassword = $this->input->post('confirm-password');
		$type = $this->input->post('user-type');
		$expire_time = $this->input->post('expire_time');
		$is_used = $this->input->post('is_used');

		if ($reset_id == '' || !(is_numeric($reset_id)) || $reset_id < 1){
			 $this->dataToSend['status'] = 'ERR';
	    	 $this->dataToSend['msg'] 	 = 'Somthing went wrong';
	    	 echo  json_encode($this->dataToSend);
	    	 die();
		}

		if ($newPassword == '') {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'New Passowrd is required';
			echo json_encode($this->dataToSend);
			die();
		}

		if ($confirmPassword == '') {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'Confirm Passowrd is required';
			echo json_encode($this->dataToSend);
			die();
		}

		if (strlen($newPassword) < 8) {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'New Passowrd is at list 8 character';
			echo json_encode($this->dataToSend);
			die();
		}

		if (strlen($confirmPassword) < 8) {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'Confirm Passowrd is at list 8 character';
			echo json_encode($this->dataToSend);
			die();
		}

		if ($confirmPassword != $newPassword) {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'New Password and Confirm Passowrd is not match';
			echo json_encode($this->dataToSend);
			die();
		}

		if($expire_time < date("Y-m-d-h-i-s")) {
			$this->dataToSend['status'] = 'TIMEOUT';
			$this->dataToSend['msg'] 	 = 'Time Out';
			echo json_encode($this->dataToSend);
			die();
		}

		$condition = array(
								'reset_key_id' => $reset_id,
							);



		if ($type == 'admin') {
			$dataToInsert = array(
								'admin_password' => md5($newPassword),
							);

			$res = $this->misc->update('admin_tbl',$dataToInsert,$condition);
		}else if($type == 'employee'){
			$dataToInsert = array(
								'employee_password' => md5($newPassword),
							);

			$res = $this->misc->update('employee_tbl',$dataToInsert,$condition);
		}else{
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'something want wrong';
			echo json_encode($this->dataToSend);
			die();
		}


		if ($res['results']) {
			$this->dataToSend['msg'] 	 = 'Password change successfully';
			$condition = array(
								'ad_reset_pwd_id' => $reset_id,
							);

			$dataToInsert = array(
								'is_used' => '1',
							);

			$this->misc->update('admin_reset_password',$dataToInsert,$condition);
		}else{
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'something want wrong';
		}

		echo json_encode($this->dataToSend);
		die();
       
	}
}
