<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		//_lgnChk($this,'admin');
		$this->load->model('Report_model','report');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	public function index(){
        $this->dataToSend['result'] = $this->report->get_all_report(1,10,"");
		$this->load->view('report/reports',$this->dataToSend);
	}

	public function get_all_reports(){
		$page = $this->input->post('page');
		$limit= $this->input->post('limit');
		$query= $this->input->post('query');
		//_dx($page);

        $this->dataToSend['result'] 	=	$this->report->get_all_report($page,$limit,$query);
        
		echo json_encode($this->dataToSend);
	}

	public function add_report(){
        $this->dataToSend['industry'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('*'),array('is_deleted'=>0));
		$this->load->view('report/addReport', $this->dataToSend);
	}

	public function create_report(){
        $report_title = $this->input->post('report_title');
        $url_key = $this->input->post('url_key');
        $pub_id = $this->input->post('pub_id');
        $region = $this->input->post('region');
        $pages = $this->input->post('pages');
        $pub_status = $this->input->post('pub_status');
        $premium = $this->input->post('premium');
        $start_date = $this->input->post('start_date');
        $industry_id = $this->input->post('industry_id');
        $price = $this->input->post('price');
        $discount_price = $this->input->post('discount_price');
        $brief_intro = $this->input->post('brief_intro');
        $content_body = $this->input->post('content_body');
        $meta_description = $this->input->post('meta_description');
        $meta_keywords = $this->input->post('meta_keywords');
		$status= $this->input->post('status');
		$show_on_front= $this->input->post('show_on_front');
        $is_featured= $this->input->post('is_featured');
		$main_photo = "";
		//_dx($_FILES);

		if($_FILES['main_photo']['error'] == 0 && $_FILES['main_photo']['size'] != 0){

           if($_FILES['main_photo']['type'] != 'image/jpeg' && $_FILES['main_photo']['type'] != 'image/jpg' && $_FILES['main_photo']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['main_photo']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['main_photo']['name']));
        		$report_name_updated = str_replace("/","_",$url_key);
        		$report_name_updated = str_replace(" ","_",$report_name_updated);
        		$path = "assets/uploads/report_image/".$report_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['main_photo']["tmp_name"],$path);

                $main_photo = $path;
		}
        
        $result = $this->misc->insertData(array(
                                                'report_title'=>$report_title,
                                                'url_key'=>$url_key,
                                                'pub_id'=>$pub_id,
                                                'region'=>$region,
                                                'pages'=>$pages,
                                                'pub_status'=>$pub_status,
                                                'premium'=>$premium,
                                                'start_date'=>$start_date,
                                                'industry_id'=>$industry_id,
                                                'main_photo'=>$main_photo,
                                                'price'=>$price,
                                                'discount_price'=>$discount_price,
                                                'brief_intro'=>$brief_intro,
                                                'content_body'=>$content_body,
                                                'meta_description'=>$meta_description,
                                                'meta_keywords'=>$meta_keywords,
                                                'show_on_front'=>$show_on_front,
                                                'is_featured'=>$is_featured,
                                                'status'=>$status
                                                ), 'report_tbl');

        if($result['results']){
           $this->dataToSend['msg'] = "report added successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();

	}

	public function delete_report(){
		$id = $this->input->post('id');

        $result 	=	$this->misc->delete('report_tbl',array('report_id'=>$id));
        //_dx($result);
		if($result['results']){
           $this->dataToSend['msg'] = "Report deleted successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();
	}

	public function view_report($Id){
        $this->dataToSend['report'] = $this->misc->getSelectedDataWithCondition('report_tbl',array('*'),array('report_id'=>$Id));
		$this->load->view('report/viewReport',$this->dataToSend);
	}

	public function edit_report($Id){
        $this->dataToSend['report'] = $this->misc->getSelectedDataWithCondition('report_tbl',array('*'),array('report_id'=>$Id));
         $this->dataToSend['industry'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('*'),array('is_deleted'=>0));		
        $this->load->view('report/editReport',$this->dataToSend);
	}

	public function update_report($Id){
		$report_title = $this->input->post('report_title');
        $url_key = $this->input->post('url_key');
        $pub_id = $this->input->post('pub_id');
        $region = $this->input->post('region');
        $pages = $this->input->post('pages');
        $pub_status = $this->input->post('pub_status');
        $premium = $this->input->post('premium');
        $start_date = $this->input->post('start_date');
        $industry_id = $this->input->post('industry_id');
        $price = $this->input->post('price');
        $discount_price = $this->input->post('discount_price');
        $brief_intro = $this->input->post('brief_intro');
        $content_body = $this->input->post('content_body');
        $meta_description = $this->input->post('meta_description');
        $meta_keywords = $this->input->post('meta_keywords');
        $status= $this->input->post('status');
        $show_on_front= $this->input->post('show_on_front');
        $is_featured= $this->input->post('is_featured');
        $main_photo = "";
		//_dx($_FILES);

		if($_FILES['main_photo']['error'] == 0 && $_FILES['main_photo']['size'] != 0){

           if($_FILES['main_photo']['type'] != 'image/jpeg' && $_FILES['main_photo']['type'] != 'image/jpg' && $_FILES['main_photo']['type'] != 'image/png' ){
                    $this->dataToSend['status'] = 'ERR';
                    $this->dataToSend['msg']     = $_FILES['main_photo']['name']." file is not allowed, please upload only jpeg or jpg or png files";
                    echo  json_encode($this->dataToSend);
                    die();
                }

                $ext = (explode(".",$_FILES['main_photo']['name']));
                $report_name_updated = str_replace("/","_",$url_key);
                $report_name_updated = str_replace(" ","_",$report_name_updated);
                $path = "assets/uploads/report_image/".$report_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['main_photo']["tmp_name"],$path);

                $main_photo = $path;
        }

		$exist = $this->misc->isExist('report_tbl',array('report_id'=>$Id));

		if($exist['status'] == false){
	         $this->dataToSend['msg'] = "Something went wrong.";
	         $this->dataToSend['status'] = 'ERR';
	         echo json_encode($this->dataToSend);
	         die();
		}
        
        if($main_photo){
        	$result = $this->misc->update('report_tbl',array(
        	                                    'report_title'=>$report_title,
                                                'url_key'=>$url_key,
                                                'pub_id'=>$pub_id,
                                                'region'=>$region,
                                                'pages'=>$pages,
                                                'pub_status'=>$pub_status,
                                                'premium'=>$premium,
                                                'start_date'=>$start_date,
                                                'industry_id'=>$industry_id,
                                                'main_photo'=>$main_photo,
                                                'price'=>$price,
                                                'discount_price'=>$discount_price,
                                                'brief_intro'=>$brief_intro,
                                                'content_body'=>$content_body,
                                                'meta_description'=>$meta_description,
                                                'meta_keywords'=>$meta_keywords,
                                                'show_on_front'=>$show_on_front,
                                                'is_featured'=>$is_featured,
                                                'status'=>$status,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('report_id'=>$Id));
        }else{
            $result = $this->misc->update('report_tbl',array(
        	                                    'report_title'=>$report_title,
                                                'url_key'=>$url_key,
                                                'pub_id'=>$pub_id,
                                                'region'=>$region,
                                                'pages'=>$pages,
                                                'pub_status'=>$pub_status,
                                                'premium'=>$premium,
                                                'start_date'=>$start_date,
                                                'industry_id'=>$industry_id,
                                                'price'=>$price,
                                                'discount_price'=>$discount_price,
                                                'brief_intro'=>$brief_intro,
                                                'content_body'=>$content_body,
                                                'meta_description'=>$meta_description,
                                                'meta_keywords'=>$meta_keywords,
                                                'show_on_front'=>$show_on_front,
                                                'is_featured'=>$is_featured,
                                                'status'=>$status,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('report_id'=>$Id));
        }
        
       $this->dataToSend['msg'] = "Report updated successfully.";
       echo json_encode($this->dataToSend);
       die();
      
	}
}
