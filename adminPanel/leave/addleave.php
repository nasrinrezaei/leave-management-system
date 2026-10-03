<?php
include("../../functions/function.php");
include("../../functions/conection.php");
include("../../functions/jdf.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>سامانه مدیریت کارکرد کارمندان</title>
   <!-- persian Date Picker -->
   <link rel="stylesheet" href="../template/dist/css/persian-datepicker-0.4.5.min.css">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../template/dist/css/bootstrap-theme.css">
  <!-- Bootstrap rtl -->
  <link rel="stylesheet" href="../template/dist/css/rtl.css">
  <!-- persian Date Picker -->
  <link rel="stylesheet" href="../template/dist/css/persian-datepicker-0.4.5.min">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../template/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../template/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../template/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../template/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../template/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <script src="../template/dist/js/persian-date-0.1.8.min.js"></script>
  <script src="../template/dist/js/persian-datepicker-0.4.5.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php
@includepage("../inc_template/header");
@includepage("../inc_template/menu_cop");
  $sql = "SELECT token_hours_for_illness, token_hours_for_without_salary,employee_id,token_hours_for_entitlent  FROM token_leave WHERE employee_id=1";
  $data = mysqli_query($Connect,$sql);
  $row =mysqli_fetch_assoc($data);
  if(isset($_POST['submit'])){
    function convertToMiladi($date_time){
      // print $date_time;
      $date= explode(',', $date_time);
      // print $date[0];
      $list = explode('/',  $date[0]);
      $final_date=jalali_to_gregorian($list[0], $list[1], $list[2],'-');
      return  $final_date.=$date[1];
    };
   
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      $filename=$_FILES["fileToUpload"]["name"];
      // Check if file already exists
      if (file_exists($target_file)) {
          $uploadMessage= "فایل شما قبلا بارگذاری شده ";
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] --> 500000) {
        $uploadMessage= " مگ باشد 500000 حجم فایل انتخابی باشد کمتر از ";
          $uploadOk = 0;
      }
      if ($uploadOk == 0) {
        $uploadMessage= " متاسفانه فایل شما اپلود نشد.";
              // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $uploadMessage= " فایل شما با موفقیت اپلود شد.";
            $sql = "INSERT INTO files (leave_id,original_name,postfix) VALUES (1,$filename,$imageFileType)"; 
          } else {
            $uploadMessage= " متاسفانه فایل شما اپلود نشد.";
          }
      }
    
    if(!$_POST['end_date'] == '' && !$_POST['start_date']== '' &&!$_POST['leave_type']==''){
      $massagefalse='';
      $_POST['comment'];
      // print date_diff($_POST['end_date'], $_POST['start_date']);
      $diff = strtotime( $_POST['end_date']) - strtotime($_POST['start_date']);
      $hours = floor( $diff / 3600);
      $hours<=0 ? $date_time_select_error='لطفا تاریخ و ساعت درست را انتخاب کنید.':$date_time_select_error='';
      if(($_POST['leave_type']=='2' && $row['token_hours_for_entitlent']+ $hours>=240 ) ||  ($_POST['leave_type']=='1' && $row['token_hours_for_illness']+ $hours>=240 ))
      {$invalid_type='ساعت این نوع مرخصی پر شده لطفا نوع دیگری از مرخصی استفاده کنید.';}
      else{
        $invalid_type='';
        $leave_type=$_POST['leave_type'];
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];
        $comment= $_POST['comment'] || "";
        $employee_id=1;
        $start= convertToMiladi($start_date);
        $end= convertToMiladi($end_date);
        convertToMiladi($start_date);
        $sql = "INSERT INTO leave (employee_id, leave_type, start_date, end_date, comment ,status , total_hours)
        VALUES ('$employee_id', '$leave_type', '$start', '$end', '$comment','disapproval', '$hours')";
        // if(mysqli_query($Connect, $sql)){ 
        //     $successful_submit="اطلاعات با موفقیت ثبت شد.";
        //     $unsuccessful_submit="";
        //   }
        //   else{
        //     $successful_submit="";
        //     $unsuccessful_submit="خطا در ثبت اطلاعات";
        //   }
      }
      
   }  else{
    $massagefalse=" لطفا گزینه‌های ستاره‌دار را پر کنید.";
    }
  }
