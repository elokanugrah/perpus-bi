<?php $this->load->view('headerfooter/header_admin'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data
        <small>buku tamu / <?php echo $text; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if($text == 'tahun') {?>
        <?php foreach ($data_guestbook as $key => $row) {?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h1 style="font-weight: bold;"><?php echo $row->year; ?></h1>
            </div>
            <div class="icon">
              <i><?php echo $row->total; ?></i>
            </div>
            <br>
            <a href="<?php echo site_url('GuestBookList/year/'.$row->year); ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <?php }?>
        <!-- ./col -->
        <?php } else if($text == 'bulan') {?>
        <?php foreach ($data_guestbook as $key => $row) {?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <p><?php echo $text; ?></p>
              <h1 style="font-weight: bold;"><?php echo $row->month_name; ?></h1>
            </div>
            <div class="icon">
              <i><?php echo $row->total; ?></i>
            </div>
            <a href="<?php echo site_url('GuestBookList/month/'.$row->year.'/'.$row->month.'/'.$row->month_name); ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <?php }?>
        <!-- ./col -->
        <?php } else {?>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pengunjung Perpustakaan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nomor Identitas</th>
                  <th>Nama Pengunjung</th>
                  <th>Tanggal</th>
                  <th>Waktu</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_guestbook as $key => $row) {?>
                <tr>
                  <td><?php echo $row->id_number; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->date; ?></td>
                  <td><?php echo $row->time; ?></td>
                </tr>
                <?php }?>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- ./col -->
        <?php } ?>
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
  <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>