<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Misc_model','misc');
		//_lgnChk($this,'admin');
		// $this->load->model('Order_model','order');
		// $this->load->model('Party_model','party');
		// $this->load->model('Pending_order_model','pending_order');
		// $this->load->model('Inventory_model','stock');
		// $this->load->model('Inquiry_model','inquiry');
		$this->dataToSend = [];
        $this->dataToSend['status'] = 'OK';
	}

	public function index(){

		$this->load->view('dashboard/dashboard',$this->dataToSend);
	}

	public function routeNotFound(){
		$this->load->view('common/404');
	}
}
