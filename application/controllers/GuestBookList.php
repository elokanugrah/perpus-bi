<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class GuestBookList extends CI_Controller
{
    private $filename = "import_data_guestbook";
	function __construct()
	{
		parent::__construct();
        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('/');
        }
		$this->load->model('Guest_model');
		$this->load->model('Guestbook_model');
	}

	public function index()
	{
		$guestbook=$this->Guestbook_model->data_yearandcount();
        $data=array(
            'data_guestbook'  => $guestbook,
            'text'			=> 'tahun',
            'import'    => site_url('GuestBookList/import_data')
        );
		$this->load->view('admin/guestbook_list',$data);
	}

	function year($yr)
    {
        $guestbook=$this->Guestbook_model->data_monthcount($yr);
        $data=array(
            'data_guestbook'  => $guestbook,
            'text'			=> 'bulan'
        );
        $this->load->view('admin/guestbook_list',$data);
    }

    function month($yr, $mt, $mt_name)
    {
        $guestbook=$this->Guestbook_model->data_by_yearmonth($yr, $mt);
        $data=array(
            'data_guestbook'  => $guestbook,
            'text'			=> $mt_name . ' ' .$yr,
            'yr'          => $yr,
            'mt'          => $mt,
            'mt_name'          => $mt_name,
        );
        $this->load->view('admin/guestbook_list',$data);
    }

    function delete($id)
    {
        $guestbook = $this->Guestbook_model->getdata_by_id($id);
        $this->Guestbook_model->delete_data($id);
        $this->session->set_flashdata('delete_success', 'Data dengan nomor identitas '.$guestbook->id_number.' a/n '.$guestbook->name.' berhasil dihapus!');
        redirect(site_url('GuestBookList/month/'.$guestbook->year.'/'.$guestbook->month.'/'.$guestbook->month_name));
    }

    public function import_data()
    {
        $this->load->view('admin/guestbooklist_import');
    }

    public function form()
    {
        $data = array(); // Buat variabel $data sebagai array

        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
          // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
          $upload = $this->Guestbook_model->upload_file($this->filename);
          
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
        $this->load->view('admin/guestbooklist_import', $data);
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
            $cek_guest=$this->Guest_model->cek_member(
                $row['A'],
                $row['B']
            );
            if(!empty($cek_guest))
            {
                $member_id=$cek_guest->member_id;
                array_push($data, array(
                  'member_id'=>$member_id, // Insert data nis dari kolom A di excel
                  'date'=>date('Y-m-d',strtotime($row['C'])), // Insert data jenis kelamin dari kolom C di excel
                  'time'=>date('H:i',strtotime($row['D'])), // Insert data alamat dari kolom D di excel
                ));
            }
          }
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->Guestbook_model->insert_multiple($data);
        $this->session->set_flashdata('input_success', 'Data buku tamu sebanyak '.count($data).' baris berhasil di import!');
        redirect("GuestBookList"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }

    public function export_all()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Buku Tamu Perpustakaan BI')
                     ->setLastModifiedBy('Buku Tamu Perpustakaan BI')
                     ->setTitle("Buku Tamu Perpustakaan")
                     ->setSubject("Buku Tamu Perpustakaan")
                     ->setDescription("Laporan Data Buku Tamu Perpustakaan")
                     ->setKeywords("Data Buku Tamu Perpustakaan");
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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA BUKU TAMU PERPUSTAKAAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NOMOR IDENTITAS"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA PENGUNJUNG"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "TANGGAL"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "WAKTU"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data_guest = $this->Guestbook_model->ambil_data();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data_guest as $key => $row){ // Lakukan looping pada variabel siswa
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key+1);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->id_number);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->name);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, date("d M Y", strtotime($row->date)));
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->time);
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Buku Tamu Perpustakaan");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Buku Tamu.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
      }

    public function export_perdate($yr, $mt, $mt_name)
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Buku Tamu Perpustakaan BI')
                     ->setLastModifiedBy('Buku Tamu Perpustakaan BI')
                     ->setTitle("Buku Tamu Perpustakaan")
                     ->setSubject("Buku Tamu Perpustakaan")
                     ->setDescription("Laporan Data Buku Tamu Perpustakaan")
                     ->setKeywords("Data Buku Tamu Perpustakaan");
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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA BUKU TAMU PERPUSTAKAAN ".$mt_name." ".$yr); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NOMOR IDENTITAS"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA PENGUNJUNG"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "TANGGAL"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "WAKTU"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data_guest = $this->Guestbook_model->data_by_yearmonth($yr, $mt);
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data_guest as $key => $row){ // Lakukan looping pada variabel siswa
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key+1);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->id_number);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->name);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, date("d M Y", strtotime($row->date)));
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->time);
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Buku Tamu Perpustakaan");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Buku Tamu '.$mt_name.' '.$yr.'.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
      }
}

?>