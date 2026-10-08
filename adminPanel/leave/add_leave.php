
<?php
include("../../functions/auth.php");

requireLogin();

include("../../functions/function.php");
include("../../functions/conection.php");
include("../../functions/jdf.php");

$employee_id = (int)$_SESSION['employee_id'];

$sql = "
    SELECT
        token_hours_for_illness,
        token_hours_for_without_salary,
        employee_id,
        token_hours_for_entitlent
    FROM token_leave
    WHERE employee_id = ?
";


$stmt_token = mysqli_prepare($Connect, $sql);

if ($stmt_token) {

    mysqli_stmt_bind_param(
        $stmt_token,
        "i",
        $employee_id
    );

    mysqli_stmt_execute($stmt_token);

    $data = mysqli_stmt_get_result($stmt_token);

    $row = mysqli_fetch_assoc($data);

    mysqli_stmt_close($stmt_token);

} else {

    $row = false;
}



if (!$row) {

    $row = [
        'token_hours_for_illness' => 0,
        'token_hours_for_without_salary' => 0,
        'token_hours_for_entitlent' => 0,
        'employee_id' => $employee_id
    ];
}


function convertToMiladi($date_time)
{
    $date = explode(',', $date_time);

    if (count($date) < 2) {
        return '';
    }

    $list = explode('/', trim($date[0]));

    if (count($list) !== 3) {
        return '';
    }

    $time = trim($date[1]);

    $final_date = jalali_to_gregorian(
        (int)$list[0],
        (int)$list[1],
        (int)$list[2],
        '-'
    );

    return $final_date . ' ' . $time;
}


$uploadMessage = '';
$massagefalse = '';
$date_time_select_error = '';
$invalid_type = '';
$successful_submit = '';
$unsuccessful_submit = '';

if (isset($_POST['submit'])) {


    if (
        isset($_POST['end_date']) &&
        isset($_POST['start_date']) &&
        isset($_POST['leave_type']) &&
        $_POST['end_date'] !== '' &&
        $_POST['start_date'] !== '' &&
        $_POST['leave_type'] !== ''
    ) {


        $leave_type = $_POST['leave_type'];

        $start_date = $_POST['start_date'];

        $end_date = $_POST['end_date'];

        $comment = isset($_POST['comment'])
            ? $_POST['comment']
            : '';


        switch ($leave_type) {

            case '1':

                $leave_type_db = 'illness';

                break;


            case '2':

                $leave_type_db = 'entitlent';

                break;


            case '3':

                $leave_type_db = 'without_salary';

                break;


            default:

                $leave_type_db = '';

                break;
        }


        if ($leave_type_db === '') {

            $massagefalse = 'نوع مرخصی نامعتبر است.';

        } else {


            $start = convertToMiladi($start_date);

            $end = convertToMiladi($end_date);


            if ($start === '' || $end === '') {


                $date_time_select_error =
                    'لطفاً تاریخ و ساعت را به‌درستی انتخاب کنید.';


            } else {

                $diff = strtotime($end) - strtotime($start);

                $hours = floor($diff / 3600);


                if ($hours <= 0) {


                    $date_time_select_error =
                        'لطفاً تاریخ و ساعت درست را انتخاب کنید.';


                } else {


                    if (
                        $leave_type_db === 'entitlent' &&
                        ($row['token_hours_for_entitlent'] + $hours >= 240)
                    ) {


                        $invalid_type =
                            'ساعت مرخصی استحقاقی پر شده است. لطفاً نوع دیگری از مرخصی استفاده کنید.';


                    } elseif (
                        $leave_type_db === 'illness' &&
                        ($row['token_hours_for_illness'] + $hours >= 240)
                    ) {


                        $invalid_type =
                            'ساعت مرخصی استعلاجی پر شده است. لطفاً نوع دیگری از مرخصی استفاده کنید.';


                    } else {


                        $stmt = mysqli_prepare(
                            $Connect,

                            "INSERT INTO `leave`
                            (
                                employee_id,
                                leave_type,
                                start_date,
                                end_date,
                                comment,
                                status,
                                total_hours
                            )
                            VALUES (?, ?, ?, ?, ?, 'not-define', ?)"
                        );


                        if ($stmt) {


                            mysqli_stmt_bind_param(
                                $stmt,
                                "issssi",
                                $employee_id,
                                $leave_type_db,
                                $start,
                                $end,
                                $comment,
                                $hours
                            );


                            if (mysqli_stmt_execute($stmt)) {


                                $leave_id = mysqli_insert_id($Connect);


                                $successful_submit =
                                    'درخواست مرخصی با موفقیت ثبت شد و در انتظار بررسی مدیر است.';


                                if (
                                    isset($_FILES['fileToUpload']) &&
                                    $_FILES['fileToUpload']['error'] !== UPLOAD_ERR_NO_FILE
                                ) {


                                    $target_dir = "uploads/";


                                    if (!is_dir($target_dir)) {

                                        mkdir($target_dir, 0755, true);
                                    }


                                    $original_name =
                                        basename($_FILES['fileToUpload']['name']);


                                    $target_file =
                                        $target_dir . $original_name;


                                    $uploadOk = 1;


                                    $imageFileType =
                                        strtolower(
                                            pathinfo(
                                                $target_file,
                                                PATHINFO_EXTENSION
                                            )
                                        );


                                    if (
                                        $_FILES['fileToUpload']['size'] > 500000
                                    ) {


                                        $uploadMessage =
                                            'حجم فایل باید کمتر از 500000 بایت باشد.';


                                        $uploadOk = 0;
                                    }



                                    if (file_exists($target_file)) {


                                        $uploadMessage =
                                            'فایل شما قبلاً بارگذاری شده است.';


                                        $uploadOk = 0;
                                    }


                                    if ($uploadOk === 1) {


                                        if (
                                            move_uploaded_file(
                                                $_FILES['fileToUpload']['tmp_name'],
                                                $target_file
                                            )
                                        ) {


                                            $file_stmt = mysqli_prepare(
                                                $Connect,

                                                "INSERT INTO files
                                                (
                                                    leave_id,
                                                    original_name,
                                                    postfix
                                                )
                                                VALUES (?, ?, ?)"
                                            );


                                            if ($file_stmt) {


                                                mysqli_stmt_bind_param(
                                                    $file_stmt,
                                                    "iss",
                                                    $leave_id,
                                                    $original_name,
                                                    $imageFileType
                                                );


                                                mysqli_stmt_execute($file_stmt);

                                                mysqli_stmt_close($file_stmt);
                                            }


                                            $uploadMessage =
                                                'فایل شما با موفقیت آپلود شد.';


                                        } else {


                                            $uploadMessage =
                                                'متأسفانه فایل شما آپلود نشد.';
                                        }
                                    }
                                }


                            } else {


                                $unsuccessful_submit =
                                    'خطا در ثبت اطلاعات مرخصی: ' .
                                    mysqli_error($Connect);
                            }


                            mysqli_stmt_close($stmt);


                        } else {


                            $unsuccessful_submit =
                                'خطا در آماده‌سازی درخواست ثبت مرخصی: ' .
                                mysqli_error($Connect);
                        }
                    }
                }
            }
        }


    } else {


        $massagefalse =
            'لطفاً گزینه‌های ستاره‌دار را پر کنید.';
    }
}

