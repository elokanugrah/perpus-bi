<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('Login');
        }
        $this->load->model('Guestbook_model');
        $this->load->model('Guest_model');
        $this->load->model('Bookrecomendation_model');
    }

    public function index()
    {
        $dates = date("d-M-Y", strtotime('Monday this week')).' - '.date("d-M-Y");
        $start=date("d-m-Y", strtotime('Monday this week'));
        $end=date("d-m-Y");
        $date = date("Y-m-d", strtotime('Monday this week')).' - '.date("Y-m-d");
        $guest=$this->Guest_model->get_count();
        $visit=$this->Guestbook_model->get_count();
        $guestbook=$this->Guestbook_model->data_yearandcount();
        $countweek=$this->Guestbook_model->data_by_week();
        $countbook=$this->Bookrecomendation_model->count_data();
        $guestbookoccupation=$this->Guestbook_model->data_occupation($start, $end);
        $booktype=$this->Bookrecomendation_model->data_booktype($start, $end);
        $bookrec=$this->Bookrecomendation_model->getlimit_data_group();
        if(!$this->input->get())
        {
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupation,
                'data_booktype'  => $booktype,
                'data_bookrec'  => $bookrec,
                'data_countweek'  => $countweek,
                'data_countbook'  => $countbook,
                'guest' => $guest,
                'visit' => $visit,
                'date'  => $dates,
                'date1'  => $dates,
                'startt'   => $start,
                'endd'     => $end,
                'start1'   => $start,
                'end1'     => $end
            );
            $this->load->view('admin/dashboard',$data);
        }
        else
        {
            $start = date("Y-m-d", strtotime($this->input->get('start')));
            $end = date("Y-m-d", strtotime($this->input->get('end')));
            $start1 = date("Y-m-d", strtotime($this->input->get('start1')));
            $end1 = date("Y-m-d", strtotime($this->input->get('end1')));
            $guestbookoccupations=$this->Guestbook_model->data_occupation($start, $end);
            $booktypes=$this->Bookrecomendation_model->data_booktype($start1, $end1);
            $data=array(
                'data_guestbook'  => $guestbook,
                'data_guestbookoccuptaion'  => $guestbookoccupations,
                'data_booktype'  => $booktypes,
                'data_bookrec'  => $bookrec,
                'data_countweek'  => $countweek,
                'data_countbook'  => $countbook,
                'guest' => $guest,
                'visit' => $visit,
                'date' => date("d-M-Y", strtotime($start)).' - '.date("d-M-Y", strtotime($end)),
                'date1'  => date("d-M-Y", strtotime($start1)).' - '.date("d-M-Y", strtotime($end1)),
                'startt'   => $start,
                'endd'     => $end,
                'start1'   => $start,
                'end1'     => $end
            );
            $this->load->view('admin/dashboard',$data);
            unset ($_get);
        }
        
    }
}

?>