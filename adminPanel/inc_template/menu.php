<?php


$canManageLeave = (
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'admin' &&
    isset($_SESSION['position']) &&
    in_array($_SESSION['position'], ['manager1', 'manager2'], true)
);

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">

            <div class="pull-right image">

                <img
                    src="/adminPanel/template/dist/img/user2-160x160.jpg"
                    class="img-circle"
                    alt="User Image"
                >

            </div>

            <div class="pull-right info">

                <p>
                    <?php
                    echo htmlspecialchars(
                        ($_SESSION['first_name'] ?? '') . ' ' .
                        ($_SESSION['last_name'] ?? ''),
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </p>

                <a href="#">

                    <i class="fa fa-circle text-success"></i>

                    آنلاین

                </a>

            </div>

        </div>


        <form
            action="#"
            method="get"
            class="sidebar-form"
        >

            <div class="input-group">

                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="جستجو"
                >

                <span class="input-group-btn">

                    <button
                        type="submit"
                        name="search"
                        id="search-btn"
                        class="btn btn-flat"
                    >

                        <i class="fa fa-search"></i>

                    </button>

                </span>

            </div>

        </form>


        <ul
            class="sidebar-menu"
            data-widget="tree"
        >

            <li class="header">
                منو
            </li>

            <li>

                <a href="/adminPanel/index.php">

                    <i class="fa fa-dashboard"></i>

                    <span>
                        صفحه اصلی
                    </span>

                </a>

            </li>
            <?php if ($canManageLeave): ?>

                <li class="treeview">

                    <a href="#">

                        <i class="fa fa-calendar-check-o"></i>

                        <span>
                            مدیریت مرخصی ها
                        </span>

                        <span class="pull-left-container">

                            <i class="fa fa-angle-right pull-left"></i>

                        </span>

                    </a>


                    <ul class="treeview-menu">

                        <li>

                            <a href="/adminPanel/leave/manage_leave.php">

                                <i class="fa fa-circle-o"></i>

                                بررسی درخواست‌های مرخصی

                            </a>

                        </li>

                    </ul>

                </li>

            <?php endif; ?>

            <li class="treeview">

                <a href="#">

                    <i class="fa fa-files-o"></i>

                    <span>
                        مرخصی
                    </span>

                    <span class="pull-left-container">

                        <i class="fa fa-angle-right pull-left"></i>

                    </span>

                </a>


                <ul class="treeview-menu">


                    <li>

                        <a href="/adminPanel/leave/add_leave.php">

                            <i class="fa fa-circle-o"></i>

                            درخواست مرخصی جدید

                        </a>

                    </li>



                    <li>

                        <a href="/adminPanel/leave/show_myleave.php">

                            <i class="fa fa-circle-o"></i>

                            نمایش مرخصی های من

                        </a>

                    </li>

                </ul>

            </li>

            <?php if (
                isset($_SESSION['role']) &&
                $_SESSION['role'] === 'admin'
            ): ?>

                <li class="treeview">

                    <a href="#">

                        <i class="fa fa-users"></i>

                        <span>
                            مدیریت کارمندان
                        </span>

                        <span class="pull-left-container">

                            <i class="fa fa-angle-right pull-left"></i>

                        </span>

                    </a>


                    <ul class="treeview-menu">



                        <li>

                            <a href="/adminPanel/employee/addـemployee.php">

                                <i class="fa fa-circle-o"></i>

                                افزودن کارمند جدید

                            </a>

                        </li>



                        <li>

                            <a href="/adminPanel/employee/manage_employee.php">

                                <i class="fa fa-circle-o"></i>

                                نمایش کارمندان

                            </a>

                        </li>


                    </ul>

                </li>

            <?php endif; ?>

            <li>

                <a href="/adminPanel/logout.php">

                    <i class="fa fa-sign-out"></i>

                    <span>
                        خروج
                    </span>

                </a>

            </li>


        </ul>

    </section>

</aside>
