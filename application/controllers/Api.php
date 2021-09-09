<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/vendor/autoload.php';
use \Firebase\JWT\JWT;

class Api extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: ' . "*");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: *');
		$this->load->model('Misc_model','misc');
		$this->load->model('login_model','login');
		$this->load->model('Blog_model','blog');
		$this->load->model('Report_model','report');
		$this->load->model('Industry_model','industry');
		$this->load->model('Client_model','client');
		$this->load->model('News_model','news');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
        $this->dataToSend['base_url'] = base_url();
	}

	public function get_reports(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$industry_id = array();
		$pub_status = array();

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

		if(isset($data->industry_id)){
			$industry_id = $data->industry_id;
		}
		if(isset($data->pub_status)){
			$pub_status = $data->pub_status;
		}
        
        $this->dataToSend['result'] 	=	$this->report->get_all_report($data->page,$data->limit,$data->query,$industry_id,$pub_status);
        
		echo json_encode($this->dataToSend);
	}

	public function get_featured_reports(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$industry_id = array();
		$pub_status = array();

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

		if(isset($data->industry_id)){
			$industry_id = $data->industry_id;
		}
		if(isset($data->pub_status)){
			$pub_status = $data->pub_status;
		}
        
        $this->dataToSend['result'] 	=	$this->report->get_all_featured_report($data->page,$data->limit,$data->query,$industry_id,$pub_status);
        
		echo json_encode($this->dataToSend);
	}

	public function get_blogs(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

        $this->dataToSend['result'] 	=	$this->blog->get_all_blog($data->page,$data->limit,$data->query);
        
		echo json_encode($this->dataToSend);
	}

	public function get_industries(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

        $this->dataToSend['result'] 	=	$this->industry->get_all_industry($data->page,$data->limit,$data->query);
        
		echo json_encode($this->dataToSend);
	}

	public function get_popular_industries(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

        $this->dataToSend['result'] 	=	$this->industry->get_all_popular_industry($data->page,$data->limit,$data->query);
        
		echo json_encode($this->dataToSend);
	}

	public function get_clients(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

        $this->dataToSend['result'] 	=	$this->client->get_all_client($data->page,$data->limit,$data->query);
        
		echo json_encode($this->dataToSend);
	}

	public function get_news(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->page) || !isset($data->limit) || !isset($data->query)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'page, limit and query is required';
			echo json_encode($this->dataToSend);
			die();
		}

        $this->dataToSend['result'] 	=	$this->news->get_all_news($data->page,$data->limit,$data->query);
        
		echo json_encode($this->dataToSend);
	}

	public function get_all_industries(){
	   $this->dataToSend['industries'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('industry_name','industry_id'),array('is_deleted'=>0));
	   echo json_encode($this->dataToSend);
	}

	public function get_all_publish_status(){
	   $this->dataToSend['publish_status'] = $this->report->get_all_publish_status();
	   echo json_encode($this->dataToSend);
	}

	public function add_user(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->first_name)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'first name is required';
			echo json_encode($this->dataToSend);
			die();
		}else{
			if($data->first_name == ""){
                $this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'first name is required';
				echo json_encode($this->dataToSend);
				die();
			}
		}

		if (!isset($data->last_name)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'last name is required';
			echo json_encode($this->dataToSend);
			die();
		}else{
			if ($data->last_name == "") {
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'last name is required';
				echo json_encode($this->dataToSend);
				die();
		    }
		}

		if (!isset($data->email)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'email is required';
			echo json_encode($this->dataToSend);
			die();
		}else{
			if ($data->email == "") {
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'email is required';
				echo json_encode($this->dataToSend);
				die();
			}
		}

		if (!isset($data->password)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'password is required';
			echo json_encode($this->dataToSend);
			die();
		}else{
			if ($data->password == "") {
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'password is required';
				echo json_encode($this->dataToSend);
				die();
			}
		}

		$exist = $this->misc->isExist('user_tbl',array('email'=>$data->email));
		//_dx($exist['status']);
		if($exist['status']){
            $this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'user is already exist with this email.';
			echo json_encode($this->dataToSend);
			die();
		}

		$result = $this->misc->add('user_tbl', array(
			                                         'first_name'=>$data->first_name,
			                                         'last_name'=>$data->last_name,
			                                         'email'=>$data->email,
			                                         'password'=>md5($data->password)
		                                            ));
		//_dx($result);
		if($result){
			$this->dataToSend['msg'] = 'User added successfully.';
			echo json_encode($this->dataToSend);
			die();
		}
		$this->dataToSend['status'] = 'ERR';
		$this->dataToSend['msg'] 	 = 'Something want wrong';
		echo json_encode($this->dataToSend);
		die();
	}

	public function user_login(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);

		if (!isset($data->email)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'email is required';
			echo json_encode($this->dataToSend);
			die();
		}else{
			if ($data->email == "") {
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'email is required';
				echo json_encode($this->dataToSend);
				die();
			}
		}

		if (!isset($data->password)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'password is required';
			echo json_encode($this->dataToSend);
			die();
		}else{
			if ($data->password == "") {
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'password is required';
				echo json_encode($this->dataToSend);
				die();
			}
		}

		$exist = $this->misc->isExist('user_tbl',array('email'=>$data->email,
	                                                   'password'=>md5($data->password),
	                                                    'is_deleted'=>0,
	                                                    'is_active'=>1));
		//_dx($exist['status']);
		if(!$exist['status']){
            $this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'User is not exist with this email and password.';
			echo json_encode($this->dataToSend);
			die();
		}

		$update_result = $this->misc->update('user_tbl',array('last_login'=>Date('Y-m-d H:i:s'),
	                                                          'updated_at'=>Date('Y-m-d H:i:s')),
		                                                array('email'=>$data->email));

		if($update_result['results']){
            $now_seconds = time();
            $key = "adhoc1234";
			$payload = array(
			    "userId" => $update_result['result'][0]['user_id'],
			    "type" => "USER",
			    "iat" => $now_seconds,
                "exp" => $now_seconds+(15*24*60*60) // Maximum expiration time is one hour
            );

			
			$jwt = JWT::encode($payload, $key);

			$this->dataToSend['msg'] = 'Welcome Back';
			$this->dataToSend['token'] = $jwt;
            echo json_encode($this->dataToSend);
			die();
		}

		$this->dataToSend['status'] = 'ERR';
		$this->dataToSend['msg'] 	 = 'Something want wrong';
		$this->dataToSend['token'] = "";
		echo json_encode($this->dataToSend);
		die();
	}

	public function get_report_by_id($Id){
       if ($Id == '' || !(is_numeric($Id)) || $Id < 1) {
			$this->dataToSend['status'] = 'ERR';
	    	$this->dataToSend['msg'] 	= 'Something want wrong';
	    	echo  json_encode($this->dataToSend);
	    	die();
		}

		$report = $this->report->get_report_by_id($Id);

		if (empty($report)) {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'Something want wrong';
			echo json_encode($this->dataToSend);
			die();
		}

		$this->dataToSend['data'] = $report[0];
        echo json_encode($this->dataToSend);
		die();
	}

	public function get_blog_by_id($Id){
       if ($Id == '' || !(is_numeric($Id)) || $Id < 1) {
			$this->dataToSend['status'] = 'ERR';
	    	$this->dataToSend['msg'] 	= 'Something want wrong';
	    	echo  json_encode($this->dataToSend);
	    	die();
		}

		$blog = $this->misc->getSelectedDataWithCondition('blog_tbl',array('*'),array('blog_id'=>$Id));

		if (empty($blog)) {
			$this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] 	 = 'Something want wrong';
			echo json_encode($this->dataToSend);
			die();
		}

		$this->dataToSend['data'] = $blog[0];
        echo json_encode($this->dataToSend);
		die();
	}

	public function add_inquiry(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		//_dx($data->report_id);
		$result = $this->misc->add('inquiry_tbl', array(
			                                         'name'=>$data->name,
			                                         'message'=>$data->message,
			                                         'designation'=>$data->designation,
			                                         'company'=>$data->company,
			                                         'email'=>$data->email,
			                                         'country'=>$data->country,
			                                         'mobile'=>$data->mobile,
			                                         'report_id'=>isset($data->report_id) ? $data->report_id : "",
			                                         'address'=>isset($data->address) ? $data->address : "",
			                                         'city'=>isset($data->city) ? $data->city : "",
			                                         'state'=>isset($data->state) ? $data->state : "",
			                                         'zipcode'=>isset($data->zipcode) ? $data->zipcode : "",
			                                         'type'=>isset($data->type) ? $data->type : ""
		                                            ));
		//_dx($result);
		if($result){
			$this->dataToSend['msg'] = 'Inquiry added successfully.';
			echo json_encode($this->dataToSend);
			die();
		}
		$this->dataToSend['status'] = 'ERR';
		$this->dataToSend['msg'] 	 = 'Something want wrong';
		echo json_encode($this->dataToSend);
		die();
	}
	
	// //check login authantication
	// public function auth(){
	// 	$json = file_get_contents('php://input');
	// 	$data = json_decode($json);
	// 	if($json == ""){
	// 		$this->dataToSend['status'] 	= 'ERR';
	// 		$this->dataToSend['msg'] 		= 'Invalid request, email and password is required.';
	// 		echo json_encode($this->dataToSend);
	// 		die();
	// 	}
		
	// 	if (!isset($data->email) || !isset($data->password)) {
			
	// 		$this->dataToSend['status'] 	= 'ERR';
	// 		$this->dataToSend['msg'] 		= 'email and password is required';
	// 		echo json_encode($this->dataToSend);
	// 		die();
	// 	}
		
	// 	$email 	= $data->email;
	// 	$pass 	= $data->password;


	// 	if($email == '' || $pass == ''){
	// 		$this->dataToSend['status'] 	= 'ERR';
	// 		$this->dataToSend['msg'] 		= 'Invalid email or password';
	// 		echo json_encode($this->dataToSend);
	// 		die();
	// 	}

		
	// 	$user = $this->login->checkPartyLogin($email, md5($pass));

	// 	if($user['status'] == 'OK'){
 //            $now_seconds = time();
 //            $key = "hp1234";
	// 		$payload = array(
	// 		    "partyId" => $user['result']['party_id'],
	// 		    "type" => "PARTY",
	// 		    "firmName" => $user['result']['party_firm_name'],
	// 		    "partyMobile" => $user['result']['party_contact_mobile'],
	// 		    "iat" => $now_seconds,
 //                "exp" => $now_seconds+(15*24*60*60) // Maximum expiration time is one hour
	// 		);

			
	// 		$jwt = JWT::encode($payload, $key);

	//   		// $decoded_data =  _checkAuth($jwt);
 //            // _dx($decoded_data);

	// 		$this->dataToSend['msg'] = 'Welcome Back';
	// 		$this->dataToSend['token'] = $jwt;									
			
	// 	}else{
 //            $this->dataToSend['status'] = 'ERR';
	// 		$this->dataToSend['msg'] = $user['msg'];
	// 		$this->dataToSend['token'] = "";
	// 	}
	// 	//_dx($user);	
	// 	echo json_encode($this->dataToSend);

	// }
    
 //    //get slider images
	// public function get_slider_images(){
	//   $auth_data = _checkAuth();
	//   //_dx($auth_data);

	//   if($auth_data['status']){
 //          $images = $this->misc->getSelectedDataWithCondition('slider_image_tbl',array('*'),array('is_deleted' => 0));

 //          foreach ($images as $key => $value) {
 //          	$images[$key]['image_url'] = base_url().$images[$key]['image_url'];
 //          }

 //          $this->dataToSend['result']   = $images;
	// 	  $this->dataToSend['msg'] 		= 'Data Found';
	// 	  echo json_encode($this->dataToSend);
	// 	  die();
	//   }else{
	//   	    $this->dataToSend['status'] 	= 'ERR';
	// 		$this->dataToSend['msg'] 		= $auth_data['msg'];
	// 		echo json_encode($this->dataToSend);
	// 		die();
	//   }	
	// }
    
    
}
