<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Guestbook_model');
        $this->load->model('Guest_model');
        $this->load->model('Bookrecomendation_model');
        /*if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }*/
    }

    public function index()
    {

        $dates = date("d-M-Y", strtotime('-6 days')).' - '.date("d-M-Y");
        $date = date("Y-m-d", strtotime('-6 days')).' - '.date("Y-m-d");

        $guest=$this->Guest_model->get_count();
        $visit=$this->Guestbook_model->get_count();
        $guestbook=$this->Guestbook_model->data_yearandcount();
        $guestbookoccupation=$this->Guestbook_model->data_occupation($date);
        $booktype=$this->Bookrecomendation_model->data_booktype($date);
        if(!$this->input->post())
        {
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupation,
                'data_booktype'  => $booktype,
                'guest' => $guest,
                'visit' => $visit,
                'dates'  => $date,
                'dates1'  => $date,
                'date'  => $dates,
                'date1'  => $dates
            );
            $this->load->view('admin/dashboard',$data);
        }
        else
        {
            $start = date("Y-m-d", strtotime(substr($this->input->post('date'), 0, 11)));
            $end = date("Y-m-d", strtotime(substr($this->input->post('date'), 14, 11)));
            $start1 = date("Y-m-d", strtotime(substr($this->input->post('date1'), 0, 11)));
            $end1 = date("Y-m-d", strtotime(substr($this->input->post('date1'), 14, 11)));
            $guestbookoccupations=$this->Guestbook_model->data_occupation($start.' - '.$end);
            $booktypes=$this->Bookrecomendation_model->data_booktype($start1.' - '.$end1);
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupations,
                'data_booktype'  => $booktypes,
                'guest' => $guest,
                'visit' => $visit,
                'dates'  => $start.' - '.$end,
                'dates1'  => $start1.' - '.$end1,
                'date' => $this->input->post('date'),
                'date1'  => $this->input->post('date1')
            );
            $this->load->view('admin/dashboard',$data);
        }
        
    }
}

?>