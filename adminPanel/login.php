<?php

session_start();

include("../functions/conection.php");

$error = '';

if (isset($_SESSION['employee_id'])) {

    header("Location: /adminPanel/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {

        $error = 'لطفاً نام کاربری و رمز عبور را وارد کنید.';

    } else {

        $stmt = mysqli_prepare(
            $Connect,
            "SELECT
                employee_id,
                first_name,
                last_name,
                user_name,
                password,
                role,
                position
             FROM employee
             WHERE user_name = ?
             LIMIT 1"
        );

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "s",
                $username
            );

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            $user = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);


            /*
            |--------------------------------------------------------------------------
            | بررسی کاربر
            |--------------------------------------------------------------------------
            */

            if (
                $user &&
                password_verify($password, $user['password'])
            ) {

                session_regenerate_id(true);

                $_SESSION['employee_id'] = (int)$user['employee_id'];

                $_SESSION['first_name'] =
                    $user['first_name'];

                $_SESSION['last_name'] =
                    $user['last_name'];

                $_SESSION['role'] =
                    $user['role'];

                $_SESSION['position'] =
                    $user['position'];

                $_SESSION['username'] =
                    $user['user_name'];


                header("Location: /adminPanel/index.php");
                exit;

            } else {

                $error =
                    'نام کاربری یا رمز عبور اشتباه است.';
            }
        } else {

            $error =
                'خطا در ارتباط با دیتابیس.';
        }
    }
}

?>

<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>ورود به سامانه</title>

    <link
        rel="stylesheet"
        href="template/dist/css/bootstrap-theme.css"
    >

    <link
        rel="stylesheet"
        href="template/dist/css/rtl.css"
    >

    <link
        rel="stylesheet"
        href="template/dist/css/AdminLTE.css"
    >

    <link
        rel="stylesheet"
        href="template/bower_components/font-awesome/css/font-awesome.min.css"
    >

</head>

<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo">

        <b>سامانه</b>
        مدیریت کارمندان

    </div>


    <div class="login-box-body">

        <p class="login-box-msg">

            برای ورود اطلاعات خود را وارد کنید

        </p>


        <?php if ($error !== ''): ?>

            <div class="alert alert-danger">

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="form-group has-feedback">

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="نام کاربری"
                    autocomplete="username"
                    required
                >

                <span
                    class="glyphicon glyphicon-user form-control-feedback"
                ></span>

            </div>


            <div class="form-group has-feedback">

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="رمز عبور"
                    autocomplete="current-password"
                    required
                >

                <span
                    class="glyphicon glyphicon-lock form-control-feedback"
                ></span>

            </div>


            <div class="row">

                <div class="col-xs-12">

                    <button
                        type="submit"
                        class="btn btn-primary btn-block btn-flat"
                    >

                        ورود

                    </button>

                </div>

            </div>


        </form>

    </div>

</div>


<script src="template/bower_components/jquery/dist/jquery.min.js"></script>

<script src="template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>