<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Guest extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('guest_model');
		$this->load->model('guestbook_model');
	}

	public function index()
	{
		
		if(!$this->input->post())
		{
			$this->load->view('guest');
		}
		else
		{
			$cek_guest=$this->guest_model->cek_member(
				$this->input->post('id_number'),
				$this->input->post('name')
				);
			if(!empty($cek_guest))
			{
				date_default_timezone_set("Asia/Bangkok");
				$data=array(
		            'member_id' => $cek_guest->member_id,
		            'date'		=> date("Y-m-d"),
		            'time'		=> date("H.i")
		        );
		        $this->guestbook_model->data_adding($data);
				$this->session->set_flashdata('name', $this->input->post('name'));
				redirect("/");
			}
			else 
			{
				$this->session->set_flashdata('guest_message','Silahkan daftarkan pengunjung baru');
				$this->session->set_flashdata('id_number', $this->input->post('id_number'));
				$this->session->set_flashdata('name', $this->input->post('name'));
				redirect("/");
			}
		}
	}

    public function register_action()
    {
		$data=array(
            'id_number'  => $this->input->post('id_number'),
            'name'      => $this->input->post('name'),
            'sex'      => $this->input->post('sex'),
            'occupation'    => $this->input->post('occupation'),
            'instance' => $this->input->post('instance'),
            'address' => $this->input->post('address')
        );
        $this->guest_model->data_adding($data);
        $this->session->set_flashdata('input_success', 'Data baru berhasil ditambahkan');
        redirect(site_url('/'));
    }
}

?>