<?php 
	/**
	* 
	*/
	class Bookrecomendation_model extends CI_Model
	{
		public $nama_table	='bookrecomendation';
		public $id			='bookrecomendation_id';
		public $order		='DESC';

		function __construct()
		{
			parent::__construct();
		}

		function getall_data()
		{
			$this->db->select("member.member_id, member.id_number, member.name, bookrecomendation.bookrecomendation_id, bookrecomendation.type, bookrecomendation.title, bookrecomendation.author, bookrecomendation.version, bookrecomendation.publisher, bookrecomendation.publication_year, bookrecomendation.date");
			$this->db->join('member', 'member.member_id=bookrecomendation.member_id');
			$this->db->order_by($this->id,$this->order);
			return $this->db->get($this->nama_table)->result();
		}

		function getdata_by_id($id)
		{
			$this->db->where($this->id,$id);
			return $this->db->get($this->nama_table)->row();
		}

		function get_data_group()
		{
			$this->db->select("type, COUNT(bookrecomendation_id) AS total");
			$this->db->group_by('type');
			return $this->db->get($this->nama_table)->result();
		}

		function getlimit_data_group()
		{
			$this->db->select("type, COUNT(bookrecomendation_id) AS total");
			$this->db->group_by('type');
			$this->db->limit(5);
			$this->db->order_by("total",$this->order);
			return $this->db->get($this->nama_table)->result();
		}

		function count_data()
		{
			$this->db->select("COUNT(bookrecomendation_id) AS total");
			return $this->db->get($this->nama_table)->row();
		}

		function data_booktype($date)
		{
			$start = substr($date, 0, 10);
			$end = substr($date, 13, 10);
			$this->db->select("COUNT(bookrecomendation_id) AS total, type");
			$this->db->from($this->nama_table);
			$this->db->where('date >=', $start);
			$this->db->where('date <=', $end);
			$this->db->group_by('type');
			return $this->db->get()->result();
		}

		function booktitle_by_type($date, $type)
		{
			$start = substr($date, 0, 10);
			$end = substr($date, 13, 10);
			$this->db->select("COUNT(bookrecomendation_id) AS total, date, type, title");
			$this->db->from($this->nama_table);
			$this->db->where('date >=', $start);
			$this->db->where('date <=', $end);
			$this->db->where('type', $type);
			$this->db->group_by('title');
			return $this->db->get()->result();
		}

		function data_by_type($tp)
		{
			$this->db->select("member.member_id, member.id_number, member.name, bookrecomendation.bookrecomendation_id, bookrecomendation.type, bookrecomendation.title, bookrecomendation.author, bookrecomendation.version, bookrecomendation.publisher, bookrecomendation.publication_year, bookrecomendation.date");
			$this->db->join('member', 'member.member_id=bookrecomendation.member_id');
			$this->db->where('type', $tp);
			$this->db->order_by($this->id,$this->order);
			return $this->db->get($this->nama_table)->result();
		}

		function add_data($data)
		{
			return $this->db->insert($this->nama_table,$data);
		}

		function edit_data($id,$data)
		{
			$this->db->where($this->id,$id);
			$this->db->update($this->nama_table,$data);
		}

		function delete_data($id)
    	{
        	$this->db->where($this->id,$id);
        	$this->db->delete($this->nama_table);
    	}

    	// Fungsi untuk melakukan proses upload file
		public function upload_file($filename)
		{
			$this->load->library('upload'); // Load librari upload

			$config['upload_path'] = './excel/';
			$config['allowed_types'] = 'xlsx';
			$config['max_size']  = '1024';
			$config['overwrite'] = true;
			$config['file_name'] = $filename;

			$this->upload->initialize($config); // Load konfigurasi uploadnya
			if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			  // Jika berhasil :
			  $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			  return $return;
			}else{
			  // Jika gagal :
			  $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			  return $return;
			}
		}

		// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
		public function insert_multiple($data){
			$this->db->insert_batch($this->nama_table, $data);
		}
	}
	?>