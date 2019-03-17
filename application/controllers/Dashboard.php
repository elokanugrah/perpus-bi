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

        $dates = date("d-M-Y", strtotime('-6 days')).' - '.date("d-M-Y");
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
            $start = date("Y-m-d", strtotime(substr($this->input->post('date'), 0, 11)));
            $end = date("Y-m-d", strtotime(substr($this->input->post('date'), 14, 11)));
            $guestbookoccupations=$this->Guestbook_model->data_occupation($start.' - '.$end);
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupations,
                'dates'  => $start.' - '.$end,
                'date' => $this->input->post('date')
            );
            $this->load->view('admin/dashboard',$data);
        }
        
    }
}

?>