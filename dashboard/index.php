<?php
    // Start the session. The session is used to store the user's authentication status
    session_start();

    // Check if the user is authenticated
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
        // Display the dashboard
    } else {
        // Redirect to the login page
        header('Location: ./auth/login.php');
        exit;
    }
    // check if the user is verified
    // Create a new database instance
    include_once '../config/Database.php';
    $db = new Database();
    $pdo = $db->connect();

    // Check if the user's verified_at field is not null
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user['verified_at'] === null) {
        // Handle unverified user error
        echo 'Your account is not verified.';
        echo '<a href="../auth/verify.php">Verify now</a>';
        exit;
    }

    // Select * from messages
    $query = "SELECT * FROM messages";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // count the number of groups
    $query = "SELECT COUNT(*) FROM groups";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $group_count = $stmt->fetchColumn();

    // count the number of failed messages
    $query = "SELECT COUNT(*) FROM messages WHERE status = 'failed'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $failed_count = $stmt->fetchColumn();

    // count the number of successful messages
    $query = "SELECT COUNT(*) FROM messages WHERE status = 'success'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $success_count = $stmt->fetchColumn();

    // count the number of in progress messages
    $query = "SELECT COUNT(*) FROM messages WHERE status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $pending_count = $stmt->fetchColumn();
?>
<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
            <link rel="icon" type="image/png" href="../assets/img/favicon.png">
            <title>
                Bulk SMS Dashboard
            </title>
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
        </head>

        <body class="g-sidenav-show   bg-gray-100">
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
                <div class="sidenav-header">
                    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                    <a class="navbar-brand m-0" href="">
                        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
                        <span class="ms-1 font-weight-bold">Bulk SMS</span>
                    </a>
                </div>
                <hr class="horizontal dark mt-0">
                <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="new.php">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-send text-dark text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Send SMS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="history.php">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-info text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">History</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="contacts.php">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa fa-users text-dark text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Contacts</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="../auth/logout.php">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-button-power text-danger text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidenav-footer mx-3 ">
                    <div class="card card-plain shadow-none" id="sidenavCard">
                        <img class="w-50 mx-auto" src="../assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
                        <div class="card-body text-center p-3 w-100 pt-0">
                            <div class="docs-info">
                                <h6 class="mb-0">Need help?</h6>
                                <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
                            </div>
                        </div>
                    </div>
                    <a href="https://github.com/uzimasam/bulk-sms/blob/main/README.md" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
                </div>
            </aside>
            <main class="main-content position-relative border-radius-lg ">
                <!-- Navbar -->
                    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
                        <div class="container-fluid py-1 px-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="../">Bulk SMS</a></li>
                                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
                                </ol>
                                <h6 class="font-weight-bolder text-white mb-0">Hello <?php echo $user['name']; ?></h6>
                            </nav>
                            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                                </div>
                                <ul class="navbar-nav  justify-content-end">
                                    <li class="nav-item d-flex align-items-center">
                                        <a href="../auth/logout.php" class="nav-link text-white font-weight-bold px-0">
                                            <i class="fa fa-user me-sm-1"></i>
                                            <span class="d-sm-inline d-none">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                <!-- End Navbar -->
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Contact Groups</p>
                                                <h5 class="font-weight-bolder">
                                                    <?php echo $group_count; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Failed SMS</p>
                                                <h5 class="font-weight-bolder">
                                                    <?php echo $failed_count; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Successful SMS</p>
                                                <h5 class="font-weight-bolder">
                                                    <?php echo $success_count; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">In Progress</p>
                                                <h5 class="font-weight-bolder">
                                                    <?php echo $pending_count; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 mb-lg-0 mb-4">
                            <div class="card ">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-2">Mesages</h6>
                                            <p class="text-sm">You have sent <?php echo count($messages); ?> messages</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($messages as $message) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                <img src="../assets/img/tim.png" class="avatar avatar-sm rounded-circle me-2" alt="user image">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">
                                                                    <?php
                                                                        // Select * from groups where id = message['group_id']
                                                                        $query = "SELECT * FROM groups WHERE id = :id";
                                                                        $stmt = $pdo->prepare($query);
                                                                        $stmt->bindParam(':id', $message['group_id']);
                                                                        $stmt->execute();
                                                                        $group = $stmt->fetch(PDO::FETCH_ASSOC);
                                                                        echo $group['name'];
                                                                    ?>
                                                                </h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    <?php
                                                                        // Select count(*) from recepients where group_id = message['group_id']
                                                                        $query = "SELECT COUNT(*) FROM recepients WHERE group_id = :group_id";
                                                                        $stmt = $pdo->prepare($query);
                                                                        $stmt->bindParam(':group_id', $message['group_id']);
                                                                        $stmt->execute();
                                                                        $contact_count = $stmt->fetchColumn();
                                                                        echo $contact_count . ' Contacts';
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0"><?php echo $message['message']; ?></p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $message['created_at']; ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (count($messages) === 0) : ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No messages found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <?php if (count($messages) > 0) : ?>
                                            <span class="text-dark text-sm">Showing 1 to <?php echo count($messages); ?> of <?php echo count($messages); ?> entries</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer pt-3  ">
                        <div class="container-fluid">
                            <div class="row align-items-center justify-content-lg-between">
                                <div class="col-lg-6 mb-lg-0 mb-4">
                                    <div class="copyright text-center text-sm text-muted text-lg-start">
                                        © <script>
                                            document.write(new Date().getFullYear())
                                        </script>,
                                        made with <i class="fa fa-heart"></i> by
                                        <a href="https://github.com/uzimasam" class="font-weight-bold" target="_blank">David Kyalo</a>
                                        for a better web.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </main>
            <!--   Core JS Files   -->
            <script src="../assets/js/core/popper.min.js"></script>
            <script src="../assets/js/core/bootstrap.min.js"></script>
            <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
            <script>
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
            </script>
            <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
            <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
        </body>
    </html>
