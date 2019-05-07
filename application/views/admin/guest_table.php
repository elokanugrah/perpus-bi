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
        <li class="<?php echo active_link('GuestBookList') ?>"><a href="#"><i class="fa fa-table"></i> Pengunjung</a></li>
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
      <?php if ($this->session->has_userdata('edit_success')) { ?>
        <div class="alert alert-info alert-dismissible" style="margin-top:30px;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fa fa-check-circle"></i><?php echo $this->session->flashdata('edit_success'); ?>
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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pengunjung Perpustakaan</h3>
              <a href="<?php echo site_url('Guest/export') ?>" class="btn btn-info btn-sm badge mt-1 pull-right" style="margin-left: 20px;"><span class="fa fa-file-excel-o" style="padding-right: 4px;"></span> Export</a>
              <a href="<?php echo $import; ?>" class="btn btn-info btn-sm badge mt-1 pull-right"><span class="fa fa-file-excel-o" style="padding-right: 4px;"></span>Import</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
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
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $row->id_number; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->sex; ?></td>
                  <td><?php echo $row->occupation; ?></td>
                  <td><?php echo $row->instance; ?></td>
                  <td><?php echo $row->address; ?></td>
                  <td align="center">
                    <a href="<?php echo site_url('Guest/edit/'.$row->member_id) ?>"><button type="button" class="btn btn-info btn-sm badge mt-1"><i class="fa fa-pencil"></i></button></a>
                    <a id="delete-data" href="javascript:void(0)" type="button" class="btn btn-danger btn-sm badge mt-1"  onclick="delete_row('<?php echo $row->member_id; ?>' , '<?php echo $row->id_number; ?>', '<?php echo $row->name; ?>')"><i class="fa fa-trash"></i></a>
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
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <div class="modal modal-danger fade" id="modal-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="delete-row" role="form" action="" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Hapus Data Pengunjung</h4>
          </div>
          <div class="modal-body">
            <p>Yakin ingin menghapus pengunjung dengan nomor identitas <span id="id_number"></span> a/n <span id="name"></span>?</p>
            <small>Dengan menghapus data pengunjung tersebut maka data pengunjung pada buku tamu dan buku rekomendasi akan terhapus.</small>
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
    $('#delete-row').attr('action', '<?php echo site_url('Guest/delete/')?>' + id);
    $('#modal-delete').modal('show'); // show bootstrap modal when complete loaded
    $('#id_number').text(id_number);
    $('#name').text(name);
    $('#modal-delete')[0].reset(); // reset form on modals
  }
</script>
</body>
</html>