?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>مرخصی</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">داشبورد</li>
      </ol>
    </section>
    <?php 
        if(isset($date_time_select_error) && !$date_time_select_error==''){?>
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
                </button>
                <strong>خطا</strong> 
                <?=$date_time_select_error;?>
            </div>
          <?php
        }?>
        <?php 
          if(isset($massagefalse) && !$massagefalse==''){?>
            <div class="alert alert-block alert-danger fade in">
              <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
              </button>
              <strong>خطا</strong> 
              <?=$massagefalse;?>
            </div>
        <?php
        }?>
        <?php 
          if(isset($invalid_type) && !$invalid_type==''){?>
            <div class="alert alert-block alert-danger fade in">
              <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
              </button>
              <strong>خطا</strong> 
              <?=$invalid_type;?>
            </div>
        <?php
        }?>
    <!-- Main content -->
    <form role="form"  name="form" method="POST"  enctype="multipart/form-data">
        <section class="content">
          <div class="row">
            <div class="box box-primary">
              <form role="form">
              <section class="p-15">
                <div class="w-100 bg-gray-light p-1 border-1 radius-1">
                    <div class="text-light-blue">
                      میزان مرخصی دریافتی  به شرح زیر است:
                    </div>
                  <br/>     
                  <div class=" font-size-13 color-gray d-flex">
                      <div class="w-25  color-gray">
                        <div class="pb-10"> ۲۴۰ ساعت استحقاقی در سال </div>
                        <div > ساعات باقی‌مانده برای شما در ماه  <?=240-$row['token_hours_for_entitlent'];?> ساعت </div>

                      </div>
                      <div class="w-25  color-gray">
                        <div class="pb-10"> ۲۴۰ ساعت استعلاجی در سال </div>
                        <div > ساعات باقی‌مانده برای شما در ماه  <?=240-$row['token_hours_for_illness'];?> ساعت </div>

                      </div>
                      <div class="w-25  color-gray">
                        <div class="pb-10"> بدون حقوق: نامحدود </div>
                      </div>
                  </div>
                  
                  <br/>
                </div>
              </section>
                  <div class="box-body">
                    <div class="col-xs-4  pt-2">
                      <label for="leave_type">نوع مرخصی*</label>
                      <select name="leave_type" id="leave_type" class="form-control w-50">
                        <option value="1" selected >استعلاجی</option>
                        <option value="2" >استحقاقی</option>
                        <option value="3">بدون حقوق</option>
                      </select>
                    </div>       
                    <div class="col-xs-4  pt-2">
                      <label for="start_date">تاربخ شروع*</label>
                      <input type="text" class="form-control  w-50"   id="start_date" name="start_date">
                    </div>           
                    <div class="col-xs-4  pt-2">
                      <label for="end_date">تاریخ پایان*</label>
                      <input type="text" class="form-control  w-50"   id="end_date" name="end_date">
                    </div>      
                    <div class="col-xs-4  pt-2"> 
                      <label for="comment">توضیحات</label>
                      <textarea class="form-control" rows="2" id="comment" name="comment"></textarea>
                    </div> 
                    <div class="col-xs-4  pt-2"> 
                      <label for="comment">ارسال مدرک مربوطه</label>
                      <input type="file" name="fileToUpload" id="fileToUpload">
                     </div> 
                  </div>
                  <div class="box-body">
                      <button name="submit" type="submit" class="btn btn-primary">ارسال</button>
                  </div>    
                </form>
            </div>
          </div>
          </div>
        </section>
    </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer text-left"> 
    <strong></a></strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">فعالیت ها</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">تولد غلوم</h4>

                <p>۲۴ مرداد</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">آپدیت پروفایل سجاد</h4>

                <p>تلفن جدید (800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">نورا به خبرنامه پیوست</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">کرون جابز اجرا شد</h4>

                <p>۵ ثانیه پیش</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">پیشرفت کارها</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                ساخت پوستر های تبلیغاتی
                <span class="label label-danger pull-left">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                آپدیت رزومه
                <span class="label label-success pull-left">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                آپدیت لاراول
                <span class="label label-warning pull-left">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                بخش پشتیبانی سایت
                <span class="label label-primary pull-left">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">وضعیت</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">تنظیمات عمومی</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              گزارش کنترلر پنل
              <input type="checkbox" class="pull-left" checked>
            </label>

            <p>
              ثبت تمامی فعالیت های مدیران
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              ایمیل مارکتینگ
              <input type="checkbox" class="pull-left" checked>
            </label>

            <p>
              اجازه به کاربران برای ارسال ایمیل
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              در دست تعمیرات
              <input type="checkbox" class="pull-left" checked>
            </label>

            <p>
              قرار دادن سایت در حالت در دست تعمیرات
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">تنظیمات گفتگوها</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              آنلاین بودن من را نشان نده
              <input type="checkbox" class="pull-left" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              اعلان ها
              <input type="checkbox" class="pull-left">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              حذف تاریخته گفتگوهای من
              <a href="javascript:void(0)" class="text-red pull-left"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../template/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../template/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../template/bower_components/raphael/raphael.min.js"></script>
<script src="../template/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../template/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../template/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../template/bower_components/moment/min/moment.min.js"></script>
<script src="../template/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../template/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../template/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../template/dist/js/demo.js"></script>
<script src="static/js/lib/jquery-3.2.1.min.js"></script>
<script src="static/js/app.js"></script>
<script src="../template/dist/js/persian-date-0.1.8.min.js"></script>
<script src="../template/dist/js/persian-datepicker-0.4.5.min.js"></script>
<script src="../template/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../template/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../template/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
    $(document).ready(function () {
        $('#start_date').pDatepicker({
            // altField: '#tarikhAlt',
            altFormat: 'X',
            format: 'YYYY/MM/DD, h:mm:ss ',
            // observer: true,
            timePicker: {
                enabled: true
            },
        });
        $('#end_date').pDatepicker({
            altField: '#tarikhAlt',
            // altFormat: 'X',
            format: 'YYYY/MM/DD , h:mm:ss ',
            // observer: true,
            timePicker: {
                enabled: true
            },
        });
    });
</script>
</body>
</html>
