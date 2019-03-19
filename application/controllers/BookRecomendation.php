<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Bookrecomendation extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Booktype_model');
		$this->load->model('Guest_model');
		$this->load->model('Guestbook_model');
	}

	public function index()
	{
		date_default_timezone_set("Asia/Bangkok");
		if(!$this->input->post())
		{
			$booktype=$this->Booktype_model->getall_data();
			$data=array(
	            'data_booktype'  => $booktype
	            );
	        $this->load->view('book_recomendation',$data);
		}
		else
		{
			$cek_guest=$this->Guest_model->cek_member(
				$this->input->post('id_number'),
				$this->input->post('name')
				);
			if(!empty($cek_guest))
			{
				$cek_guestbook=$this->Guestbook_model->cek_member_today(
					$cek_guest->member_id,
					date("Y-m-d")
					);
				if(!empty($cek_guestbook))
				{
					$this->session->set_flashdata('message', 'Berhasil-berhasil hore!');
					redirect("BookRecomendation");
				}
				else 
				{
					$this->session->set_flashdata('message', 'Masuk ke buku tamu dulu bos!');
					redirect("BookRecomendation");
				}
			}
			else 
			{
				$this->session->set_flashdata('message','Silahkan daftarkan diri anda');
				redirect("BookRecomendation");
			}
		}
	}
}

?>