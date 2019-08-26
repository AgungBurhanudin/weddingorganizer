<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="Wedding Organizer Wedding Organizer App">
        <meta name="author" content="Salatiga Web">
        <meta name="keyword" content="Wedding, WO, Wedding Organizer, Nikah, Kawin, Pernikahan">
        <title>Wedding Organizer </title>
        <!-- Icons-->
        <link rel="icon" type="image/ico" href="assets/icon.jpg" sizes="any" />
        <link href="assets/vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="assets/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
        <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
        <!-- Main styles for this application-->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            // Shared ID
            gtag('config', 'UA-118965717-3');
            // Bootstrap ID
            gtag('config', 'UA-118965717-5');
        </script>
        <!-- CoreUI and necessary plugins-->
        <script src="assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="assets/vendors/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="assets/vendors/pace-progress/pace.min.js"></script>
        <script src="assets/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="assets/vendors/@coreui/coreui/dist/js/coreui.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
    </head>

    <body class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div id="alert" class="alert alert-danger" role="alert"></div>

                    <div class="card-group">
                        <div class="card p-4">
                            <div class="card-body">
                                <form method="post" action="#" onsubmit="login()" id="formLogin">

                                    <h1>Login</h1>
                                    <p class="text-muted">Sign In to your account</p>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-user"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" name="username" id="username" type="text" placeholder="Username">
                                    </div>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-lock"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" name="password" id="password" type="password" placeholder="Password">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit" onclick="login()">Login</button>
                                        </div>
                                        <div class="col-6 text-right">
                                            <!-- <button class="btn btn-link px-0" type="button">Forgot password?</button> -->
                                        </div>
                                    </div>
                                </form>                                
                            </div>
                            </form>
                        </div>
                        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                            <div class="card-body text-center">
                                <div>
                                    <img src="assets/logo.png">
                                    <!-- <h2>Sign up</h2> -->
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $("#alert").hide();
            });

            function login() {
                var formData = new FormData($("#formLogin")[0]);
                $('#formLogin').validate({
                    rules: {
                        username: "required",
                        password: "required"
                    },
                    messages: {
                        username: "Username harus di isi",
                        password: "Password  harus di isi"
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            url: "<?= base_url() ?>Login/login",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "JSON",
                            success: function (data) {
                                if (data.code == "200") {
                                    window.location.href = "<?= base_url() ?>Dashboard";
                                } else {
                                    $("#alert").show();
                                    $("#alert").html(data.message);
                                }
                            }
                        });
                    }
                });
            }
        </script>

    </body>

</html>