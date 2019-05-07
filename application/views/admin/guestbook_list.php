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
        <li class="<?php echo active_link('GuestBookList') ?>"><a href="#"><i class="fa fa-table"></i> Buku Tamu</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <div class="col-xs-12">
      <?php if ($this->session->has_userdata('input_success')) { ?>
        <div class="alert alert-success alert-dismissible" style="margin-top:30px;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-check-circle"></i><?php echo $this->session->flashdata('input_success'); ?>
        </div>
      <?php } ?>
      <?php if ($this->session->has_userdata('delete_success')) { ?>
      <div class="alert alert-danger alert-dismissible" style="margin-top:30px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fa fa-check-circle"></i><?php echo $this->session->flashdata('delete_success'); ?>
        </div>
      <?php } ?>
    </div>
    <section class="content">
      <div class="row">
        <?php if($text == 'tahun') {?>
          <div class="col-xs-12" style="padding-bottom: 16px;">
            <a href="<?php echo site_url('GuestBookList/export_all') ?>" class="btn btn-info btn-sm badge mt-1 pull-right" style="margin-left: 20px;"><span class="fa fa-file-excel-o" style="padding-right: 4px;"></span> Export Semua</a>
            <a href="<?php echo $import; ?>" class="btn btn-info btn-sm badge mt-1 pull-right"><span class="fa fa-file-excel-o" style="padding-right: 4px;"></span>Import</a>
          </div>
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
              <a href="<?php echo site_url('GuestBookList/export_perdate/'.$yr.'/'.$mt.'/'.$mt_name) ?>" class="btn btn-info btn-sm badge mt-1 pull-right" style="margin-left: 20px;"><span class="fa fa-file-excel-o" style="padding-right: 4px;"></span> Export <?php echo $text; ?></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Identitas</th>
                  <th>Nama Pengunjung</th>
                  <th>Tanggal</th>
                  <th>Waktu</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_guestbook as $key => $row) {?>
                <tr>
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $row->id_number; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo date("d M Y", strtotime($row->date)); ?></td>
                  <td><?php echo $row->time; ?></td>
                  <td align="center">
                    <a id="delete-data" href="javascript:void(0)" type="button" class="btn btn-danger btn-sm badge mt-1"  onclick="delete_row('<?php echo $row->guestbook_id; ?>', '<?php echo $row->id_number; ?>', '<?php echo $row->name; ?>')"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <?php }?>
                </tbody>
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
      <div class="modal modal-danger fade" id="modal-delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="delete-row" role="form" action="" method="post">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Data Buku Tamu</h4>
              </div>
              <div class="modal-body">
                <p>Yakin ingin menghapus pengunjung dengan nomor identitas <span id="id_number"></span> a/n <span id="name"></span> dari buku tamu?</p>
                <small>Dengan menghapus data pengunjung dari buku tamu maka data pengunjung tersebut akan terhapus dari buku tamu.</small>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Hapus</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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

  function delete_row(id, id_number, name)
  {
    $('#delete-row').attr('action', '<?php echo site_url('GuestBookList/delete/')?>' + id);
    $('#modal-delete').modal('show'); // show bootstrap modal when complete loaded
    $('#id_number').text(id_number);
    $('#name').text(name);
    $('#modal-delete')[0].reset(); // reset form on modals
  }
</script>
</body>
</html>