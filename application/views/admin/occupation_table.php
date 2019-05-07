<?php $this->load->view('headerfooter/header_admin'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data
        <small>status pekerjaan</small>
      </h1>
      <ol class="breadcrumb">
        <li class="<?php echo active_link('Occupation') ?>"><a href="#"><i class="fa fa-table"></i> Pekerjaan</a></li>
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
              <h3 class="box-title">Data Status Pekerjaan</h3>
              <a href="javascript:void(0)" onclick="add_row()" class="btn btn-primary btn-sm badge mt-1 pull-right" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Status Pekerjaan</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_occupation as $key => $row) {?>
                <tr>
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $row->occupation_name; ?></td>
                  <td align="center">
                    <a id="edit-data" href="javascript:void(0)" type="button" class="btn btn-info btn-sm badge mt-1"  onclick="edit_row('<?php echo $row->occupation_id; ?>', '<?php echo $row->occupation_name; ?>')"><i class="fa fa-pencil"></i></a>
                    <a id="delete-data" href="javascript:void(0)" type="button" class="btn btn-danger btn-sm badge mt-1"  onclick="delete_row('<?php echo $row->occupation_id; ?>', '<?php echo $row->occupation_name; ?>')"><i class="fa fa-trash"></i></a>
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
    <div class="modal fade" id="modal-occupation">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="form-occupation" role="form" action="" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="glyphicon glyphicon-briefcase"></i>
              </div>
              <input id="occupation_name" type="text" class="form-control" name="occupation_name" placeholder="Status Pekerjaan">
            </div>
          </div>
          <div class="modal-footer">
            <input id="occupation_id" name="occupation_id" value="" hidden>
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.content -->
    <div class="modal modal-danger fade" id="modal-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="form-delete" role="form" action="" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Hapus Data Pekerjaan</h4>
          </div>
          <div class="modal-body">
            <p>Yakin ingin menghapus status pekerjaan <span id="name"></span>?</p>
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

  function add_row()
  {
    $('#form-occupation')[0].reset(); // reset form on modals
    $('#form-occupation').attr('action', '<?php echo site_url('Occupation/add_action');?>');
    $('#modal-occupation').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Tambah Data Pekerjaan'); // Set title to Bootstrap modal title
  }

  function edit_row(id, name)
  {
    $('#form-occupation')[0].reset();
    $('#form-occupation').attr('action', '<?php echo site_url('Occupation/edit_action')?>');
    $('#modal-occupation').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Ubah Data Pekerjaan');
    $('#occupation_name').val(name);
    $('#occupation_id').val(id);
  }

  function delete_row(id, name)
  {
    $('#form-delete')[0].reset();
    $('#form-delete').attr('action', '<?php echo site_url('Occupation/delete/')?>' + id);
    $('#modal-delete').modal('show'); // show bootstrap modal when complete loaded
    $('#name').text(name);
  }
</script>
</body>
</html>