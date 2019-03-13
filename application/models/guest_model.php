<?php 
	/**
	* 
	*/
	class guest_model extends CI_Model
	{
		public $nama_table	='member';

		function __construct()
		{
			parent::__construct();
		}

		function cek_member($id_number, $name)
		{
			$this->db->where('id_number',$id_number);
			$this->db->where('name',$name);
			return $this->db->get($this->nama_table)->row();
		}

		function data_adding($data)
		{
			return $this->db->insert($this->nama_table,$data);
		}
		
		function get_by_idnumber($id)
		{
			$this->db->where('id_number',$id);
			return $this->db->get($this->nama_table)->row();
		}
	}
	?>