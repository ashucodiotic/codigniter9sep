<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		//_lgnChk($this,'admin');
		$this->load->model('Client_model','client');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	public function index(){
        $this->dataToSend['result'] = $this->client->get_all_client(1,10,"");
		$this->load->view('client/clients',$this->dataToSend);
	}

	public function add_client(){
		$this->load->view('client/addClient');
	}

	public function get_all_clients(){
		$page = $this->input->post('page');
		$limit= $this->input->post('limit');
		$query= $this->input->post('query');
		//_dx($page);

        $this->dataToSend['result'] 	=	$this->client->get_all_client($page,$limit,$query);
        
		echo json_encode($this->dataToSend);
	}

	public function create_client(){
		$client_name = $this->input->post('client_name');
        $client_mobile = $this->input->post('client_mobile');
        $client_email = $this->input->post('client_email');
        $client_img = "";
		//_dx($_FILES);

		if($_FILES['client_img']['error'] == 0 && $_FILES['client_img']['size'] != 0){

           if($_FILES['client_img']['type'] != 'image/jpeg' && $_FILES['client_img']['type'] != 'image/jpg' && $_FILES['client_img']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['client_img']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['client_img']['name']));
        		$client_name_updated = str_replace("/","_",$client_name);
        		$client_name_updated = str_replace(" ","_",$client_name_updated);

               
        		// $path = "assets/uploads/client_image/".$client_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];
				$path = $client_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];
                // move_uploaded_file($_FILES['client_img']["tmp_name"],$path);
				$awspath=uploadS3Image($_FILES['client_img']["tmp_name"],$path);

                // $client_img = $path;
				$client_img = $awspath;
		}
        
        $result = $this->misc->insertData(array(
        	                                    'client_name'=>$client_name,
                                                'client_mobile'=>$client_mobile,
                                                'image'=>$client_img,
                                                'client_email'=>$client_email
                                                ), 'client_tbl');

        if($result['results']){
           $this->dataToSend['msg'] = "Client added successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();

	}

	public function delete_client(){
		$id = $this->input->post('id');

        $result 	=	$this->misc->update('client_tbl',array('is_deleted'=>1),array('client_id'=>$id));
        //_dx($result);
		if($result['results']){
           $this->dataToSend['msg'] = "Client deleted successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();
	}

	public function view_client($Id){
        $this->dataToSend['client'] = $this->misc->getSelectedDataWithCondition('client_tbl',array('*'),array('client_id'=>$Id));
		$this->load->view('client/viewClient',$this->dataToSend);
	}

	public function edit_client($Id){
        $this->dataToSend['client'] = $this->misc->getSelectedDataWithCondition('client_tbl',array('*'),array('client_id'=>$Id));		
        $this->load->view('client/editClient',$this->dataToSend);
	}

	public function update_client($Id){
		$client_name = $this->input->post('client_name');
        $client_mobile = $this->input->post('client_mobile');
        $client_email = $this->input->post('client_email');
        $client_img = "";
		//_dx($_FILES);

		if($_FILES['client_img']['error'] == 0 && $_FILES['client_img']['size'] != 0){

           if($_FILES['client_img']['type'] != 'image/jpeg' && $_FILES['client_img']['type'] != 'image/jpg' && $_FILES['client_img']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['client_img']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['client_img']['name']));
        		$client_name_updated = str_replace("/","_",$client_name);
        		$client_name_updated = str_replace(" ","_",$client_name_updated);
        		$path = "assets/uploads/client_image/".$client_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['client_img']["tmp_name"],$path);

                $client_img = $path;
		}

		$exist = $this->misc->isExist('client_tbl',array('client_id'=>$Id));

		if($exist['status'] == false){
	         $this->dataToSend['msg'] = "Something went wrong.";
	         $this->dataToSend['status'] = 'ERR';
	         echo json_encode($this->dataToSend);
	         die();
		}
        
        if($client_img){
        	$result = $this->misc->update('client_tbl',array(
        	                                    'client_name'=>$client_name,
                                                'client_mobile'=>$client_mobile,
                                                'image'=>$client_img,
                                                'client_email'=>$client_email,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('client_id'=>$Id));
        }else{
            $result = $this->misc->update('client_tbl',array(
        	                                    'client_name'=>$client_name,
                                                'client_mobile'=>$client_mobile,
                                                'client_email'=>$client_email,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('client_id'=>$Id));
        }
        
       $this->dataToSend['msg'] = "Client updated successfully.";
       echo json_encode($this->dataToSend);
       die();
      
	}

}
