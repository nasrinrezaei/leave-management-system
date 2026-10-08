<?php


include("../../functions/auth.php");

requireLeaveManager();

include("../../functions/conection.php");


$sql = "
    SELECT
        e.employee_id,
        e.department_id,
        e.first_name,
        e.last_name,
        e.Ssn,
        e.birth_date,
        e.start_date,
        e.gender,
        e.marital_staus,
        e.role,
        e.mobile,
        e.user_name,
        e.email,
        e.position,
        e.photo

    FROM employee AS e

    ORDER BY e.employee_id DESC
";


$result = mysqli_query($Connect, $sql);


$query_error = '';

if (!$result) {

    $query_error = mysqli_error($Connect);

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

    <title>مدیریت کارمندان</title>

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

            مدیریت کارمندان

            <small>لیست کارمندان</small>

        </h1>


        <ol class="breadcrumb">

            <li>

                <a href="#">

                    <i class="fa fa-dashboard"></i>

                    خانه

                </a>

            </li>


            <li class="active">

                کارمندان

            </li>

        </ol>

    </section>



    <section class="content">



        <?php if ($query_error !== ''): ?>

            <div class="alert alert-danger">

                <i class="fa fa-warning"></i>

                خطا در دریافت اطلاعات کارمندان.

                <br>

                <small>

                    <?= htmlspecialchars(
                        $query_error,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </small>

            </div>

        <?php endif; ?>


        <div class="row">

            <div class="col-md-12">


                <div class="box box-primary">



                    <div class="box-header with-border">

                        <h3 class="box-title">

                            <i class="fa fa-users"></i>

                            لیست کارمندان

                        </h3>

                    </div>



                    <div class="box-body">


                        <div class="table-responsive">


                            <table
                                class="table table-bordered table-striped table-hover"
                            >


                                <thead>

                                    <tr>

                                        <th class="text-center">

                                            ردیف

                                        </th>


                                        <th class="text-center">

                                            عکس

                                        </th>


                                        <th>

                                            نام و نام خانوادگی

                                        </th>


                                        <th>

                                            کد کارمند

                                        </th>


                                        <th>

                                            کد ملی

                                        </th>


                                        <th>

                                            جنسیت

                                        </th>


                                        <th>

                                            وضعیت تأهل

                                        </th>


                                        <th>

                                            موبایل

                                        </th>


                                        <th>

                                            نام کاربری

                                        </th>


                                        <th>

                                            سمت

                                        </th>


                                        <th>

                                            نقش

                                        </th>


                                        <th>

                                            تاریخ شروع به کار

                                        </th>


                                    </tr>

                                </thead>


                                <tbody>


                                <?php if ($result && mysqli_num_rows($result) > 0): ?>


                                    <?php

                                    $row_number = 1;

                                    while ($employee = mysqli_fetch_assoc($result)):

                                    ?>


                                        <tr>



                                            <td class="text-center">

                                                <?= $row_number++ ?>

                                            </td>



                                            <td class="text-center">


                                                <?php if (
                                                    !empty($employee['photo'])
                                                ): ?>


                                                    <img
                                                        src="../uploads/employees/<?= htmlspecialchars(
                                                            $employee['photo'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>"
                                                        alt="عکس کارمند"
                                                        style="
                                                            width:50px;
                                                            height:50px;
                                                            object-fit:cover;
                                                            border-radius:50%;
                                                        "
                                                    >


                                                <?php else: ?>


                                                    <i
                                                        class="fa fa-user-circle-o"
                                                        style="
                                                            font-size:40px;
                                                            color:#aaa;
                                                        "
                                                    ></i>


                                                <?php endif; ?>


                                            </td>



                                            <td>

                                                <strong>

                                                    <?= htmlspecialchars(
                                                        $employee['first_name'] . ' ' . $employee['last_name'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>

                                                </strong>

                                            </td>



                                            <td>

                                                <?= (int)$employee['employee_id'] ?>

                                            </td>



                                            <td>

                                                <?php if (
                                                    !empty($employee['Ssn'])
                                                ): ?>

                                                    <?= htmlspecialchars(
                                                        $employee['Ssn'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>

                                                <?php else: ?>

                                                    <span class="text-muted">

                                                        ثبت نشده

                                                    </span>

                                                <?php endif; ?>

                                            </td>



                                            <td>

                                                <?php if (
                                                    $employee['gender'] === 'woman'
                                                ): ?>

                                                    <span class="label label-info">

                                                        زن

                                                    </span>

                                                <?php elseif (
                                                    $employee['gender'] === 'man'
                                                ): ?>

                                                    <span class="label label-primary">

                                                        مرد

                                                    </span>

                                                <?php else: ?>

                                                    <span class="label label-default">

                                                        نامشخص

                                                    </span>

                                                <?php endif; ?>

                                            </td>



                                            <td>

                                                <?php if (
                                                    $employee['marital_staus'] === 'married'
                                                ): ?>

                                                    <span class="label label-success">

                                                        متأهل

                                                    </span>

                                                <?php else: ?>

                                                    <span class="label label-default">

                                                        مجرد

                                                    </span>

                                                <?php endif; ?>

                                            </td>



                                            <td>

                                                <?php if (
                                                    !empty($employee['mobile'])
                                                ): ?>

                                                    <?= htmlspecialchars(
                                                        $employee['mobile'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>

                                                <?php else: ?>

                                                    <span class="text-muted">

                                                        ثبت نشده

                                                    </span>

                                                <?php endif; ?>

                                            </td>



                                            <td>

                                                <?php if (
                                                    !empty($employee['user_name'])
                                                ): ?>

                                                    <?= htmlspecialchars(
                                                        $employee['user_name'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>

                                                <?php else: ?>

                                                    <span class="text-muted">

                                                        ثبت نشده

                                                    </span>

                                                <?php endif; ?>

                                            </td>



                                            <td>

                                                <?php

                                                switch ($employee['position']) {

                                                    case 'employee':

                                                        echo '<span class="label label-default">کارمند</span>';

                                                        break;


                                                    case 'manager1':

                                                        echo '<span class="label label-warning">مدیر مرحله اول</span>';

                                                        break;


                                                    case 'manager2':

                                                        echo '<span class="label label-info">مدیر مرحله دوم</span>';

                                                        break;


                                                    default:

                                                        echo '<span class="label label-default">نامشخص</span>';

                                                        break;

                                                }

                                                ?>

                                            </td>



                                            <td>

                                                <?php if (
                                                    $employee['role'] === 'admin'
                                                ): ?>

                                                    <span class="label label-danger">

                                                        مدیر سیستم

                                                    </span>

                                                <?php else: ?>

                                                    <span class="label label-success">

                                                        کاربر

                                                    </span>

                                                <?php endif; ?>

                                            </td>



                                            <td>

                                                <?= htmlspecialchars(
                                                    $employee['start_date'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </td>


                                        </tr>


                                    <?php endwhile; ?>


                                <?php else: ?>


                                    <tr>

                                        <td
                                            colspan="12"
                                            class="text-center"
                                        >

                                            <div
                                                style="
                                                    padding:30px;
                                                    color:#777;
                                                "
                                            >

                                                <i
                                                    class="fa fa-users"
                                                    style="
                                                        font-size:50px;
                                                        margin-bottom:15px;
                                                    "
                                                ></i>


                                                <br>


                                                هیچ کارمندی ثبت نشده است.

                                            </div>

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


