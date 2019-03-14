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

		function data_yearandcount()
		{
			$this->db->select("YEAR(date) AS year, COUNT(guestbook_id) AS total");
			$this->db->from($this->nama_table);
			$this->db->group_by('YEAR(date)');
			return $this->db->get()->result();
		}

		function data_monthandcount($yr)
		{
			$this->db->select("YEAR(date) AS year, MONTH(date) AS month, SUBSTRING('JAN FEB MAR APR MAY JUN JUL AUG SEP OCT NOV DEC ', (MONTH(date) * 4)- 3, 3) AS month_name, COUNT(guestbook_id) AS total");
			$this->db->from($this->nama_table);
			$this->db->where('YEAR(date)',$yr);
			$this->db->group_by('MONTH(date)');
			return $this->db->get()->result();
		}

		function data_by_yearmonth($yr, $mt)
		{
			$this->db->select("member.id_number, member.name, guestbook.date, guestbook.time");
			$this->db->from($this->nama_table);
			$this->db->join('member', 'member.member_id=guestbook.member_id');
			$this->db->where('YEAR(date)', $yr);
			$this->db->where('MONTH(date)', $mt);
			return $this->db->get()->result();
		}
	}
	?>