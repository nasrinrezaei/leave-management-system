<?php

include("../../functions/auth.php");

requireLeaveManager();


include("../../functions/conection.php");


$message = '';
$message_type = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $leave_id = (int)($_POST['leave_id'] ?? 0);
    $action = $_POST['action'] ?? '';


    if ($leave_id <= 0) {

        $message = 'شناسه مرخصی نامعتبر است.';
        $message_type = 'danger';

    } elseif (!in_array($action, ['approve', 'reject'], true)) {

        $message = 'عملیات نامعتبر است.';
        $message_type = 'danger';

    } else {


        if ($action === 'approve') {

            $new_status = 'approval';

        } else {

            $new_status = 'disapproval';

        }


        $stmt = mysqli_prepare(
            $Connect,
            "UPDATE `leave`
             SET status = ?
             WHERE leave_id = ?
             AND status = 'not-define'"
        );


        if (!$stmt) {

            $message = 'خطا در آماده‌سازی درخواست.';
            $message_type = 'danger';

        } else {

            mysqli_stmt_bind_param(
                $stmt,
                "si",
                $new_status,
                $leave_id
            );


            if (mysqli_stmt_execute($stmt)) {

                if (mysqli_stmt_affected_rows($stmt) > 0) {

                    if ($action === 'approve') {

                        $message = 'مرخصی با موفقیت تأیید شد.';

                    } else {

                        $message = 'مرخصی با موفقیت رد شد.';

                    }

                    $message_type = 'success';

                } else {

                    $message = 'این مرخصی قبلاً بررسی شده یا وجود ندارد.';
                    $message_type = 'warning';

                }

            } else {

                $message = 'خطا در تغییر وضعیت مرخصی.';
                $message_type = 'danger';

            }


            mysqli_stmt_close($stmt);
        }
    }
}


$sql = "
    SELECT
        l.leave_id,
        l.employee_id,
        l.leave_type,
        l.start_date,
        l.end_date,
        l.comment,
        l.status,
        l.total_hours,

        e.first_name,
        e.last_name

    FROM `leave` AS l

    INNER JOIN employee AS e
        ON e.employee_id = l.employee_id

    ORDER BY l.leave_id DESC
";


$result = mysqli_query($Connect, $sql);

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


require_once __DIR__ . '/../inc_template/header.php';

require_once __DIR__ . '/../inc_template/menu.php';

?>



<div class="content-wrapper">



    <section class="content-header">

        <h1>

            مدیریت مرخصی

            <small>تأیید و رد درخواست‌ها</small>

        </h1>


        <ol class="breadcrumb">

            <li>

                <a href="#">

                    <i class="fa fa-dashboard"></i>

                    خانه

                </a>

            </li>


            <li class="active">

                مدیریت مرخصی

            </li>

        </ol>

    </section>



    <section class="content">


        <?php if ($message !== ''): ?>

            <div
                class="alert alert-block alert-<?= htmlspecialchars(
                    $message_type,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?> fade in"
            >

                <button
                    data-dismiss="alert"
                    class="close close-sm"
                    type="button"
                >

                    <i class="fa fa-remove"></i>

                </button>


                <?= htmlspecialchars(
                    $message,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </div>

        <?php endif; ?>


        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">


                    <div class="box-header with-border">

                        <h3 class="box-title">

                            لیست درخواست‌های مرخصی

                        </h3>

                    </div>


                    <div class="box-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>ردیف</th>

                                        <th>کارمند</th>

                                        <th>نوع مرخصی</th>

                                        <th>تاریخ شروع</th>

                                        <th>تاریخ پایان</th>

                                        <th>ساعت</th>

                                        <th>توضیحات</th>

                                        <th>وضعیت</th>

                                        <th>عملیات</th>

                                    </tr>

                                </thead>


                                <tbody>


                                <?php if ($result && mysqli_num_rows($result) > 0): ?>


                                    <?php while ($leave = mysqli_fetch_assoc($result)): ?>

                                        <tr>


                                            <td>

                                                <?= (int)$leave['leave_id'] ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $leave['first_name'] . ' ' . $leave['last_name'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                                <br>

                                                <small>

                                                    کد پرسنلی:

                                                    <?= (int)$leave['employee_id'] ?>

                                                </small>

                                            </td>


                                            <td>

                                                <?php

                                                switch ($leave['leave_type']) {

                                                    case 'without_salary':

                                                        echo 'بدون حقوق';

                                                        break;

                                                    case 'illness':

                                                        echo 'استعلاجی';

                                                        break;

                                                    case 'entitlent':

                                                        echo 'استحقاقی';

                                                        break;

                                                    default:

                                                        echo htmlspecialchars(
                                                            $leave['leave_type'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                }

                                                ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $leave['start_date'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $leave['end_date'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </td>


                                            <td>

                                                <?= (int)$leave['total_hours'] ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $leave['comment'] ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </td>


                                            <td>


                                                <?php if ($leave['status'] === 'not-define'): ?>

                                                    <span class="label label-warning">

                                                        در انتظار بررسی

                                                    </span>


                                                <?php elseif ($leave['status'] === 'approval'): ?>

                                                    <span class="label label-success">

                                                        تأیید شده

                                                    </span>


                                                <?php elseif ($leave['status'] === 'disapproval'): ?>

                                                    <span class="label label-danger">

                                                        رد شده

                                                    </span>


                                                <?php elseif ($leave['status'] === 'manager2_approval'): ?>

                                                    <span class="label label-info">

                                                        تأیید مرحله اول

                                                    </span>


                                                <?php else: ?>

                                                    <span class="label label-default">

                                                        نامشخص

                                                    </span>

                                                <?php endif; ?>


                                            </td>


                                            <td>


                                                <?php if ($leave['status'] === 'not-define'): ?>


                                                    <form
                                                        method="POST"
                                                        style="display:inline-block;"
                                                    >

                                                        <input
                                                            type="hidden"
                                                            name="leave_id"
                                                            value="<?= (int)$leave['leave_id'] ?>"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="action"
                                                            value="approve"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('آیا از تأیید این مرخصی مطمئن هستید؟');"
                                                        >

                                                            <i class="fa fa-check"></i>

                                                            تأیید

                                                        </button>

                                                    </form>



                                                    <form
                                                        method="POST"
                                                        style="display:inline-block;"
                                                    >

                                                        <input
                                                            type="hidden"
                                                            name="leave_id"
                                                            value="<?= (int)$leave['leave_id'] ?>"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="action"
                                                            value="reject"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('آیا از رد این مرخصی مطمئن هستید؟');"
                                                        >

                                                            <i class="fa fa-times"></i>

                                                            رد

                                                        </button>

                                                    </form>


                                                <?php else: ?>

                                                    <span class="text-muted">

                                                        بررسی شده

                                                    </span>

                                                <?php endif; ?>


                                            </td>


                                        </tr>


                                    <?php endwhile; ?>


                                <?php else: ?>


                                    <tr>

                                        <td
                                            colspan="9"
                                            class="text-center"
                                        >

                                            هیچ درخواست مرخصی ثبت نشده است.

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


</body>

</html>
