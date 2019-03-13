<?php $this->load->view('headerfooter/header_guest'); ?>

<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="<?php echo base_url() ?>assets/dist/img/perpustakaan.png" height="64">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Masuk untuk memulai sesi anda</p>
        <div class="main_panel">
            <form role="form" action="" method="post">
              <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="social-auth-links">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
              <?php if ($this->session->has_userdata('login_message')) { ?>
               <div class="alert alert-danger alert-dismissible" style="margin-top:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i><?php echo $this->session->flashdata('login_message'); ?>
                </div>
              <?php } ?>
          </div>
      </form>
  </div>
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