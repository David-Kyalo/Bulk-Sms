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
                Bulk SMS
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

        <body class="">
            <main class="main-content  mt-0">
                <section>
                    <div class="page-header min-vh-100">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                    <div class="card card-plain">
                                        <div class="card-header pb-0 text-start">
                                            <h4 class="font-weight-bolder">Sign Up</h4>
                                            <p class="mb-0">Enter your name, phone and password to create an account</p>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" action="doregister.php" method="POST">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-lg" placeholder="Name" aria-label="Name" name="name" autofocus required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control form-control-lg" placeholder="Phone Number" aria-label="Phone" name="phone" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Confirm Password" name="confirm_password" required>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign Up</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                            <p class="mb-4 text-sm mx-auto">
                                                Already have an account?
                                                <a href="login.php" class="text-primary text-gradient font-weight-bold">Sign In</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <!--   Core JS Files   -->
            <script src="../assets/js/core/popper.min.js"></script>
            <script src="../assets/js/core/bootstrap.min.js"></script>
            <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
        </body>
    </html>