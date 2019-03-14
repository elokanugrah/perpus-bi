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
        $guestbook=$this->Guestbook_model->data_yearandcount();
        $data=array(
            'data_guestbook'  => $guestbook
        );
        $this->load->view('admin/dashboard',$data);
    } 
}

?>