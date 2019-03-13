<?php 
	/**
	* 
	*/
	class login_model extends CI_Model
	{
		public $nama_table	='admin';

		function __construct()
		{
			parent::__construct();
		}

		function getUserByUname($username)
		{
			$this->db->where('username',$username);
			return $this->db->get($this->nama_table)->row();
		}
	}
	?>