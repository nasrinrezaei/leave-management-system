<?php

include("../../functions/function.php");
include("../../functions/conection.php");
include("../../functions/jdf.php");



function normalizeDigits($value)
{
    $value = (string)$value;

    $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
    $english = ['0','1','2','3','4','5','6','7','8','9'];

    $value = str_replace($persian, $english, $value);
    $value = str_replace($arabic, $english, $value);

    return $value;
}


function convertToMiladi($date)
{
    if (empty($date)) {
        return null;
    }

    $date = normalizeDigits(trim($date));

    $list = explode('/', $date);

    if (count($list) !== 3) {
        return null;
    }

    $year  = (int)$list[0];
    $month = (int)$list[1];
    $day   = (int)$list[2];

    if ($year <= 0 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
        return null;
    }

    return jalali_to_gregorian(
        $year,
        $month,
        $day,
        '/'
    );
}



function checkMeliCode($meli)
{
    $meli = normalizeDigits($meli);

    $meli = preg_replace('/\D/', '', $meli);

    if (strlen($meli) !== 10) {
        return false;
    }

    if (preg_match('/^(\d)\1{9}$/', $meli)) {
        return false;
    }

    $checkDigit = (int)$meli[9];

    $sum = 0;

    for ($i = 0; $i < 9; $i++) {
        $sum += ((int)$meli[$i]) * (10 - $i);
    }

    $remainder = $sum % 11;

    if ($remainder < 2) {
        $control = $remainder;
    } else {
        $control = 11 - $remainder;
    }

    return $checkDigit === $control;
}


$departements = mysqli_query(
    $Connect,
    "SELECT department_id, name FROM department ORDER BY name ASC"
);

if (!$departements) {
    die(
        "خطا در دریافت بخش‌ها: " .
        mysqli_error($Connect)
    );
}

$invalid_national_code = '';
$invalid_phone = '';
$duplicate_ssn = '';
$massagefalse = '';
$successful_submit = '';
$unsuccessful_submit = '';


