<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class BookRecomendationList extends CI_Controller
{
  private $filename = "import_data_requestbook";
	function __construct()
	{
		parent::__construct();
        if(!$this->session->userdata('logined') || $this->session->userdata('logined') != true)
        {
            redirect('Login');
        }
		$this->load->model('Bookrecomendation_model');
        $this->load->model('Guest_model');
	}

	public function index()
	{
		$booktype=$this->Bookrecomendation_model->get_data_group();
        $data=array(
            'data_booktype'  => $booktype,
            'data_bookrecomendation'  => '',
            'import'    => site_url('BookRecomendationList/import_data')
        );
		$this->load->view('admin/bookrecomendation_list',$data);
	}

	function type($tp)
    {
        $bookrecomendation=$this->Bookrecomendation_model->data_by_type($tp);
        $data=array(
            'data_bookrecomendation'  => $bookrecomendation,
            'type'    => $tp
        );
        $this->load->view('admin/bookrecomendation_list',$data);
    }

    function delete($id)
    {
        $bookrecomendation = $this->Bookrecomendation_model->getdata_by_id($id);
        $this->Bookrecomendation_model->delete_data($id);
        $this->session->set_flashdata('delete_success', 'Data dengan judul '.$bookrecomendation->title.' berhasil dihapus!');
        redirect(site_url('BookRecomendationList/type/'.$bookrecomendation->type));
    }

    public function import_data()
    {
        $this->load->view('admin/bookrecomendationlist_import');
    }

    public function form()
    {
        $data = array(); // Buat variabel $data sebagai array

        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
          // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
          $upload = $this->Bookrecomendation_model->upload_file($this->filename);
          
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
        $this->load->view('admin/bookrecomendationlist_import', $data);
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
                  'member_id'=>$member_id,
                  'type'=>$row['C'],
                  'title'=>$row['D'],
                  'author'=>$row['E'],
                  'version'=>$row['F'],
                  'publisher'=>$row['G'],
                  'publication_year'=>$row['H'],
                  'date'=>date('Y-m-d',strtotime($row['I']))
                ));
            }
          }
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->Bookrecomendation_model->insert_multiple($data);
        $this->session->set_flashdata('input_success', 'Data pengajuan buku sebanyak '.count($data).' baris berhasil di import!');
        redirect("BookRecomendationList"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }

    public function export_all()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Buku Request Perpustakaan BI')
                     ->setLastModifiedBy('Buku Request Perpustakaan BI')
                     ->setTitle("Buku Request Perpustakaan")
                     ->setSubject("Buku Request Perpustakaan")
                     ->setDescription("Laporan Data Buku Request Perpustakaan")
                     ->setKeywords("Data Buku Request Perpustakaan");
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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PENGAJUAN BUKU PERPUSTAKAAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NOMOR IDENTITAS PENGAJU"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA PENGAJU"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "JUDUL"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "PENGARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "VERSI/EPISODE");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "PENERBIT");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "TAHUN TERBIT");
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "TANGGAL PENGAJUAN");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data_bookreq = $this->Bookrecomendation_model->getall_data();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data_bookreq as $key => $row){ // Lakukan looping pada variabel siswa
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key+1);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->id_number);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->name);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row->type);
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->title);
          $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row->author);
          $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row->version);
          $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row->publisher);
          $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row->publication_year);
          $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, date("d M Y", strtotime($row->date)));
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(27); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Pengajuan Buku");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Pengajuan Buku.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
      }

    public function export_pertype($type)
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Buku Request Perpustakaan BI')
                     ->setLastModifiedBy('Buku Request Perpustakaan BI')
                     ->setTitle("Buku Request Perpustakaan")
                     ->setSubject("Buku Request Perpustakaan")
                     ->setDescription("Laporan Data Buku Request Perpustakaan")
                     ->setKeywords("Data Buku Request Perpustakaan");
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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PENGAJUAN BUKU DENGAN JENIS ".strtoupper($type)); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NOMOR IDENTITAS PENGAJU"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA PENGAJU"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "JUDUL"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "PENGARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "VERSI/EPISODE");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "PENERBIT");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "TAHUN TERBIT");
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "TANGGAL PENGAJUAN");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data_guest = $this->Bookrecomendation_model->data_by_type($type);
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data_guest as $key => $row){ // Lakukan looping pada variabel siswa
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key+1);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->id_number);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->name);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row->type);
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->title);
          $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row->author);
          $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row->version);
          $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row->publisher);
          $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row->publication_year);
          $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, date("d M Y", strtotime($row->date)));
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_no);
          $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
          
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(27); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Pengajuan Buku ".$type);
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Pengajuan Buku '.$type.'.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
      }
}

?>