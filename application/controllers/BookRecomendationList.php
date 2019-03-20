<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class BookrecomendationList extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Bookrecomendation_model');
	}

	public function index()
	{
		$booktype=$this->Bookrecomendation_model->get_data_group();
        $data=array(
            'data_booktype'  => $booktype,
            'data_bookrecomendation'  => '',
        );
		$this->load->view('admin/bookrecomendation_list',$data);
	}

	function type($tp)
    {
        $bookrecomendation=$this->Bookrecomendation_model->data_by_type($tp);
        $data=array(
            'data_bookrecomendation'  => $bookrecomendation
        );
        $this->load->view('admin/bookrecomendation_list',$data);
    }
}

?>