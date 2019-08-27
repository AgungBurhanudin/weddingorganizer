<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="images/apple-touch-startup-image-640x1096.png">
        <meta name="author" content="SINDEVO.COM" />
        <meta name="description" content="biotic - mobile and tablet web app template" />
        <meta name="keywords" content="mobile css template, mobile html template, jquery mobile template, mobile app template, html5 mobile design, mobile design" />
        <title>biotic - login</title>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/themes/default/jquery.mobile-1.4.5.css">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/style.css" />
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/colors/yellow.css" />
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/swipebox.css" />
    </head>
    <body>

        <div data-role="page" id="login" class="secondarypage" data-theme="b">


            <div role="main" class="ui-content">

                <div class="content-block-login">
                    <div class="form_logo">
                        <center>
                            <img src="<?= base_url() ?>assets/images/logo_mahkota.png" width="85%" style="margin: 0 auto"> 
                        </center>LOGIN</div>

                    <div class="loginform">
                        <?php
                        if (isset($message)) {
                            ?>
                            <div style="color: red; text-align: center; width:100%; ">
                                <?= $message; ?>
                            </div>

                            <?php
                        }
                        ?>
                        <form id="LoginForm" method="post" action="<?= base_url() ?>Login/login">
                            <input type="text" name="username" value="" class="form_input required" placeholder="username" data-role="none" />
                            <input type="password" name="password" value="" class="form_input required" placeholder="password" data-role="none" />
                            <div class="forgot_pass"><a href="forgotpass.html" data-transition="slidedown">Forgot Password?</a></div>
                            <input type="submit" name="submit" class="form_submit" id="submit" data-role="none" value="SIGN IN" />
                        </form>

                        <!--                        <div class="signup_bottom">
                                                    <p>Don't have an account?</p>
                                                    <a href="register.html" data-transition="slidedown">SIGN UP</a>
                                                </div>-->

                    </div>


                </div>

            </div><!-- /content -->


        </div><!-- /page -->
        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.mobile-1.4.5.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/email.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.swipebox.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.mobile-custom.js"></script>
    </body>
</html>
