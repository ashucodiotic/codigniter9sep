<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		//_lgnChk($this,'admin');
		$this->load->model('Blog_model','blog');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	public function index(){
        $this->dataToSend['result'] = $this->blog->get_all_blog(1,10,"");
		$this->load->view('blog/blogs',$this->dataToSend);
	}

	public function get_all_blogs(){
		$page = $this->input->post('page');
		$limit= $this->input->post('limit');
		$query= $this->input->post('query');
		//_dx($page);

        $this->dataToSend['result'] 	=	$this->blog->get_all_blog($page,$limit,$query);
        
		echo json_encode($this->dataToSend);
	}

	public function add_blog(){
        $this->dataToSend['industry'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('*'),array('is_deleted'=>0));
		$this->load->view('blog/addblog',$this->dataToSend);
	}

	public function create_blog(){
		$blog_title = $this->input->post('blog_title');
        $url_key = $this->input->post('url_key');
        $date = $this->input->post('date');
        $industry_id = $this->input->post('industry_id');
        $short_description = $this->input->post('short_description');
        $description = $this->input->post('description');
        $meta_description = $this->input->post('meta_description');
        $meta_keywords = $this->input->post('meta_keywords');
        $status= $this->input->post('status');
        $show_on_front= $this->input->post('show_on_front');
        $blog_img = "";
		//_dx($_FILES);

		if($_FILES['blog_img']['error'] == 0 && $_FILES['blog_img']['size'] != 0){

           if($_FILES['blog_img']['type'] != 'image/jpeg' && $_FILES['blog_img']['type'] != 'image/jpg' && $_FILES['blog_img']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['blog_img']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['blog_img']['name']));
        		$blog_name_updated = str_replace("/","_",$url_key);
        		$blog_name_updated = str_replace(" ","_",$blog_name_updated);
        		$path = "assets/uploads/blog_image/".$blog_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['blog_img']["tmp_name"],$path);

                $blog_img = $path;
		}
        
        $result = $this->misc->insertData(array(
        	                                    'blog_title'=>$blog_title,
                                                'url_key'=>$url_key,
                                                'date'=>$date,
                                                'industry_id'=>$industry_id,
                                                'blog_img'=>$blog_img,
                                                'short_description'=>$short_description,
                                                'description'=>$description,
                                                'meta_description'=>$meta_description,
                                                'meta_keywords'=>$meta_keywords,
                                                'show_on_front'=>$show_on_front,
                                                'status'=>$status
                                                ), 'blog_tbl');

        if($result['results']){
           $this->dataToSend['msg'] = "blog added successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();

	}

	public function delete_blog(){
		$id = $this->input->post('id');

        $result 	=	$this->misc->delete('blog_tbl',array('blog_id'=>$id));
        //_dx($result);
		if($result['results']){
           $this->dataToSend['msg'] = "blog deleted successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();
	}

	public function view_blog($Id){
        $this->dataToSend['blog'] = $this->misc->getSelectedDataWithCondition('blog_tbl',array('*'),array('blog_id'=>$Id));
		$this->load->view('blog/viewblog',$this->dataToSend);
	}

	public function edit_blog($Id){
        $this->dataToSend['industry'] = $this->misc->getSelectedDataWithCondition('industry_tbl',array('*'),array('is_deleted'=>0));
        $this->dataToSend['blog'] = $this->misc->getSelectedDataWithCondition('blog_tbl',array('*'),array('blog_id'=>$Id));		
        $this->load->view('blog/editblog',$this->dataToSend);
	}

	public function update_blog($Id){
		$blog_title = $this->input->post('blog_title');
        $url_key = $this->input->post('url_key');
        $date = $this->input->post('date');
        $industry_id = $this->input->post('industry_id');
        $short_description = $this->input->post('short_description');
        $description = $this->input->post('description');
        $meta_description = $this->input->post('meta_description');
        $meta_keywords = $this->input->post('meta_keywords');
        $status= $this->input->post('status');
        $show_on_front= $this->input->post('show_on_front');
        $blog_img = "";
		//_dx($_FILES);

		if($_FILES['blog_img']['error'] == 0 && $_FILES['blog_img']['size'] != 0){

           if($_FILES['blog_img']['type'] != 'image/jpeg' && $_FILES['blog_img']['type'] != 'image/jpg' && $_FILES['blog_img']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['blog_img']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['blog_img']['name']));
        		$blog_name_updated = str_replace("/","_",$url_key);
        		$blog_name_updated = str_replace(" ","_",$blog_name_updated);
        		$path = "assets/uploads/blog_image/".$blog_name_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['blog_img']["tmp_name"],$path);

                $blog_img = $path;
		}

		$exist = $this->misc->isExist('blog_tbl',array('blog_id'=>$Id));

		if($exist['status'] == false){
	         $this->dataToSend['msg'] = "Something went wrong.";
	         $this->dataToSend['status'] = 'ERR';
	         echo json_encode($this->dataToSend);
	         die();
		}
        
        if($blog_img){
        	$result = $this->misc->update('blog_tbl',array(
        	                                     'blog_title'=>$blog_title,
                                                'url_key'=>$url_key,
                                                'date'=>$date,
                                                'industry_id'=>$industry_id,
                                                'blog_img'=>$blog_img,
                                                'short_description'=>$short_description,
                                                'description'=>$description,
                                                'meta_description'=>$meta_description,
                                                'meta_keywords'=>$meta_keywords,
                                                'show_on_front'=>$show_on_front,
                                                'status'=>$status,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('blog_id'=>$Id));
        }else{
            $result = $this->misc->update('blog_tbl',array(
        	                                     'blog_title'=>$blog_title,
                                                'url_key'=>$url_key,
                                                'date'=>$date,
                                                'industry_id'=>$industry_id,
                                                'short_description'=>$short_description,
                                                'description'=>$description,
                                                'meta_description'=>$meta_description,
                                                'meta_keywords'=>$meta_keywords,
                                                'show_on_front'=>$show_on_front,
                                                'status'=>$status,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('blog_id'=>$Id));
        }
        
       $this->dataToSend['msg'] = "blog updated successfully.";
       echo json_encode($this->dataToSend);
       die();
      
	}
}
