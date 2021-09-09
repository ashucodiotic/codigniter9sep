<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Industry extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		//_lgnChk($this,'admin');
		$this->load->model('Industry_model','industry');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	public function index(){
        $this->dataToSend['result'] = $this->industry->get_all_industry(1,10,"");
		$this->load->view('industry/industries',$this->dataToSend);
	}

	public function get_all_industries(){
		$page = $this->input->post('page');
		$limit= $this->input->post('limit');
		$query= $this->input->post('query');
		//_dx($page);

        $this->dataToSend['result'] 	=	$this->industry->get_all_industry($page,$limit,$query);
        
		echo json_encode($this->dataToSend);
	}

	public function add_industry(){
		$this->load->view('industry/addIndustry');
	}

	public function create_industry(){
		$industry_name = $this->input->post('industry_name');
		$is_active= $this->input->post('is_active');
		$show_on_front= $this->input->post('show_on_front');
        $is_popular= $this->input->post('is_popular');
		$industry_img = "";

		// print_r($_FILES);
		// _dx($_FILES);

		if($_FILES['industry_img']['error'] == 0 && $_FILES['industry_img']['size'] != 0){

           if($_FILES['industry_img']['type'] != 'image/jpeg' && $_FILES['industry_img']['type'] != 'image/jpg' && $_FILES['industry_img']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['industry_img']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['industry_img']['name']));
        		$industry_name_updated = str_replace("/","_",$industry_name);
        		$industry_name_updated = str_replace(" ","_",$industry_name_updated);
        		//  $path = "assets/uploads/industry_image/".$industry_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];
				 $path = $industry_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];
				
				 $awspath=uploadS3Image($_FILES['industry_img']["tmp_name"],$path);
				
                // move_uploaded_file($_FILES['industry_img']["tmp_name"],$path);

                // $industry_img = $path;
				 $industry_img = $awspath;
		}
        
        $result = $this->misc->insertData(array(
        	                                     "industry_name"=>$industry_name,
        	                                     "is_active"=>$is_active,
        	                                     "show_on_front"=>$show_on_front,
        	                                     "industry_img"=>$industry_img,
                                                 "is_popular"=> $is_popular,
                                                ), 'industry_tbl');

        if($result['results']){
           $this->dataToSend['msg'] = "Industry added successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();

	}

	public function delete_industry(){
		$id = $this->input->post('id');

        $result 	=	$this->misc->update('industry_tbl',array('is_deleted'=>1),array('industry_id'=>$id));
        //_dx($result);
		if($result['results']){
           $this->dataToSend['msg'] = "Industry deleted successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();
	}

	public function view_industry($Id){
        $this->dataToSend['industry'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('*'),array('industry_id'=>$Id));
		$this->load->view('industry/viewIndustry',$this->dataToSend);
	}

	public function edit_industry($Id){
        $this->dataToSend['industry'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('*'),array('industry_id'=>$Id));		
        $this->load->view('industry/editIndustry',$this->dataToSend);
	}

	public function update_industry($Id){
		$industry_name = $this->input->post('industry_name');
		$is_active= $this->input->post('is_active');
		$show_on_front= $this->input->post('show_on_front');
        $is_popular= $this->input->post('is_popular');
		$industry_img = "";
		//_dx($_FILES);

		if($_FILES['industry_img']['error'] == 0 && $_FILES['industry_img']['size'] != 0){

           if($_FILES['industry_img']['type'] != 'image/jpeg' && $_FILES['industry_img']['type'] != 'image/jpg' && $_FILES['industry_img']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['industry_img']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['industry_img']['name']));
        		$industry_name_updated = str_replace("/","_",$industry_name);
        		$industry_name_updated = str_replace(" ","_",$industry_name_updated);
				$path = $industry_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];
			
				$awspath=uploadS3Image($_FILES['industry_img']["tmp_name"],$path);
				// _dx($awspath);
        		// $path = "assets/uploads/industry_image/".$industry_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                // move_uploaded_file($_FILES['industry_img']["tmp_name"],$path);

                $industry_img = $awspath;
		}

		$exist = $this->misc->isExist('industry_tbl',array('industry_id'=>$Id));

		if($exist['status'] == false){
	         $this->dataToSend['msg'] = "Something went wrong.";
	         $this->dataToSend['status'] = 'ERR';
	         echo json_encode($this->dataToSend);
	         die();
		}
        
        if($industry_img){
        	$result = $this->misc->update('industry_tbl',array(
        	                                     "industry_name"=>$industry_name,
        	                                     "is_active"=>$is_active,
        	                                     "show_on_front"=>$show_on_front,
        	                                     "industry_img"=>$industry_img,
                                                 "is_popular"=> $is_popular,
                                                 'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('industry_id'=>$Id));
        }else{
            $result = $this->misc->update('industry_tbl',array(
        	                                     "industry_name"=>$industry_name,
        	                                     "is_active"=>$is_active,
                                                 "is_popular"=> $is_popular,
        	                                     "show_on_front"=>$show_on_front,
                                                 'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('industry_id'=>$Id));
        }
        
       $this->dataToSend['msg'] = "Industry updated successfully.";
       echo json_encode($this->dataToSend);
       die();
      
	}

    public function popular_industries(){
        $this->dataToSend['result'] = $this->industry->get_all_popular_industry(1,10,"");
        $this->load->view('industry/popularIndustries',$this->dataToSend);
    }

    public function get_all_popular_industries(){
        $page = $this->input->post('page');
        $limit= $this->input->post('limit');
        $query= $this->input->post('query');
        //_dx($page);

        $this->dataToSend['result']     =   $this->industry->get_all_popular_industry($page,$limit,$query);
        
        echo json_encode($this->dataToSend);
    }
}
