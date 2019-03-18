<?php 
	/**
	* 
	*/
	class Occupation_model extends CI_Model
	{
		public $nama_table	='occupation';
		public $id			='occupation_id';
		public $order		='ASC';

		function __construct()
		{
			parent::__construct();
		}

		function getall_data()
		{
			$this->db->order_by($this->id,$this->order);
			return $this->db->get($this->nama_table)->result();
		}
	}
	?>