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
  <title> سامانه مدیریت کارکرد کارمندان</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../template/dist/css/bootstrap-theme.css">
  <!-- Bootstrap rtl -->
  <link rel="stylesheet" href="../template/dist/css/rtl.css">
  <!-- persian Date Picker -->
  <link rel="stylesheet" href="../template/dist/css/persian-datepicker-0.4.5.min.css">
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
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php
@includepage("../inc_template/header");
@includepage("../inc_template/menu_cop2");

$departements = mysqli_query($Connect,"SELECT department_id ,name FROM department");
if(isset($_POST['submit'])){
  if(!$_POST['user_name']== '' &&!$_POST['first_name'] == '' && !$_POST['department_id']== '' && !$_POST['last_name']== ''&& !$_POST['start_date'] == ''&&  !$_POST['Ssn']== ''){
    function convertToMiladi($date){
      $list = explode('/', $date);
      return jalali_to_gregorian($list[0], $list[1], $list[2],'/');
    };
    $Ssn=$_POST['Ssn'];
    $first_name= $_POST['first_name'];
    $department_id= $_POST['department_id'];
    $last_name= $_POST['last_name'];
    $start_date= convertToMiladi($_POST['start_date']);
    $birth_date=convertToMiladi($_POST['birth_date']); 
    $role= $_POST['role'];
    $password=password_hash($Ssn,PASSWORD_DEFAULT);
    $no_space_name=str_replace(" ", "", $_POST['first_name']);
    $no_space_family=str_replace(" ", "", $_POST['last_name']);
    $no_space_name_family=$no_space_name .= $no_space_family;
    $gender=$_POST['gender'];
    $marital_status=$_POST['marital_status'];
    $address=$_POST['address'];
    $mobile=$_POST['mobile'] ;
    $house_phone_number=$_POST['house_phone_number'] ;
    $user_name=$_POST['user_name'];
    $email=$_POST['email'];

    

    function checkMeliCode($meli)
      {    
        $cDigitLast = substr($meli , strlen($meli)-1);
        $fMeli = strval(intval($meli));
      
        if((str_split($fMeli))[0] == "0" && !(8 <= strlen($fMeli)  && strlen($fMeli) < 10)) return false;
      
        $nineLeftDigits = substr($meli , 0 , strlen($meli) - 1);
        
        $positionNumber = 10;
        $result = 0;
      
        foreach(str_split($nineLeftDigits) as $chr){
              $digit = intval($chr);
              $result += $digit * $positionNumber;
              $positionNumber--;
        }
      
        $remain = $result % 11;
      
        $controllerNumber = $remain;
      
        if(2 < $remain){
          $controllerNumber = 11-$remain;
        }
      
        return $cDigitLast == $controllerNumber;
        
      }
       !checkMeliCode($Ssn)? $invalid_national_code='کد ملی نامعتبر است.':$invalid_national_code='';
      if(preg_match("/^09[0-9]{9}$/", $mobile)) {
           $invalid_phone="";
      }else{
          $invalid_phone="شماره موبایل نامعتبر است.";
      }
     
      $oldItems = mysqli_query($Connect,"SELECT * FROM employee where Ssn= $Ssn");
      $checkrows=mysqli_num_rows($oldItems);
      if( $checkrows > 0 ){
        $duplicate_ssn="کد ملی تکراری است.";
      }
      else{
        $duplicate_ssn="";
      };
      $oldItems = mysqli_query($Connect,"SELECT * FROM employee where employee_id= $user_name OR user_name= $user_name");
      $checkrows=mysqli_num_rows($oldItems);
      if( $checkrows > 0 ){
        $duplicate_ssn="کد پرسنلی تکراری است.";
      }
      else{
        $duplicate_ssn="";
      };
     
      if($duplicate_ssn=='' && $invalid_phone=='' && $invalid_national_code==''){
          $sql = "INSERT INTO employee (employee_id,department_id,first_name,no_space_name,last_name,no_space_family,no_space_name_family,Ssn,birth_date,start_date,gender, 
          marital_staus,role,address,mobile,house_phone_number,user_name,password,email,photo) VALUES ('$user_name','$department_id','$first_name','$no_space_name','$last_name','$no_space_family','$no_space_name_family',' $Ssn','$birth_date','$start_date','$gender', 
          '$marital_status',' $role','$address','$mobile','$house_phone_number','$user_name','$password','$email','null')"; 
            if(mysqli_query($Connect, $sql)){ 
              $successful_submit="اطلاعات با موفقیت ثبت شد.";
              $unsuccessful_submit="";
              // $sql = " INSERT INTO token_leave (employee_id, leave_id, start_date, end_date, comment, total_status)
              // VALUES ('$employee_id', '$leave_type', '$start', '$end', '$comment', '$hours')";
            }
            else{
              $successful_submit="";
              $unsuccessful_submit="خطا در ثبت اطلاعات";
            }
        }
      }
      else{
           $massagefalse=" لطفا گزینه‌های ستاره‌دار را پر کنید.";
      }
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		  <h1>مدیریت کارمندان</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">داشبورد</li>
      </ol>
      <?php 
        if(isset($invalid_national_code) && !$invalid_national_code==''){?>
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
                </button>
                <strong>خطا</strong> 
                <?=$invalid_national_code;?>
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
        if(isset($duplicate_ssn) && !$duplicate_ssn==''){?>
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
                </button>
                <strong>خطا</strong> 
                <?=$duplicate_ssn;?>
            </div>
          <?php
        }?>
        <?php 
        if(isset($invalid_phone) && !$invalid_phone==''){?>
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
                </button>
                <strong>خطا</strong> 
                <?=$invalid_phone;?>
            </div>
          <?php
        }?>
      <?php 
        if(isset($unsuccessful_submit) && !$unsuccessful_submit==''){?>
            <div class="alert alert-block alert-danger fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-remove"></i>
                </button>
                <strong>خطا</strong> 
                <?=$unsuccessful_submit;?>
            </div>
          <?php
        }?>
        <?php 
          if(isset($successful_submit) && !$successful_submit==''){?>
            <div class="alert alert-success fade in">
              <button data-dismiss="alert" class="close close-sm" type="button">
              <i class="fa fa-remove"></i>
              </button>
              <?=$successful_submit;?>
            </div>
          <?php
        }?>
        
    </section>
    <form role="form"  name="form" method="POST">
        <section class="content">
          <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">مشخصات کاربر</h3>
              </div>
              <form role="form">
                  <div class="box-body">
                    <div class="col-xs-4  pt-2">
                      <label for="first_name">نام*</label>
                      <input type="text" class="form-control w-50" id="first_name" name="first_name" >
                    </div>
                    <div class="col-xs-4  pt-2">
                      <label for="last_name">نام خانوادگی*</label>
                      <input type="text" class="form-control w-50" id="last_name" name="last_name">
                    </div>
                    <div class="col-xs-4  pt-2">
                      <label for="Ssn"> کدملی*</label>
                      <input type="text" class="form-control  w-50" id="Ssn" name="Ssn">
                    </div>
                    <div class="col-xs-4  pt-2">
                      <label for="user_name"> کد پرسنلی*</label>
                      <input type="text" class="form-control  w-50" id="user_name" name="user_name">
                    </div>
        
                    <div class="col-xs-4  pt-2">
                      <label for="birth_date">تاربخ تولد</label>
                      <input type="text" class="form-control  w-50"   id="birth_date" name="birth_date">
                    </div>
                    
                    <div class="col-xs-4  pt-2">
                      <label for="department_id">  بخش*</label>
                      <select  id="department_id"  class="form-control  w-50" name="department_id">
                        <?php foreach ($departements as $departement) : ?>
                            <option  value=<?php echo  $departement['department_id'] ?>><?php echo $departement['name'] ?></li>
                        <?php endforeach ?>                         
                      </select>   
                    </div>     
                    <div class="col-xs-4  pt-2">
                      <label for="start_date">تاریخ استخدام*</label>
                      <input type="text" class="form-control  w-50"  placeholder="      /   /    " id="start_date" name="start_date">
                    </div>       
                    <div class="col-xs-4  pt-2">
                      <label for="mobile"> شماره تلفن همراه</label>
                      <input type="tel" class="form-control  w-50" placeholder="09121111111" id="mobile" name="mobile">
                    </div>
                    <div class="col-xs-4  pt-2">
                      <label for="house_phone_number">شماره تلفن منزل</label>
                      <input type="tel" class="form-control  w-50" id="house_phone_number" name="house_phone_number">
                    </div>  
	  
                    <div class="col-xs-4  pt-2">
                      <label>وضعیت تاهل</label>
                      <div class="form-group d-flex">   
                          <label class="pl-3">
                            <input type="radio" name="marital_status" id="2" value="2" checked>
                              مجرد      
                          </label>        
                          <label>
                            <input type="radio" name="marital_status" id="1" value="1">
                            متاهل
                          </label>
                      </div>
                    </div>
                    <div class="col-xs-4  pt-2">
                      <label>جنسیت</label>
                      <div class="form-group d-flex">   
                          <label class="pl-3">
                            <input type="radio" name="gender" id="1" value="1" checked>
                              زن      
                          </label>        
                          <label>
                            <input type="radio" name="gender" id="2" value="2">
                            مرد
                          </label>
                      </div>
                    </div>
                    <div class="col-xs-4  pt-2">     
                      <label> نقش*</label>
                      <div class="form-group d-flex">   
                          <label class="pl-3">
                            <input type="radio" name="role" id="2" value="2" checked>
                              کاربر      
                          </label>        
                          <label>
                            <input type="radio" name="role" id="1" value="1">
                            ادمین
                          </label>
                      </div>
                    </div>
                    <div class="col-xs-4  pt-2"> 
                      <label for="email">ایمیل</label>
                      <div class="d-flex">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control w-50" placeholder="ایمیل" id="email" name="email">
                      </div>
                   </div>    		
                    <div class="col-xs-4  pt-2"> 
                      <label>آدرس</label>
                      <textarea class="form-control" rows="2" id="address" name="address"></textarea>
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
<!-- jQuery 3 -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
        $('#birth_date').pDatepicker({
            altField: '#tarikhAlt',
            altFormat: 'X',
            format: 'YYYY/MM/DD',
            observer: true,
            timePicker: {
                enabled: true
            },
        });
        $('#start_date').pDatepicker({
            altField: '#tarikhAlt',
            altFormat: 'X',
            format: 'YYYY/MM/DD',
            observer: true,
            timePicker: {
                enabled: true
            },
        });
    });
</script>
</body>
</html>
