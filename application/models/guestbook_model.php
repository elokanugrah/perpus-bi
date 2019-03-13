<?php 
	/**
	* 
	*/
	class Guestbook_model extends CI_Model
	{
		public $nama_table	='guestbook';

		function __construct()
		{
			parent::__construct();
		}

		function data_adding($data)
		{
			return $this->db->insert($this->nama_table,$data);
		}
	}
	?>