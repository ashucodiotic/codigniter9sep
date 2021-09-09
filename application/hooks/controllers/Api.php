<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/vendor/autoload.php';
use \Firebase\JWT\JWT;

class Api extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		$this->load->model('login_model','login');
		$this->load->model('App_cms_model','cms');
		$this->load->model('Party_model','party');
		$this->load->model('Inventory_model','stock');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	
	
	//check login authantication
	public function auth(){
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		if($json == ""){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid request, email and password is required.';
			echo json_encode($this->dataToSend);
			die();
		}
		
		if (!isset($data->email) || !isset($data->password)) {
			
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'email and password is required';
			echo json_encode($this->dataToSend);
			die();
		}
		
		$email 	= $data->email;
		$pass 	= $data->password;


		if($email == '' || $pass == ''){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid email or password';
			echo json_encode($this->dataToSend);
			die();
		}

		
		$user = $this->login->checkPartyLogin($email, md5($pass));

		if($user['status'] == 'OK'){
            $now_seconds = time();
            $key = "hp1234";
			$payload = array(
			    "partyId" => $user['result']['party_id'],
			    "type" => "PARTY",
			    "firmName" => $user['result']['party_firm_name'],
			    "partyMobile" => $user['result']['party_contact_mobile'],
			    "iat" => $now_seconds,
                "exp" => $now_seconds+(15*24*60*60) // Maximum expiration time is one hour
			);

			
			$jwt = JWT::encode($payload, $key);

	  		// $decoded_data =  _checkAuth($jwt);
            // _dx($decoded_data);

			$this->dataToSend['msg'] = 'Welcome Back';
			$this->dataToSend['token'] = $jwt;									
			
		}else{
            $this->dataToSend['status'] = 'ERR';
			$this->dataToSend['msg'] = $user['msg'];
			$this->dataToSend['token'] = "";
		}
		//_dx($user);	
		echo json_encode($this->dataToSend);

	}
    
    //get slider images
	public function get_slider_images(){
	  $auth_data = _checkAuth();
	  //_dx($auth_data);

	  if($auth_data['status']){
          $images = $this->misc->getSelectedDataWithCondition('slider_image_tbl',array('*'),array('is_deleted' => 0));

          foreach ($images as $key => $value) {
          	$images[$key]['image_url'] = base_url().$images[$key]['image_url'];
          }

          $this->dataToSend['result']   = $images;
		  $this->dataToSend['msg'] 		= 'Data Found';
		  echo json_encode($this->dataToSend);
		  die();
	  }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }	
	}
    
    //get item by id
    public function get_item_by_id($id){
    	$auth_data = _checkAuth();
    	$id 		=	trim($id);
		if($id == '' || !(is_numeric($id)) || $id < 1){
			return redirect(site_url('stock'));
			die();
		}

		if($auth_data['status']){
		  $this->dataToSend['result'] 	=	$this->stock->item_by_id_for_party($id,$auth_data['result']['partyId']);
		  //_dx($this->dataToSend['result']);

		  if(!empty($this->dataToSend['result'])){
           $this->dataToSend['result'][0]['furnished_look'] = unserialize($this->dataToSend['result'][0]['furnished_look']);
		   }
		    $this->dataToSend['msg'] 		= "Data Found";
			echo json_encode($this->dataToSend);
			die();
        }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }
		
    }
    
    //get user ( party )
    public function get_user(){
    	$auth_data = _checkAuth();
    	
		if($auth_data['status']){
		  $this->dataToSend['result'] 	=	$this->misc->getSelectedDataWithCondition("party_tbl",array('party_contact_person','party_id','party_firm_name','party_contact_mobile','party_email','party_address'),array('party_id'=>$auth_data['result']['partyId'], 'is_deleted'=>0));
		  //_dx($this->dataToSend['result']);

            $this->dataToSend['msg'] 		= "Data Found";
			echo json_encode($this->dataToSend);
			die();
		   
        }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }
		
    }
    
    //add freeze request
    public function add_freeze_request(){
    	$auth_data = _checkAuth();

      if($auth_data['status']){
	    	$json = file_get_contents('php://input');
			$data = json_decode($json);
			if($json == ""){
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'Invalid request! item_id and freeze_quantity is required.';
				echo json_encode($this->dataToSend);
				die();
			}
			
			if (!isset($data->item_id) ||  !isset($data->freeze_quantity)) {
				
				$this->dataToSend['status'] 	= 'ERR';
				$this->dataToSend['msg'] 		= 'item_id and freeze_quantity is required.';
				echo json_encode($this->dataToSend);
				die();
			}
			
			$item_id 	        = $data->item_id;
			$party_id 	        = $auth_data['result']['partyId'];
			$freeze_quantity 	= $data->freeze_quantity;

			if ($item_id == '' || $item_id < 1 || !(is_numeric($item_id))) {
				$this->dataToSend['status']  = 'ERR';
		    	$this->dataToSend['msg'] 	 = 'Invalid Request';
		    	echo  json_encode($this->dataToSend);
		    	die();
			}

			if ($party_id == '' || $party_id < 1 || !(is_numeric($party_id))) {
				$this->dataToSend['status']  = 'ERR';
		    	$this->dataToSend['msg'] 	 = 'Invalid Request';
		    	echo  json_encode($this->dataToSend);
		    	die();
			}

			if ($freeze_quantity == '' || $freeze_quantity < 1 || !(is_numeric($freeze_quantity))) {
				$this->dataToSend['status']  = 'ERR';
		    	$this->dataToSend['msg'] 	 = 'Freeze quantity is required.';
		    	echo  json_encode($this->dataToSend);
		    	die();
			}

			$item_data = $this->stock->get_item_qnty($item_id);
            //_dx($item_data);
            if(!empty($item_data)){
                if ($item_data[0]['available_stock'] < $freeze_quantity) {
                	$this->dataToSend['status']  = 'ERR';
		    	    $this->dataToSend['msg'] 	 = 'Freeze quantity should be less than '.$item_data[0]['available_stock'] ;
		    	    echo  json_encode($this->dataToSend);
		    	    die();
                }
            }else{
                $this->dataToSend['status']  = 'ERR';
		    	$this->dataToSend['msg'] 	 = 'Invalid Request';
		    	echo  json_encode($this->dataToSend);
		    	die();	
            }

	        $dataToInsert 	= array(

								'item_id' 	=> $item_id,
								'party_id' 	=> $party_id,
								'freeze_quantity' 	=> $freeze_quantity,
								'status' =>'PENDING'
							);

			$res = $this->misc->insertData($dataToInsert,'freeze_tbl');
			if ($res['results']) {
				$this->dataToSend['msg'] 	= 'Freeze request added successfully';
			}else{
				$this->dataToSend['status'] = 'ERR';
		    	$this->dataToSend['msg'] 	= 'something want wrong';
		    	
			}
			echo  json_encode($this->dataToSend);
		    die();
		    
	   }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  } 
    }

    //get similar item by id
    public function get_similar_item_by_id($id){
    	$auth_data = _checkAuth();
    	$id 		=	trim($id);
		if($id == '' || !(is_numeric($id)) || $id < 1){
			return redirect(site_url('stock'));
			die();
		}

		if($auth_data['status']){
		  $this->dataToSend['result'] 	=	$this->stock->similar_item_by_id($id);
		  //_dx($this->dataToSend['result']);

		  if(!empty($this->dataToSend['result'])){
           $this->dataToSend['result'][0]['furnished_look'] = unserialize($this->dataToSend['result'][0]['furnished_look']);
		   }
		    $this->dataToSend['msg'] 		= "Data Found";
			echo json_encode($this->dataToSend);
			die();
        }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }
		
    }
    
    //get item by qrcode
    public function get_item_by_qrcode(){
    	$auth_data = _checkAuth();
    	
        $json = file_get_contents('php://input');
		$data = json_decode($json);
		if($json == ""){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid request, qrcode is required.';
			echo json_encode($this->dataToSend);
			die();
		}
		
		if (!isset($data->qrcode)) {
			
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'qrcode is required';
			echo json_encode($this->dataToSend);
			die();
		}
		$qrcode 	= $data->qrcode;

		if($qrcode == ''){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid qrcode.';
			echo json_encode($this->dataToSend);
			die();
		}

		if($auth_data['status']){
		  $this->dataToSend['result'] 	=	$this->stock->item_by_qrcode_for_party($qrcode,$auth_data['result']['partyId']);
		  //_dx($this->dataToSend['result']);

		  if(!empty($this->dataToSend['result'])){
           $this->dataToSend['result'][0]['furnished_look'] = unserialize($this->dataToSend['result'][0]['furnished_look']);
		   }
		    $this->dataToSend['msg'] 		= "Data Found";
			echo json_encode($this->dataToSend);
			die();
        }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }
		
    }

    //get distributed item by party
    public function get_distributed_item_by_party(){
    	$auth_data = _checkAuth();
    	
		if($auth_data['status']){
		  $this->dataToSend['result'] 	=	$this->stock->get_distributed_item_by_party($auth_data['result']['partyId'],1,100);
		  //_dx($this->dataToSend['result']);
		    $this->dataToSend['msg'] 		= "Data Found";
			echo json_encode($this->dataToSend);
			die();
        }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }
		
    }
    
    //get product grids
    public function get_product_grids(){
	  $auth_data = _checkAuth();
	  //_dx($auth_data);

	  if($auth_data['status']){
          //$grids = $this->misc->getAll('product_grid_tbl');
          $grids = $this->misc->getSelectedDataWithCondition('product_grid_tbl',array('*'),array('is_deleted' => 0));

          //_dx($grids);
          foreach ($grids as $key => $value) {
          	$grids[$key]['product_detail'] = $this->cms->get_grid_products($value['grid_id']);
          }

          $this->dataToSend['result']   = $grids;
		  $this->dataToSend['msg'] 		= 'Data Found';
		  echo json_encode($this->dataToSend);
		  die();
	  }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }	
	}

	//change password
    public function change_password(){
      $auth_data = _checkAuth();

      if($auth_data['status']){
        $json = file_get_contents('php://input');
		$data = json_decode($json);
		if($json == ""){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid request. Old password, new password and confirm password is required.';
			echo json_encode($this->dataToSend);
			die();
		}
		
		if (!isset($data->old_password) || !isset($data->new_password) || !isset($data->confirm_password)) {
			
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Old password, new password and confirm password is required.';
			echo json_encode($this->dataToSend);
			die();
		}
		
		$old_password 	= $data->old_password;
		$new_password 	= $data->new_password;
		$confirm_password 	= $data->confirm_password;

		if($old_password == '' || $new_password == '' || $confirm_password == ''){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid old password or new password or confirm password';
			echo json_encode($this->dataToSend);
			die();
		}

		if( $new_password != $confirm_password ){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'new password and confirm password should be same.';
			echo json_encode($this->dataToSend);
			die();
		}

		$res = $this->misc->isExist('party_tbl',array('party_id'=>$auth_data['result']['partyId'],'party_password'=> md5($old_password)));
		//_dx($res);

		if($res['status']){

             $update_result = $this->misc->update('party_tbl',array('party_password' => md5($new_password),'modified_at' => date('Y-m-d H:i:s')),array('party_id'=>$auth_data['result']['partyId']));

			if ($update_result['results']) {
				$this->dataToSend['msg'] 	= 'Password updated successfully';
			}else{
				$this->dataToSend['status'] = 'ERR';
		    	$this->dataToSend['msg'] 	= 'something want wrong';	
			}
		    echo  json_encode($this->dataToSend);
	        die();
		}else{
            $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Wrong old password.';
			echo json_encode($this->dataToSend);
			die();
		}
	     
	  }else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	  }	
	}

	//get data for filter
	public function data_for_filter(){
		$auth_data = _checkAuth();
        
        if($auth_data['status']){
			$this->dataToSend['item_colour'] 	=	$this->stock->get_all_uniq_value('item_colour');
			$this->dataToSend['item_type']  	=	$this->stock->get_all_uniq_value('item_type');
			$this->dataToSend['item_subtype'] 	=	$this->stock->get_all_uniq_value('item_subtype');
			$this->dataToSend['item_design'] 	=	$this->stock->get_all_uniq_value('item_design');
			$this->dataToSend['item_location'] 	=	$this->stock->get_all_uniq_value('item_location');

		    $this->dataToSend['msg'] 		= 'Data Found';
		    echo json_encode($this->dataToSend);
		    die();
		}else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	    }

	}

    //get filtered items
	public function get_filtered_items(){
		$auth_data = _checkAuth();

		$json = file_get_contents('php://input');
		$data = json_decode($json);
		if($json == ""){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid request, data is required.';
			echo json_encode($this->dataToSend);
			die();
		}
		
		if (!isset($data->data)) {
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'data is required';
			echo json_encode($this->dataToSend);
			die();
		}
		$data 	= $data->data;

		if($data == ''){
			$this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= 'Invalid data.';
			echo json_encode($this->dataToSend);
			die();
		}

		//_dx($data);
        
        if($auth_data['status']){
        	$temp = (array) $data;
        	//_dx((empty($temp)));
			if(!empty($temp)){
	           $this->dataToSend['result'] = $this->stock->get_all_item(1,100,"", $data->item_price_to,$data->item_price_from,$data->item_quantity_to,$data->item_quantity_from,$data->item_type,$data->item_subtype,$data->item_design,$data->item_colour,$data->item_location,$data->purchase_date_to ,$data->purchase_date_from );
			}else{
			   $this->dataToSend['result'] = $this->stock->get_all_item(1,100);
			}

			echo json_encode($this->dataToSend);
			die();
		}else{
	  	    $this->dataToSend['status'] 	= 'ERR';
			$this->dataToSend['msg'] 		= $auth_data['msg'];
			echo json_encode($this->dataToSend);
			die();
	    }
	}
	
}
