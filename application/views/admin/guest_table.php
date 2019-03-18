<?php $this->load->view('headerfooter/header_admin'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data
        <small>pengunjung perpustakaan</small>
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
        <div class="col-xs-12">
          <?php if ($this->session->has_userdata('edit_success')) { ?>
          <div class="alert alert-info alert-dismissible" style="margin-top:30px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fa fa-check-circle"></i><?php echo $this->session->flashdata('edit_success'); ?>
            </div>
            <?php } ?>
        </div>
      </div>
      <div class="row">
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
                  <th>Nomor identitas</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Status</th>
                  <th>Instansi</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_guest as $key => $row) {?>
                <tr>
                  <td><?php echo $row->id_number; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->sex; ?></td>
                  <td><?php echo $row->occupation; ?></td>
                  <td><?php echo $row->instance; ?></td>
                  <td><?php echo $row->address; ?></td>
                  <td align="center">
                    <a href="<?php echo site_url('Guest/edit/'.$row->member_id) ?>"><button type="button" class="btn btn-info btn-sm badge mt-1"><i class="fa fa-pencil"></i></button></a>
                  </td>
                </tr>
                <?php }?>
                </tfoot>
              </table>
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