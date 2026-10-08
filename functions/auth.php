<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function requireLogin()
{
    if (
        !isset($_SESSION['employee_id']) ||
        !isset($_SESSION['role'])
    ) {
        header("Location: /adminPanel/login.php");
        exit;
    }
}

function requireAdmin()
{
    requireLogin();

    if ($_SESSION['role'] !== 'admin') {
        http_response_code(403);

        echo '
        <!DOCTYPE html>
        <html lang="fa" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>عدم دسترسی</title>
        </head>
        <body>
            <h2>شما اجازه دسترسی به این صفحه را ندارید.</h2>

            <a href="/adminPanel/index.php">
                بازگشت به پنل
            </a>
        </body>
        </html>
        ';

        exit;
    }
}


function requireLeaveManager()
{
    requireLogin();

    if (
        $_SESSION['role'] !== 'admin' ||
        !in_array(
            $_SESSION['position'] ?? '',
            ['manager1', 'manager2'],
            true
        )
    ) {
        http_response_code(403);

        echo '
        <!DOCTYPE html>
        <html lang="fa" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>عدم دسترسی</title>
        </head>

        <body>

            <h2>
                شما اجازه تأیید یا رد درخواست‌های مرخصی را ندارید.
            </h2>

            <a href="/adminPanel/index.php">
                بازگشت به پنل
            </a>

        </body>
        </html>
        ';

        exit;
    }
}