?>


<!DOCTYPE html>

<html lang="fa" dir="rtl">


<head>


    <meta charset="utf-8">


    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >


    <title>سامانه مدیریت کارکرد کارمندان</title>


    <meta
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport"
    >



    <link
        rel="stylesheet"
        href="../template/dist/css/persian-datepicker-0.4.5.min.css"
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


    <script src="../template/dist/js/persian-date-0.1.8.min.js"></script>

    <script src="../template/dist/js/persian-datepicker-0.4.5.min.js"></script>


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
                مرخصی
            </h1>


            <ol class="breadcrumb">


                <li>

                    <a href="#">

                        <i class="fa fa-dashboard"></i>

                        خانه

                    </a>

                </li>


                <li class="active">

                    مرخصی

                </li>


            </ol>


        </section>


        <?php if (!empty($date_time_select_error)): ?>


            <div class="alert alert-block alert-danger fade in">


                <button
                    data-dismiss="alert"
                    class="close close-sm"
                    type="button"
                >

                    <i class="fa fa-remove"></i>

                </button>


                <strong>خطا</strong>


                <?= htmlspecialchars(
                    $date_time_select_error,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>


            </div>


        <?php endif; ?>


        <?php if (!empty($massagefalse)): ?>


            <div class="alert alert-block alert-danger fade in">


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
                ) ?>


            </div>


        <?php endif; ?>


        <?php if (!empty($invalid_type)): ?>


            <div class="alert alert-block alert-danger fade in">


                <button
                    data-dismiss="alert"
                    class="close close-sm"
                    type="button"
                >

                    <i class="fa fa-remove"></i>

                </button>


                <strong>خطا</strong>


                <?= htmlspecialchars(
                    $invalid_type,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>


            </div>


        <?php endif; ?>


        <?php if (!empty($successful_submit)): ?>


            <div class="alert alert-block alert-success fade in">


                <strong>موفق</strong>


                <?= htmlspecialchars(
                    $successful_submit,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>


            </div>


        <?php endif; ?>


        <?php if (!empty($unsuccessful_submit)): ?>


            <div class="alert alert-block alert-danger fade in">


                <strong>خطا</strong>


                <?= htmlspecialchars(
                    $unsuccessful_submit,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>


            </div>


        <?php endif; ?>


        <?php if (!empty($uploadMessage)): ?>


            <div class="alert alert-block alert-info fade in">


                <?= htmlspecialchars(
                    $uploadMessage,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>


            </div>


        <?php endif; ?>



        <form
            role="form"
            name="form"
            method="POST"
            enctype="multipart/form-data"
        >


            <section class="content">


                <div class="row">


                    <div class="box box-primary">


                        <section class="p-15">


                            <div
                                class="w-100 bg-gray-light p-1 border-1 radius-1"
                            >


                                <div class="text-light-blue">

                                    میزان مرخصی دریافتی به شرح زیر است:

                                </div>


                                <br>


                                <div class="font-size-13 color-gray d-flex">


                                    <div class="w-25 color-gray">


                                        <div class="pb-10">

                                            ۲۴۰ ساعت استحقاقی در سال

                                        </div>


                                        <div>

                                            ساعات باقی‌مانده برای شما در ماه

                                            <?= 240 - (int)$row['token_hours_for_entitlent'] ?>

                                            ساعت

                                        </div>


                                    </div>


                                    <div class="w-25 color-gray">


                                        <div class="pb-10">

                                            ۲۴۰ ساعت استعلاجی در سال

                                        </div>


                                        <div>

                                            ساعات باقی‌مانده برای شما در ماه

                                            <?= 240 - (int)$row['token_hours_for_illness'] ?>

                                            ساعت

                                        </div>


                                    </div>


                                    <div class="w-25 color-gray">


                                        <div class="pb-10">

                                            بدون حقوق: نامحدود

                                        </div>


                                    </div>


                                </div>


                                <br>


                            </div>


                        </section>


                        <div class="box-body">


                            <div class="col-xs-4 pt-2">


                                <label for="leave_type">

                                    نوع مرخصی*

                                </label>


                                <select
                                    name="leave_type"
                                    id="leave_type"
                                    class="form-control w-50"
                                >


                                    <option
                                        value="1"
                                        selected
                                    >

                                        استعلاجی

                                    </option>


                                    <option value="2">

                                        استحقاقی

                                    </option>


                                    <option value="3">

                                        بدون حقوق

                                    </option>


                                </select>


                            </div>


                            <div class="col-xs-4 pt-2">


                                <label for="start_date">

                                    تاریخ شروع*

                                </label>


                                <input
                                    type="text"
                                    class="form-control w-50"
                                    id="start_date"
                                    name="start_date"
                                    required
                                >


                            </div>


                            <div class="col-xs-4 pt-2">


                                <label for="end_date">

                                    تاریخ پایان*

                                </label>


                                <input
                                    type="text"
                                    class="form-control w-50"
                                    id="end_date"
                                    name="end_date"
                                    required
                                >


                            </div>


                            <div class="col-xs-4 pt-2">


                                <label for="comment">

                                    توضیحات

                                </label>


                                <textarea
                                    class="form-control"
                                    rows="2"
                                    id="comment"
                                    name="comment"
                                ></textarea>


                            </div>


                            <div class="col-xs-4 pt-2">


                                <label for="fileToUpload">

                                    ارسال مدرک مربوطه

                                </label>


                                <input
                                    type="file"
                                    name="fileToUpload"
                                    id="fileToUpload"
                                >


                            </div>


                        </div>


                        <div class="box-body">


                            <button
                                name="submit"
                                type="submit"
                                class="btn btn-primary"
                            >

                                ارسال

                            </button>


                        </div>


                    </div>


                </div>


            </section>


        </form>


    </div>



    <footer class="main-footer text-left">


        <strong></strong>


    </footer>


    <div class="control-sidebar-bg"></div>


</div>



<script src="../template/bower_components/jquery/dist/jquery.min.js"></script>



<script src="../template/bower_components/jquery-ui/jquery-ui.min.js"></script>


<script>

    $.widget.bridge('uibutton', $.ui.button);

</script>



<script src="../template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>



<script src="../template/bower_components/raphael/raphael.min.js"></script>

<script src="../template/bower_components/morris.js/morris.min.js"></script>



<script src="../template/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>



<script src="../template/bower_components/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

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


    $('#start_date').pDatepicker({

        altFormat: 'X',

        format: 'YYYY/MM/DD, h:mm:ss',

        timePicker: {

            enabled: true

        }

    });


    $('#end_date').pDatepicker({

        altFormat: 'X',

        format: 'YYYY/MM/DD, h:mm:ss',

        timePicker: {

            enabled: true

        }

    });


});

</script>


</body>

</html>
