<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../../functions/function.php");
include("../../functions/conection.php");

if (!isset($_SESSION['employee_id'])) {
    header("Location: /adminPanel/login.php");
    exit;
}

$employee_id = (int)$_SESSION['employee_id'];

$sql = "
    SELECT
        leave_id,
        leave_type,
        start_date,
        end_date,
        comment,
        status,
        total_hours
    FROM `leave`
    WHERE employee_id = ?
    ORDER BY leave_id DESC
";

$stmt = mysqli_prepare($Connect, $sql);

if (!$stmt) {
    die("خطا در آماده‌سازی درخواست: " . mysqli_error($Connect));
}

mysqli_stmt_bind_param($stmt, "i", $employee_id);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    die("خطا در دریافت اطلاعات مرخصی: " . mysqli_error($Connect));
}

$data = mysqli_stmt_get_result($stmt);

if (!$data) {
    mysqli_stmt_close($stmt);
    die("خطا در دریافت اطلاعات مرخصی: " . mysqli_error($Connect));
}

function getLeaveType($type)
{
    switch ($type) {
        case 'illness':
            return 'استعلاجی';

        case 'without_salary':
            return 'بدون حقوق';

        case 'entitlent':
            return 'استحقاقی';

        default:
            return 'نامشخص';
    }
}

function getLeaveStatus($status)
{
    switch ($status) {
        case 'approval':
            return 'تأیید شده';

        case 'disapproval':
            return 'رد شده';

        case 'manager2_approval':
            return 'تأیید مدیر دوم';

        case 'not-define':
            return 'در انتظار بررسی';

        default:
            return 'نامشخص';
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

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
                مرخصی‌های من
            </h1>

            <ol class="breadcrumb">

                <li>

                    <a href="/adminPanel/index.php">

                        <i class="fa fa-dashboard"></i>

                        خانه

                    </a>

                </li>

                <li class="active">
                    مرخصی‌های من
                </li>

            </ol>

        </section>


        <section class="content">

            <div class="row">

                <div class="col-xs-12">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                            <h3 class="box-title">
                                لیست مرخصی‌های من
                            </h3>

                        </div>


                        <div class="box-body">

                            <div class="table-responsive">

                                <table
                                    class="table table-bordered table-striped table-hover"
                                >

                                    <thead>

                                        <tr>

                                            <th>
                                                ردیف
                                            </th>

                                            <th>
                                                نوع مرخصی
                                            </th>

                                            <th>
                                                تاریخ شروع
                                            </th>

                                            <th>
                                                تاریخ پایان
                                            </th>

                                            <th>
                                                مدت
                                            </th>

                                            <th>
                                                توضیحات
                                            </th>

                                            <th>
                                                وضعیت
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                    <?php

                                    $counter = 1;

                                    if (mysqli_num_rows($data) > 0):

                                        while ($row = mysqli_fetch_assoc($data)):

                                    ?>

                                        <tr>

                                            <td>
                                                <?= $counter ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    getLeaveType($row['leave_type']),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $row['start_date'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $row['end_date'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= (int)$row['total_hours'] ?>
                                                ساعت
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $row['comment'] ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>

                                                <?php

                                                $status = getLeaveStatus(
                                                    $row['status']
                                                );

                                                if ($row['status'] === 'approval'):

                                                ?>

                                                    <span class="label label-success">
                                                        <?= $status ?>
                                                    </span>

                                                <?php

                                                elseif (
                                                    $row['status'] === 'disapproval'
                                                ):

                                                ?>

                                                    <span class="label label-danger">
                                                        <?= $status ?>
                                                    </span>

                                                <?php

                                                elseif (
                                                    $row['status'] === 'manager2_approval'
                                                ):

                                                ?>

                                                    <span class="label label-info">
                                                        <?= $status ?>
                                                    </span>

                                                <?php else: ?>

                                                    <span class="label label-warning">
                                                        <?= $status ?>
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                        </tr>

                                    <?php

                                            $counter++;

                                        endwhile;

                                    else:

                                    ?>

                                        <tr>

                                            <td
                                                colspan="7"
                                                class="text-center"
                                            >

                                                هنوز هیچ مرخصی‌ای برای شما ثبت نشده است.

                                            </td>

                                        </tr>

                                    <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

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

</body>

</html>
