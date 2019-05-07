<?php 
	/**
	* 
	*/
	class Guest_model extends CI_Model
	{
		public $nama_table	='member';
		public $id			='member_id';
		public $order		='DESC';

		function __construct()
		{
			parent::__construct();
		}

		function ambil_data()
		{
			$this->db->order_by($this->id,$this->order);
			return $this->db->get($this->nama_table)->result();
		}

		function getdata_by_id($id)
		{
			$this->db->where($this->id,$id);
			return $this->db->get($this->nama_table)->row();
		}

		function get_count()
		{
			$this->db->order_by($this->id,$this->order);
			return $this->db->get($this->nama_table)->num_rows();
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