<?php $this->load->view('headerfooter/header_guest'); ?>

<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="<?php echo base_url() ?>assets/dist/img/perpustakaan.png" height="64">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Identitas Pengunjung Perpustakaan</p>
        <div class="main_panel">
            <form role="form" action="" method="post">
              <div class="form-group has-feedback">
                <input type="text" name="id_number" class="form-control" placeholder="Nomor identitas Pegawai/Pelajar" required>
                <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control" placeholder="Nama Pengunjung" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="social-auth-links">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
              <?php if ($this->session->has_userdata('name')) { ?>
               <div class="alert alert-success alert-dismissible" style="margin-top:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check-circle"></i>Selamat datang <?php echo $this->session->flashdata('name'); ?>
                </div>
              <?php } ?>
              <?php if ($this->session->has_userdata('input_success')) { ?>
                <div class="alert alert-success alert-dismissible" style="margin-top:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check-circle"></i><?php echo $this->session->flashdata('input_success'); ?>
                </div>
              <?php } ?>
          </div>
      </form>
  </div>
  <?php if ($this->session->has_userdata('guest_message')) { ?>
  <style type="text/css">
  div.main_panel
  {
    display:none;
}
</style>
<div class="second_panel">
    <form role="form" action="<?php echo site_url('Guest/register_action');?>" method="post">
      <div class="form-group has-feedback">
          <input type="text" name="id_number" class="form-control" placeholder="Nomor identitas Pegawai/Pelajar" value="<?php echo $this->session->flashdata('id_number'); ?>" required>
          <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="name" class="form-control" placeholder="Nama Pengunjung" value="<?php echo $this->session->flashdata('name'); ?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="social-auth-links text-center">
      <p>- <?php echo $this->session->flashdata('guest_message'); ?> -</p>
  </div>
  <div class="form-group has-feedback">
    <select class="form-control" name="sex" data-placeholder="Jenis Kelamin" style="width: 100%;" required>
        <option value="" disabled selected hidden>Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select>
  </div>
  <div class="form-group has-feedback">
    <input type="text" name="occupation" class="form-control" placeholder="Status" required>
      <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="text" name="instance" class="form-control" placeholder="Instansi" required>
      <span class="fa fa-university form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="text" name="address" class="form-control" placeholder="Alamat" required>
    <span class="glyphicon glyphicon-home form-control-feedback"></span>
</div>
<div class="social-auth-links text-center">
  <button type="submit" class="btn btn-primary btn-block btn-flat">Daftarkan</button>
</form>
</div>
<?php } ?>
</div>
</div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
  })
})
</script>
</body>
</html>