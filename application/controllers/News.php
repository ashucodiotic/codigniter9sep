<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		//_lgnChk($this,'admin');
		$this->load->model('News_model','news');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	public function index(){
        $this->dataToSend['result'] = $this->news->get_all_news(1,10,"");
		$this->load->view('news/news',$this->dataToSend);
	}

	public function add_news(){
		$this->load->view('news/addnews');
	}

	public function get_all_news(){
		$page = $this->input->post('page');
		$limit= $this->input->post('limit');
		$query= $this->input->post('query');
		//_dx($page);

        $this->dataToSend['result'] 	=	$this->news->get_all_news($page,$limit,$query);
        
		echo json_encode($this->dataToSend);
	}

	public function create_news(){
		$news_text = $this->input->post('news_text');
        $news_title = $this->input->post('news_title');
        $news_date = $this->input->post('news_date');
        $image = "";
		//_dx($_FILES);

		if($_FILES['image']['error'] == 0 && $_FILES['image']['size'] != 0){

           if($_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['image']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['image']['name']));
        		$news_text_updated = str_replace("/","_",$news_text);
        		$news_text_updated = str_replace(" ","_",$news_text_updated);

               
        		$path = "assets/uploads/news_image/".$news_text_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['image']["tmp_name"],$path);

                $image = $path;
		}
        
        $result = $this->misc->insertData(array(
        	                                    'news_text'=>$news_text,
                                                'news_title'=>$news_title,
                                                'image'=>$image,
                                                'news_date'=>$news_date
                                                ), 'news_tbl');

        if($result['results']){
           $this->dataToSend['msg'] = "news added successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();

	}

	public function delete_news(){
		$id = $this->input->post('id');

        $result 	=	$this->misc->update('news_tbl',array('is_deleted'=>1),array('news_id'=>$id));
        //_dx($result);
		if($result['results']){
           $this->dataToSend['msg'] = "news deleted successfully.";
           echo json_encode($this->dataToSend);
           die();
        }

         $this->dataToSend['msg'] = "Something went wrong.";
         $this->dataToSend['status'] = 'ERR';
         echo json_encode($this->dataToSend);
         die();
	}

	public function view_news($Id){
        $this->dataToSend['news'] = $this->misc->getSelectedDataWithCondition('news_tbl',array('*'),array('news_id'=>$Id));
		$this->load->view('news/viewnews',$this->dataToSend);
	}

	public function edit_news($Id){
        $this->dataToSend['news'] = $this->misc->getSelectedDataWithCondition('news_tbl',array('*'),array('news_id'=>$Id));		
        $this->load->view('news/editnews',$this->dataToSend);
	}

	public function update_news($Id){
		$news_text = $this->input->post('news_text');
        $news_title = $this->input->post('news_title');
        $news_date = $this->input->post('news_date');
        $image = "";
		//_dx($_FILES);

		if($_FILES['image']['error'] == 0 && $_FILES['image']['size'] != 0){

           if($_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/png' ){
        			$this->dataToSend['status'] = 'ERR';
		    	    $this->dataToSend['msg'] 	 = $_FILES['image']['name']." file is not allowed, please upload only jpeg or jpg or png files";
		    	    echo  json_encode($this->dataToSend);
		    	    die();
        		}

        		$ext = (explode(".",$_FILES['image']['name']));
        		$news_text_updated = str_replace("/","_",$news_text);
        		$news_text_updated = str_replace(" ","_",$news_text_updated);
        		$path = "assets/uploads/news_image/".$news_text_updated."_".date('d_m_y')."_".date('h_i_s').".".$ext[1];

                move_uploaded_file($_FILES['image']["tmp_name"],$path);

                $image = $path;
		}

		$exist = $this->misc->isExist('news_tbl',array('news_id'=>$Id));

		if($exist['status'] == false){
	         $this->dataToSend['msg'] = "Something went wrong.";
	         $this->dataToSend['status'] = 'ERR';
	         echo json_encode($this->dataToSend);
	         die();
		}
        
        if($image){
        	$result = $this->misc->update('news_tbl',array(
        	                                    'news_text'=>$news_text,
                                                'news_title'=>$news_title,
                                                'image'=>$image,
                                                'news_date'=>$news_date,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('news_id'=>$Id));
        }else{
            $result = $this->misc->update('news_tbl',array(
        	                                    'news_text'=>$news_text,
                                                'news_title'=>$news_title,
                                                'news_date'=>$news_date,
                                                'updated_at'=>Date('Y-m-d H:i:s')
                                                ),array('news_id'=>$Id));
        }
        
       $this->dataToSend['msg'] = "news updated successfully.";
       echo json_encode($this->dataToSend);
       die();
      
	}

}
