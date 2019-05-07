<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Guest extends CI_Controller
{
    private $filename = "import_data_member";
	function __construct()
	{
		parent::__construct();
        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }
		$this->load->model('Guest_model');
        $this->load->model('Occupation_model');
	}

	public function index()
	{
		$guest=$this->Guest_model->ambil_data();
        $data=array(
            'data_guest'  => $guest,
            'action'        => site_url('Guest/edit_action'),
            'import'    => site_url('Guest/import_data')
        );
		$this->load->view('admin/guest_table',$data);
    }

    function edit($id)
	{
		$guest=$this->Guest_model->getdata_by_id($id);
    $occupation_data=$this->Occupation_model->getall_data();
    $data=array(
        'member_id'           => set_value('member_id',$guest->member_id),    
        'id_number'           => set_value('id_number',$guest->id_number),
        'name'          => set_value('name',$guest->name),
        'sex'  => set_value('sex',$guest->sex),
        'occupation'       => set_value('occupation',$guest->occupation),
        'instance'       => set_value('instance',$guest->instance),
        'address'       => set_value('address',$guest->address),
        'occupation_data' => $occupation_data,
        'action'    => site_url('Guest/edit_action')
    );
    $this->load->view('admin/guest_form',$data);
	}

    function edit_action()
    {
        $data=array(
            'id_number'  => $this->input->post('id_number'),
            'name'      => $this->input->post('name'),
            'sex'    => $this->input->post('sex'),
            'occupation' => $this->input->post('occupation'),
            'instance' => $this->input->post('instance'),
            'address' => $this->input->post('address')
        );
        $id=$this->input->post('member_id');
        $this->Guest_model->edit_data($id,$data);
        $this->session->set_flashdata('edit_success', 'Data dengan nomor identitas '.$this->input->post('id_number').' a/n '.$this->input->post('name').' berhasil diubah!');
        redirect(site_url('Guest'));
    }

    function delete($id)
    {
        $guest = $this->Guest_model->getdata_by_id($id);
        $this->Guest_model->delete_data($id);
        $this->session->set_flashdata('delete_success', 'Data dengan nomor identitas '.$guest->id_number.' a/n '.$guest->name.' berhasil dihapus!');
        redirect(site_url('Guest'));
    }

    public function import_data()
    {
        $this->load->view('admin/guest_import');
    }

    public function form()
    {
        $data = array(); // Buat variabel $data sebagai array

        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
          // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
          $upload = $this->Guest_model->upload_file($this->filename);
          
          if($upload['result'] == "success"){ // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
            
            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
            
            // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
            // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
            $data['sheet'] = $sheet; 
          }else{ // Jika proses upload gagal
            $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
          }
        }
        $this->load->view('admin/guest_import', $data);
    }

    public function import()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();

        $numrow = 1;
        foreach($sheet as $row){
          // Cek $numrow apakah lebih dari 1
          // Artinya karena baris pertama adalah nama-nama kolom
          // Jadi dilewat saja, tidak usah diimport
          if($numrow > 1){
            // Kita push (add) array data ke variabel data
            array_push($data, array(
              'id_number'=>$row['A'], // Insert data nis dari kolom A di excel
              'name'=>$row['B'], // Insert data nama dari kolom B di excel
              'sex'=>$row['C'], // Insert data jenis kelamin dari kolom C di excel
              'occupation'=>$row['D'], // Insert data alamat dari kolom D di excel
              'instance'=>$row['E'], // Insert data alamat dari kolom D di excel
              'address'=>$row['F'], // Insert data alamat dari kolom D di excel
            ));
          }
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->Guest_model->insert_multiple($data);
        $this->session->set_flashdata('input_success', 'Data pengunjung sebanyak '.count($data).' baris berhasil di import!');
        redirect("Guest"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }

    public function export()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Buku Tamu Perpustakaan BI')
                     ->setLastModifiedBy('Buku Tamu Perpustakaan BI')
                     ->setTitle("Pengunjung Perpustakaan")
                     ->setSubject("Pengunjung Perpustakaan")
                     ->setDescription("Laporan Data Pengunjung Perpustakaan")
                     ->setKeywords("Data Pengunjung Perpustakaan");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $style_no = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA Pengunjung PERPUSTAKAAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NOMOR IDENTITAS"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "STATUS"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "INSTANSI");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "ALAMAT");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data_guest = $this->Guest_model->ambil_data();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data_guest as $key => $row){ // Lakukan looping pada variabel siswa
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key+1);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->id_number);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->name);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row->sex);
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->occupation);
          $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row->instance);
          $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row->address);
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Pengunjung Perpustakaan");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Pengunjung.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
      }
}

?>