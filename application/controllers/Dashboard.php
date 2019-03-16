<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Guestbook_model');
        /*if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }*/
    }

    public function index()
    {

        $dates = date("Y-m-d", strtotime('-7 days')).' - '.date("Y-m-d");
        $guestbook=$this->Guestbook_model->data_yearandcount();
        $guestbookoccupation=$this->Guestbook_model->data_occupation($dates);
        if(!$this->input->post())
        {
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupation,
                'date'  => $dates
            );
            $this->load->view('admin/dashboard',$data);
        }
        else
        {
            $guestbookoccupations=$this->Guestbook_model->data_occupation($this->input->post('date'));
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupations,
                'date'  => $this->input->post('date')
            );
            $this->load->view('admin/dashboard',$data);
        }
        
    } 
}

?>