if (isset($_POST['submit'])) {

    $first_name = trim(
        $_POST['first_name'] ?? ''
    );

    $last_name = trim(
        $_POST['last_name'] ?? ''
    );

    $Ssn = normalizeDigits(
        trim($_POST['Ssn'] ?? '')
    );

    $user_name = normalizeDigits(
        trim($_POST['user_name'] ?? '')
    );

    $department_id = normalizeDigits(
        trim($_POST['department_id'] ?? '')
    );

    $birth_date_input = trim(
        $_POST['birth_date'] ?? ''
    );

    $start_date_input = trim(
        $_POST['start_date'] ?? ''
    );

    $role_input = $_POST['role'] ?? '2';

    $gender_input = $_POST['gender'] ?? '1';

    $marital_input = $_POST['marital_status'] ?? '2';

    $address = trim(
        $_POST['address'] ?? ''
    );

    $mobile = normalizeDigits(
        trim($_POST['mobile'] ?? '')
    );

    $email = trim(
        $_POST['email'] ?? ''
    );

    $house_phone_number = normalizeDigits(
        trim($_POST['house_phone_number'] ?? '')
    );


    if (
        $user_name === '' ||
        $first_name === '' ||
        $department_id === '' ||
        $last_name === '' ||
        $start_date_input === '' ||
        $Ssn === ''
    ) {

        $massagefalse =
            "لطفاً گزینه‌های ستاره‌دار را پر کنید.";

    } else {

        if (!ctype_digit($user_name)) {

            $massagefalse =
                "کد پرسنلی باید فقط شامل عدد باشد.";

        } else {

            $employee_id = (int)$user_name;


            $start_date = convertToMiladi(
                $start_date_input
            );

            if ($start_date === null) {

                $massagefalse =
                    "تاریخ استخدام نامعتبر است.";
            }


            $birth_date = null;

            if ($birth_date_input !== '') {

                $birth_date = convertToMiladi(
                    $birth_date_input
                );

                if ($birth_date === null) {

                    $massagefalse =
                        "تاریخ تولد نامعتبر است.";
                }
            }


            if ($gender_input == '2') {
                $gender = 'man';
            } else {
                $gender = 'woman';
            }


            if ($marital_input == '1') {
                $marital_status = 'married';
            } else {
                $marital_status = 'single';
            }


            if ($role_input == '1') {
                $role = 'admin';
            } else {
                $role = 'user';
            }

            if (!checkMeliCode($Ssn)) {

                $invalid_national_code =
                    "کد ملی نامعتبر است.";

            } else {

                $invalid_national_code = '';
            }


            if ($mobile === '') {

                $invalid_phone = '';

            } elseif (
                preg_match(
                    "/^09[0-9]{9}$/",
                    $mobile
                )
            ) {

                $invalid_phone = '';

            } else {

                $invalid_phone =
                    "شماره موبایل نامعتبر است.";
            }



            if (
                $massagefalse === '' &&
                $invalid_national_code === ''
            ) {

                $stmt = mysqli_prepare(
                    $Connect,
                    "
                    SELECT employee_id
                    FROM employee
                    WHERE Ssn = ?
                    LIMIT 1
                    "
                );

                if (!$stmt) {

                    $unsuccessful_submit =
                        "خطا در بررسی کد ملی: " .
                        mysqli_error($Connect);

                } else {

                    mysqli_stmt_bind_param(
                        $stmt,
                        "s",
                        $Ssn
                    );

                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_store_result($stmt);

                    if (
                        mysqli_stmt_num_rows($stmt) > 0
                    ) {

                        $duplicate_ssn =
                            "کد ملی تکراری است.";
                    }

                    mysqli_stmt_close($stmt);
                }
            }



            if (
                $massagefalse === '' &&
                $duplicate_ssn === ''
            ) {

                $stmt = mysqli_prepare(
                    $Connect,
                    "
                    SELECT employee_id
                    FROM employee
                    WHERE employee_id = ?
                       OR user_name = ?
                    LIMIT 1
                    "
                );

                if (!$stmt) {

                    $unsuccessful_submit =
                        "خطا در بررسی کد پرسنلی: " .
                        mysqli_error($Connect);

                } else {

                    mysqli_stmt_bind_param(
                        $stmt,
                        "is",
                        $employee_id,
                        $user_name
                    );

                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_store_result($stmt);

                    if (
                        mysqli_stmt_num_rows($stmt) > 0
                    ) {

                        $duplicate_ssn =
                            "کد پرسنلی تکراری است.";
                    }

                    mysqli_stmt_close($stmt);
                }
            }



            if (
                $massagefalse === '' &&
                $duplicate_ssn === '' &&
                $invalid_phone === '' &&
                $invalid_national_code === ''
            ) {


                $password = password_hash(
                    $Ssn,
                    PASSWORD_DEFAULT
                );



                $no_space_name = str_replace(
                    ' ',
                    '',
                    $first_name
                );

                $no_space_family = str_replace(
                    ' ',
                    '',
                    $last_name
                );

                $no_space_name_family =
                    $no_space_name .
                    $no_space_family;



                $sql = "
                    INSERT INTO employee
                    (
                        employee_id,
                        department_id,
                        first_name,
                        no_space_name,
                        last_name,
                        no_space_family,
                        no_space_name_family,
                        Ssn,
                        birth_date,
                        start_date,
                        gender,
                        marital_staus,
                        role,
                        address,
                        mobile,
                        user_name,
                        password,
                        email,
                        photo
                    )
                    VALUES
                    (
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        NULL
                    )
                ";


                $stmt = mysqli_prepare(
                    $Connect,
                    $sql
                );


                if (!$stmt) {

                    $successful_submit = '';

                    $unsuccessful_submit =
                        "خطا در آماده‌سازی ثبت اطلاعات: " .
                        mysqli_error($Connect);

                } else {

                    mysqli_stmt_bind_param(
                        $stmt,
                        "iissssssssssssssss",
                        $employee_id,
                        $department_id,
                        $first_name,
                        $no_space_name,
                        $last_name,
                        $no_space_family,
                        $no_space_name_family,
                        $Ssn,
                        $birth_date,
                        $start_date,
                        $gender,
                        $marital_status,
                        $role,
                        $address,
                        $mobile,
                        $user_name,
                        $password,
                        $email
                    );


                    if (
                        mysqli_stmt_execute($stmt)
                    ) {

                        $successful_submit =
                            "اطلاعات با موفقیت ثبت شد.";

                        $unsuccessful_submit = '';

                    } else {

                        $successful_submit = '';

                        $unsuccessful_submit =
                            "خطا در ثبت اطلاعات: " .
                            mysqli_stmt_error($stmt);
                    }


                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">

  <meta
      http-equiv="X-UA-Compatible"
      content="IE=edge"
  >

  <title>
      سامانه مدیریت کارکرد کارمندان
  </title>

  <meta
      content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
      name="viewport"
  >

  <link
      rel="stylesheet"
      href="../template/dist/css/bootstrap-theme.css"
  >

  <link
      rel="stylesheet"
      href="../template/dist/css/rtl.css"
  >

  <link
      rel="stylesheet"
      href="../template/dist/css/persian-datepicker-0.4.5.min.css"
  >

  <link
      rel="stylesheet"
      href="../template/bower_components/font-awesome/css/font-awesome.min.css"
  >

  <link
      rel="stylesheet"
      href="../template/bower_components/Ionicons/css/ionicons.min.css"
  >

  <link
      rel="stylesheet"
      href="../template/dist/css/AdminLTE.css"
  >

  <link
      rel="stylesheet"
      href="../template/dist/css/skins/_all-skins.min.css"
  >

  <link
      rel="stylesheet"
      href="../template/bower_components/morris.js/morris.css"
  >

  <link
      rel="stylesheet"
      href="../template/bower_components/jvectormap/jquery-jvectormap.css"
  >

  <link
      rel="stylesheet"
      href="../template/bower_components/bootstrap-daterangepicker/daterangepicker.css"
  >

  <link
      rel="stylesheet"
      href="../template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"
  >

  <script
      src="../template/dist/js/persian-date-0.1.8.min.js">
  </script>

  <script
      src="../template/dist/js/persian-datepicker-0.4.5.min.js">
  </script>

  <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
  >

</head>


<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">


<?php


@includepage("../inc_template/header");
@includepage("../inc_template/menu");

?>



<div class="content-wrapper">



  <section class="content-header">

    <h1>
      مدیریت کارمندان
    </h1>

    <ol class="breadcrumb">

      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i>
          خانه
        </a>
      </li>

      <li class="active">
        داشبورد
      </li>

    </ol>


    <?php if (
        isset($invalid_national_code) &&
        $invalid_national_code !== ''
    ): ?>

      <div class="alert alert-danger">

        <button
            data-dismiss="alert"
            class="close close-sm"
            type="button"
        >
          <i class="fa fa-remove"></i>
        </button>

        <strong>خطا</strong>

        <?= htmlspecialchars(
            $invalid_national_code,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

      </div>

    <?php endif; ?>


    <?php if (
        isset($massagefalse) &&
        $massagefalse !== ''
    ): ?>

      <div class="alert alert-danger">

        <button
            data-dismiss="alert"
            class="close close-sm"
            type="button"
        >
          <i class="fa fa-remove"></i>
        </button>

        <strong>خطا</strong>

        <?= htmlspecialchars(
            $massagefalse,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

      </div>

    <?php endif; ?>


    <?php if (
        isset($duplicate_ssn) &&
        $duplicate_ssn !== ''
    ): ?>

      <div class="alert alert-danger">

        <button
            data-dismiss="alert"
            class="close close-sm"
            type="button"
        >
          <i class="fa fa-remove"></i>
        </button>

        <strong>خطا</strong>

        <?= htmlspecialchars(
            $duplicate_ssn,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

      </div>

    <?php endif; ?>


    <?php if (
        isset($invalid_phone) &&
        $invalid_phone !== ''
    ): ?>

      <div class="alert alert-danger">

        <button
            data-dismiss="alert"
            class="close close-sm"
            type="button"
        >
          <i class="fa fa-remove"></i>
        </button>

        <strong>خطا</strong>

        <?= htmlspecialchars(
            $invalid_phone,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

      </div>

    <?php endif; ?>


    <?php if (
        isset($unsuccessful_submit) &&
        $unsuccessful_submit !== ''
    ): ?>

      <div class="alert alert-danger">

        <button
            data-dismiss="alert"
            class="close close-sm"
            type="button"
        >
          <i class="fa fa-remove"></i>
        </button>

        <strong>خطا</strong>

        <?= htmlspecialchars(
            $unsuccessful_submit,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

      </div>

    <?php endif; ?>


    <?php if (
        isset($successful_submit) &&
        $successful_submit !== ''
    ): ?>

      <div class="alert alert-success">

        <button
            data-dismiss="alert"
            class="close close-sm"
            type="button"
        >
          <i class="fa fa-remove"></i>
        </button>

        <?= htmlspecialchars(
            $successful_submit,
            ENT_QUOTES,
            'UTF-8'
        ); ?>

      </div>

    <?php endif; ?>


  </section>



  <section class="content">


    <div class="row">


      <div class="box box-primary">


        <div class="box-header with-border">

          <h3 class="box-title">
            مشخصات کاربر
          </h3>

        </div>



        <form
            role="form"
            name="form"
            method="POST"
            action=""
        >


          <div class="box-body">



            <div class="col-xs-4 pt-2">

              <label for="first_name">
                نام*
              </label>

              <input
                  type="text"
                  class="form-control w-50"
                  id="first_name"
                  name="first_name"
                  value="<?= htmlspecialchars(
                      $_POST['first_name'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
                  required
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="last_name">
                نام خانوادگی*
              </label>

              <input
                  type="text"
                  class="form-control w-50"
                  id="last_name"
                  name="last_name"
                  value="<?= htmlspecialchars(
                      $_POST['last_name'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
                  required
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="Ssn">
                کدملی*
              </label>

              <input
                  type="text"
                  class="form-control w-50"
                  id="Ssn"
                  name="Ssn"
                  maxlength="10"
                  value="<?= htmlspecialchars(
                      $_POST['Ssn'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
                  required
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="user_name">
                کد پرسنلی*
              </label>

              <input
                  type="text"
                  class="form-control w-50"
                  id="user_name"
                  name="user_name"
                  value="<?= htmlspecialchars(
                      $_POST['user_name'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
                  required
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="birth_date">
                تاریخ تولد
              </label>

              <input
                  type="text"
                  class="form-control w-50"
                  id="birth_date"
                  name="birth_date"
                  value="<?= htmlspecialchars(
                      $_POST['birth_date'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="department_id">
                بخش*
              </label>

              <select
                  id="department_id"
                  class="form-control w-50"
                  name="department_id"
                  required
              >

                <option value="">
                  انتخاب بخش
                </option>

                <?php foreach (
                    $departements as $departement
                ): ?>

                  <option
                      value="<?= (int)$departement['department_id']; ?>"
                      <?php
                      if (
                          isset($_POST['department_id']) &&
                          $_POST['department_id'] ==
                          $departement['department_id']
                      ) {
                          echo 'selected';
                      }
                      ?>
                  >

                    <?= htmlspecialchars(
                        $departement['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                  </option>

                <?php endforeach; ?>

              </select>

            </div>



            <div class="col-xs-4 pt-2">

              <label for="start_date">
                تاریخ استخدام*
              </label>

              <input
                  type="text"
                  class="form-control w-50"
                  placeholder="1400/01/01"
                  id="start_date"
                  name="start_date"
                  value="<?= htmlspecialchars(
                      $_POST['start_date'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
                  required
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="mobile">
                شماره تلفن همراه
              </label>

              <input
                  type="tel"
                  class="form-control w-50"
                  placeholder="09121111111"
                  id="mobile"
                  name="mobile"
                  maxlength="11"
                  value="<?= htmlspecialchars(
                      $_POST['mobile'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label for="house_phone_number">
                شماره تلفن منزل
              </label>

              <input
                  type="tel"
                  class="form-control w-50"
                  id="house_phone_number"
                  name="house_phone_number"
                  value="<?= htmlspecialchars(
                      $_POST['house_phone_number'] ?? '',
                      ENT_QUOTES,
                      'UTF-8'
                  ); ?>"
              >

            </div>



            <div class="col-xs-4 pt-2">

              <label>
                وضعیت تاهل
              </label>

              <div class="form-group d-flex">

                <label class="pl-3">

                  <input
                      type="radio"
                      name="marital_status"
                      value="2"
                      <?= (
                          ($_POST['marital_status'] ?? '2')
                          == '2'
                      )
                          ? 'checked'
                          : ''; ?>
                  >

                  مجرد

                </label>


                <label>

                  <input
                      type="radio"
                      name="marital_status"
                      value="1"
                      <?= (
                          ($_POST['marital_status'] ?? '')
                          == '1'
                      )
                          ? 'checked'
                          : ''; ?>
                  >

                  متاهل

                </label>

              </div>

            </div>



            <div class="col-xs-4 pt-2">

              <label>
                جنسیت
              </label>

              <div class="form-group d-flex">

                <label class="pl-3">

                  <input
                      type="radio"
                      name="gender"
                      value="1"
                      <?= (
                          ($_POST['gender'] ?? '1')
                          == '1'
                      )
                          ? 'checked'
                          : ''; ?>
                  >

                  زن

                </label>


                <label>

                  <input
                      type="radio"
                      name="gender"
                      value="2"
                      <?= (
                          ($_POST['gender'] ?? '')
                          == '2'
                      )
                          ? 'checked'
                          : ''; ?>
                  >

                  مرد

                </label>

              </div>

            </div>



            <div class="col-xs-4 pt-2">

              <label>
                نقش*
              </label>

              <div class="form-group d-flex">

                <label class="pl-3">

                  <input
                      type="radio"
                      name="role"
                      value="2"
                      <?= (
                          ($_POST['role'] ?? '2')
                          == '2'
                      )
                          ? 'checked'
                          : ''; ?>
                  >

                  کاربر

                </label>


                <label>

                  <input
                      type="radio"
                      name="role"
                      value="1"
                      <?= (
                          ($_POST['role'] ?? '')
                          == '1'
                      )
                          ? 'checked'
                          : ''; ?>
                  >

                  ادمین

                </label>

              </div>

            </div>



            <div class="col-xs-4 pt-2">

              <label for="email">
                ایمیل
              </label>

              <div class="d-flex">

                <span class="input-group-addon">
                  <i class="fa fa-envelope"></i>
                </span>

                <input
                    type="email"
                    class="form-control w-50"
                    placeholder="ایمیل"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars(
                        $_POST['email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                >

              </div>

            </div>



            <div class="col-xs-4 pt-2">

              <label>
                آدرس
              </label>

              <textarea
                  class="form-control"
                  rows="2"
                  id="address"
                  name="address"
              ><?= htmlspecialchars(
                  $_POST['address'] ?? '',
                  ENT_QUOTES,
                  'UTF-8'
              ); ?></textarea>

            </div>


          </div>



          <div class="box-body">

            <button
                name="submit"
                value="1"
                type="submit"
                class="btn btn-primary"
            >

              <i class="fa fa-save"></i>

              ارسال

            </button>

          </div>


        </form>


      </div>


    </div>


  </section>


</div>



<script src="../template/bower_components/jquery/dist/jquery.min.js"></script>


<script src="../template/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>


<script src="../template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


<script src="../template/bower_components/raphael/raphael.min.js"></script>

<script src="../template/bower_components/morris.js/morris.min.js"></script>


<script src="../template/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>


<script src="../template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

<script src="../template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>


<script src="../template/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>


<script src="../template/bower_components/moment/min/moment.min.js"></script>


<script src="../template/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>


<script src="../template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script src="../template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>


<script src="../template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>


<script src="../template/bower_components/fastclick/lib/fastclick.js"></script>


<script src="../template/dist/js/adminlte.min.js"></script>

<script src="../template/dist/js/pages/dashboard.js"></script>

<script src="../template/dist/js/demo.js"></script>



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
            enabled: false
        }

    });


    $('#start_date').pDatepicker({

        altField: '#tarikhAlt',

        altFormat: 'X',

        format: 'YYYY/MM/DD',

        observer: true,

        timePicker: {
            enabled: false
        }

    });

});

</script>


</body>

</html>