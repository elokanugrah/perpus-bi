<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Guest extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Guest_model');
	}

	public function index()
	{
		$guest=$this->Guest_model->ambil_data();
        $data=array(
            'data_guest'  => $guest,
            'button'        => 'Edit',
            'button_add'        => 'Tambah',
            'action'        => site_url('Guest/edit_action')
        );
		$this->load->view('admin/guest_table',$data);
    }
}

?>