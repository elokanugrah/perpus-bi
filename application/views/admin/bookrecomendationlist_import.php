<?php $this->load->view('headerfooter/header_admin'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data
        <small>pengajuan buku</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('BookRecomendationList') ?>"><i class="fa fa-table"></i> Buku yang diajukan</a></li>
        <li class="<?php echo active_link('BookRecomendationList') ?>"><a href="#">Import</a></li>
      </ol>
    </section>

    <div class="col-xs-12">
      <?php if(isset($_POST['preview'])){ ?>
      <div class='alert alert-danger alert-dismissible' style='margin-top:30px;' id='kosong' hidden>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <i class='icon fa fa-times-circle'></i><span id='data_failed'></span>
      </div>
      <div class="alert alert-info alert-dismissible" style="margin-top:30px;" id='ada' hidden>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fa fa-check-circle"></i>Silahkan cek data yang akan diimport
      </div>
      <?php } ?>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pengunjung Perpustakaan</h3>
              <a href="<?php echo site_url('excel/format_bookrquest.xlsx') ?>" class="btn btn-success btn-sm badge mt-1 pull-right"><span class="fa fa-file-excel-o" style="padding-right: 4px;"></span> Download Format</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="post" action="<?php echo site_url('BookRecomendationList/form'); ?>" enctype="multipart/form-data">
                <!-- 
                -- Buat sebuah input type file
                -- class pull-left berfungsi agar file input berada di sebelah kiri
                -->
                <div class="row">
                  <div class="col-md-12 form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-files-o"></i>
                      </div>
                      <input type="file" class="form-control" name="file" id="file-selector" required>
                      <div class="input-group-addon">
                        <button type="submit" name="preview" value="Preview" class="btn btn-info badge btn-sm mt-1">Preview</button>
                        <a href="<?php echo site_url('BookRecomendationList/import_data') ?>" class="btn btn-default btn-sm badge mt-1">Reset</a>
                      </div>
                    </div>
                    <span style="font-size: 13px; color: #999;">Tipe file yang diizinkan: xlsx (maks : 1 MB)</span>
                  </div>
                </div>
                <!--
                -- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
                -->
              </form>
              <?php
                $kosong = 0;
                $numrow = 1;
                $button = 0;
                  
                if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
                  if(isset($upload_error)){ // Jika proses upload gagal
                    echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
                    die; // stop skrip
                  }
                  
                  // Buat sebuah tag form untuk proses import data ke database
                  echo "<form method='post' action='".site_url('BookRecomendationList/import')."'>";
                  
                  echo "<table class='table table-bordered'>
                  <tr>
                    <th>Nomor Identitas Pengaju</th>
                    <th>Nama Pengaju</th>
                    <th>Jenis</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Versi/Episode</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Tanggal Pengajuan</th>
                  </tr>";
                  
                  // Lakukan perulangan dari data yang ada di excel
                  // $sheet adalah variabel yang dikirim dari controller
                  foreach($sheet as $row){ 
                    // Ambil data pada excel sesuai Kolom
                    $id_number = $row['A']; // Ambil data NIS
                    $name = $row['B']; // Ambil data nama
                    $type = $row['C']; // Ambil data jenis kelamin
                    $title = $row['D']; // Ambil data jenis kelamin
                    $author = $row['E'];
                    $version = $row['F'];
                    $publisher = $row['G'];
                    $publication_year = $row['H'];
                    $date = $row['I'];
                    $cek_guest=$this->Guest_model->cek_member(
                        $row['A'],
                        $row['B']
                    );
                    if(!empty($cek_guest))
                    {
                        $member_id=$cek_guest->member_id;
                    }
                    else 
                    {
                        $member_id=null;
                    }
                    // Cek jika semua data tidak diisi
                    if(empty($member_id) && empty($id_number) && empty($name) && empty($type) && empty($title) && empty($author) && empty($version) && empty($publisher) && empty($publication_year) && empty($date))
                      continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                    
                    // Cek $numrow apakah lebih dari 1
                    // Artinya karena baris pertama adalah nama-nama kolom
                    // Jadi dilewat saja, tidak usah diimport
                    if($numrow > 1){
                      // Validasi apakah semua data telah diisi
                      if(! empty($member_id)){
                        $id_number_td = ( ! empty($id_number))? "" : " class='bg-red-active color-palette'"; // Jika NIS kosong, beri warna merah
                        $name_td = ( ! empty($name))? "" : " class='bg-red-active color-palette'"; 
                      } else {
                        $id_number_td = " class='bg-red-active color-palette'"; // Jika NIS kosong, beri warna merah
                        $name_td = " class='bg-red-active color-palette'";
                        $button++;
                      }
                      // Jika Nama kosong, beri warna merah
                      $type_td = ( ! empty($type))? "" : " class='bg-red-active color-palette'"; // Jika Jenis Kelamin kosong, beri warna merah
                      $title_td = ( ! empty($title))? "" : " class='bg-red-active color-palette'"; // Jika Alamat kosong, beri warna merah
                      $author_td = ( ! empty($author))? "" : " class='bg-red-active color-palette'";
                      $publisher_td = ( ! empty($publisher))? "" : " class='bg-red-active color-palette'";
                      $date_td = ( ! empty($date))? "" : " class='bg-red-active color-palette'";
                      
                      // Jika salah satu data ada yang kosong
                      if(empty($id_number) or empty($name) or empty($type) or empty($title) or empty($author) or empty($publisher) or empty($date)){
                        $kosong++; // Tambah 1 variabel $kosong
                      }
                      
                      echo "<tr>";
                      echo "<td".$id_number_td.">".$id_number."</td>";
                      echo "<td".$name_td.">".$name."</td>";
                      echo "<td".$type_td.">".$type."</td>";
                      echo "<td".$title_td.">".$title."</td>";
                      echo "<td".$author_td.">".$author."</td>";
                      echo "<td>".$version."</td>";
                      echo "<td".$publisher_td.">".$publisher."</td>";
                      echo "<td>".$publication_year."</td>";
                      echo "<td".$date_td.">".date("d M Y", strtotime($date))."</td>";
                      echo "</tr>";
                    }
                    
                    $numrow++; // Tambah 1 setiap kali looping
                  }
                  
                  echo "</table>";

                  echo "<button type='submit' name='import' id='btn-submit' class='btn btn-info pull-right'>Import</button>";
                  // Cek apakah variabel kosong lebih dari 0
                  // Jika lebih dari 0, berarti ada data yang masih kosong
                  echo "</form>";
                  }
                ?>  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('headerfooter/footer_admin'); ?>
<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<?php if($kosong > 0) { ?>
<script>
  $(function(){
    // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
    $("#data_failed").html('Ada <?php echo $kosong; ?> field yang kosong!');
    
    $("#kosong").show(); // Munculkan alert validasi kosong
    $("#ada").hide();
    $("#btn-submit").hide();
  })
</script>
<?php
} elseif($button > 0)  { ?>
<script>
  $(function(){
    // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
    $("#data_failed").html('Ada yang tidak terdaftar!');
    
    $("#kosong").show(); // Munculkan alert validasi kosong
    $("#ada").hide();
    $("#btn-submit").hide();
  })
</script>
<?php } else { ?>
<script>
  $(function(){
    $("#kosong").hide(); // Munculkan alert validasi kosong
    $("#ada").show();
    $("#btn-submit").show();
  })
</script>
<?php } ?>
</body>
</html>