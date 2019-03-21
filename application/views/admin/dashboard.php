<?php $this->load->view('headerfooter/header_admin'); ?>
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-eye"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Kunjungan Hari Ini</span>
              <span class="info-box-number"><?php echo $visit; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">41,410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tamu Terdaftar</span>
              <span class="info-box-number"><?php echo $guest; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-7">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Kunjungan seminggu terakhir</a></li>
              <li><a href="#tab_2" data-toggle="tab">Kunjungan tiap tahun</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <script src="<?php echo base_url() ?>assets/code/highcharts.js"></script>
                <script src="<?php echo base_url() ?>assets/code/modules/series-label.js"></script>
                <script src="<?php echo base_url() ?>assets/code/modules/exporting.js"></script>
                <script src="<?php echo base_url() ?>assets/code/modules/export-data.js"></script>
                <div id="container4" style="margin: 0 auto"></div>
                <script type="text/javascript">
                Highcharts.chart('container4', {

                    title: {
                        text: 'Solar Employment Growth by Sector, 2010-2016'
                    },

                    subtitle: {
                        text: 'Source: thesolarfoundation.com'
                    },

                    yAxis: {
                        title: {
                            text: 'Number of Employees'
                        }
                    },
                    plotOptions: {
                        series: {
                            pointStart: 1
                        }
                    },

                    series: [{
                        name: 'Installation',
                        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
                    }]

                });
                    </script>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <script src="<?php echo base_url() ?>assets/code/highcharts.js"></script>
                  <script src="<?php echo base_url() ?>assets/code/modules/data.js"></script>
                  <script src="<?php echo base_url() ?>assets/code/modules/drilldown.js"></script>
                  <div id="container" style="margin: 0 auto"></div>
                  <script type="text/javascript">
                  // Create the chart
                  Highcharts.chart('container', {
                      chart: {
                          type: 'column'
                      },
                      title: {
                          text: 'Kunjungan tiap tahun'
                      },
                      subtitle: {
                          text: 'Klik kolom untuk melihat kunjungan tiap bulan'
                      },
                      xAxis: {
                          type: 'category'
                      },
                      yAxis: {
                          title: {
                              text: 'Total kunjungan'
                          }

                      },
                      legend: {
                          enabled: false
                      },
                      plotOptions: {
                          series: {
                              borderWidth: 0,
                              dataLabels: {
                                  enabled: true,
                              }
                          }
                      },

                      tooltip: {
                          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> kunjungn<br/>'
                      },

                      "series": [
                          {
                              "name": "Tahun",
                              "colorByPoint": true,
                              "data": [
                              <?php foreach ($data_guestbook as $key => $row) {
                                echo ' {
                              "name": "'.$row->year.'",
                              "y":'.$row->total.',
                              "drilldown": "'.$row->year.'"
                              },'; } ?>
                              ]
                          }
                      ],
                      "drilldown": {
                          "series": [
                              <?php foreach ($data_guestbook as $key => $row) {
                                $string = '{
                                    "name":"'.$row->year.'",
                                    "id":"';
                                    $string .= $row->year;
                                    $string .= '",
                                    "data":[';
                                    if ($row->year != date('Y')) {
                                      for ($x = 1; $x <= 12; $x++) {
                                          $guestbook=$this->Guestbook_model->data_monthandcount($row->year, $x);
                                            foreach ($guestbook as $key => $rows) { 
                                              $string .= "['".date('F', mktime(0, 0, 0, $x, 10))."',".$rows->total."],";
                                            }
                                        }
                                    } else {
                                      for ($x = 1; $x <= $row->max_month; $x++) {
                                          $guestbook=$this->Guestbook_model->data_monthandcount($row->year, $x);
                                            foreach ($guestbook as $key => $rows) { 
                                              $string .= "['".date('F', mktime(0, 0, 0, $x, 10))."',".$rows->total."],";
                                            }
                                        }
                                    }
                                      /*foreach ($guestbook as $key => $rows) { 
                                        $string .= "['".$rows->month_name."',".$rows->total."],";
                                      }*/
                                    $string .=']
                                },'; 
                                echo $string;
                                }?>
                          ]
                      }
                  });
                  </script>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
        <div class="col-md-5">
          <!-- MAP & BOX PANE -->
          <div class="box box-info">
            <?php /*for($x = 6; $x >= 0; $x--) {
              $d = date("d-M-Y", strtotime('-'.$x.' days'));
              if (strcasecmp($d, 'Sun') != 0
                  && strcasecmp($d, 'Sat') != 0){
                  echo $d.'<br>';
              }
            }*/
            $i=0;
              echo date("d M Y", strtotime(' Monday +'.$i.'1 week ago')).'<br>'. date("d M Y", strtotime(' Tuesday +'.$i.'this week')).'<br>'.date("d M Y", strtotime(' Wednesday +'.$i.'this week')).'<br>'. date("d M Y", strtotime(' Thursday +'.$i.'this week')).'<br>'. date("d M Y", strtotime(' Friday +'.$i.'this week')).'<br>';
             ?>
            <div class="box-header with-border">
              <h3 class="box-title">Kriteria Pengunjung</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body no-padding">
              <!-- Date -->
              <form role="form" action="" method="post">
              <div class="form-group has-feedback">
                <div class="col-md-10">
                  <label>Tanggal</label>
                </div>
                <div class="col-md-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="date" class="form-control pull-right" id="reservation" value="<?php echo $date; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <button type="submit" class="btn btn-info btn-block btn-flat">Lihat</button>
                </div>
                <!-- /.input group -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="pad">
                    <script src="<?php echo base_url() ?>assets/code/highcharts.js"></script>
                    <script src="<?php echo base_url() ?>assets/code/modules/exporting.js"></script>
                    <script src="<?php echo base_url() ?>assets/code/modules/export-data.js"></script>
                    <?php if (!$data_guestbookoccuptaion) { /*echo date("Y-m-d", strtotime('-6 days')).' - '.date("Y-m-d");*/ ?>
                    <?php } else { /*echo date("Y-m-d", strtotime('-6 days')).' - '.date("Y-m-d");*/ ?>
                    <div id="container2" style="margin: 0 auto"></div>
                    <script type="text/javascript">
                    Highcharts.chart('container2', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Persentase kriteria pengunjung'
                        },
                        subtitle: {
                            text: 'Pilih kolom untuk rentang tanggal lainnya'
                        },
                        plotOptions: {
                            series: {
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}: {point.percentage:.1f}%'
                                }
                            }
                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> kali<br/>'
                        },
                        "series": [
                            {
                            name: 'Kunjungan',
                            colorByPoint: true,
                            data: [
                            <?php
                                foreach ($data_guestbookoccuptaion as $key => $row) {
                            ?>
                            {
                                name: '<?php echo $row->occupation; ?>',
                                y: <?php echo $row->total; ?>,
                                drilldown: '<?php echo $row->occupation; ?>'
                            },
                            <?php } ?>
                            ]
                        }],
                        "drilldown": {
                            "series": [
                                <?php foreach ($data_guestbookoccuptaion as $key => $row) {
                                $guestbookoccupation=$this->Guestbook_model->data_occupationandinstance($dates, $row->occupation);
                                $string = '{
                                    "name":"'.$row->occupation.'",
                                    "colorByPoint": true,
                                    "id":"';
                                    $string .= $row->occupation;
                                    $string .= '",
                                    "data":[';
                                    foreach ($guestbookoccupation as $key => $rows) { 
                                        $string .= "['".$rows->instance."',".$rows->total."],";
                                    }
                                    $string .=']
                                },'; 
                                echo $string;
                                }?>
                              ]
                            }
                    });
                    </script>
                    <?php } ?>
                    <!-- Map will be created here -->
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Rekomendasi Buku</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body no-padding">
              <!-- Date -->
              <div class="form-group has-feedback">
                <div class="col-md-10">
                  <label>Tanggal</label>
                </div>
                <div class="col-md-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="date1" class="form-control pull-right" id="reservation1" value="<?php echo $date1; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <button type="submit" class="btn btn-warning btn-block btn-flat">Lihat</button>
                </div>
                <!-- /.input group -->
              </div>
              </form>
              <!-- /.form group -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="pad">
                    <script src="<?php echo base_url() ?>assets/code/highcharts.js"></script>
                    <script src="<?php echo base_url() ?>assets/code/modules/exporting.js"></script>
                    <script src="<?php echo base_url() ?>assets/code/modules/export-data.js"></script>
                    <?php if (!$data_booktype) { /*echo date("Y-m-d", strtotime('-6 days')).' - '.date("Y-m-d");*/ ?>
                    <?php } else { /*echo date("Y-m-d", strtotime('-6 days')).' - '.date("Y-m-d");*/ ?>
                    <div id="container3" style="margin: 0 auto"></div>
                    <script type="text/javascript">
                    Highcharts.chart('container3', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Persentase kriteria pengunjung'
                        },
                        subtitle: {
                            text: 'Pilih kolom untuk rentang tanggal lainnya'
                        },
                        plotOptions: {
                            series: {
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}: {point.percentage:.1f}%'
                                }
                            }
                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> kali<br/>'
                        },
                        "series": [
                            {
                            name: 'Kunjungan',
                            colorByPoint: true,
                            data: [
                            <?php
                                foreach ($data_booktype as $key => $row) {
                            ?>
                            {
                                name: '<?php echo $row->type; ?>',
                                y: <?php echo $row->total; ?>,
                                drilldown: '<?php echo $row->type; ?>'
                            },
                            <?php } ?>
                            ]
                        }],
                        "drilldown": {
                            "series": [
                                <?php foreach ($data_booktype as $key => $row) {
                                $recomendationtitle=$this->Bookrecomendation_model->booktitle_by_type($dates1, $row->type);
                                $string = '{
                                    "name":"'.$row->type.'",
                                    "colorByPoint": true,
                                    "id":"';
                                    $string .= $row->type;
                                    $string .= '",
                                    "data":[';
                                    foreach ($recomendationtitle as $key => $rows) { 
                                        $string .= "['".$rows->title."',".$rows->total."],";
                                    }
                                    $string .=']
                                },'; 
                                echo $string;
                                }?>
                              ]
                            }
                    });
                    </script>
                    <?php } ?>
                    <!-- Map will be created here -->
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
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
<!-- date-range-picker -->
<script src="<?php echo base_url() ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function () {
    //Date range picker
    $('#reservation').daterangepicker({
        locale: {
            format: 'DD-MMM-YYYY'
        }
    })
    $('#reservation1').daterangepicker({
        locale: {
            format: 'DD-MMM-YYYY'
        }
    })
   
    /*<?php foreach ($data_guestweek as $key => $row) { ?>
        {y: '<?php echo $row->day; ?>', item1: <?php echo $row->total; ?>},
      <?php } ?>*/
  })
</script>
</body>
</html>