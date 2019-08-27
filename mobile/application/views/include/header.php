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
        <title>Wedding Organizer</title>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/themes/default/jquery.mobile-1.4.5.css">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/style.css" />
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/colors/yellow.css" />
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/swipebox.css" />
        <link rel="icon" type="image/ico" href="<?= base_url() ?>assets/images/icon.jpg" sizes="any" />
    </head>
    <body>

        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.mobile-1.4.5.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/email.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.swipebox.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.mobile-custom.js"></script>

        <div data-role="page" id="features" class="secondarypage" data-theme="b">

            <div data-role="header" data-position="fixed">
                <div class="nav_left_button"><a href="#" class="nav-toggle"><span></span></a></div>
                <div class="nav_center_logo">Mahkota</div>
                <div class="nav_right_button"><a href="#right-panel"><img src="<?= base_url() ?>assets/images/icons/white/user.png" alt="" title="" /></a></div>
                <div class="clear"></div>
            </div><!-- /header -->
            <style>
                .icon-wrap {
                    display: inline-block;
                    padding: 0px;
                    width: 32%;
                    height: 80px;
                    text-align: center;
                }
                .icon-wrap > div {
                    /*position: absolute;*/
                    /*background-color: lightgray;*/
                    height: 70px;
                    width: 70px;
                    display: block;
                    border-radius: 10px/15px;
                    margin: 0 auto;
                    vertical-align: middle;
                    /*line-height: 40px;*/
                    background: rgb(247, 247, 247);
                    background: -moz-linear-gradient(top, rgba(247, 247, 247, 1) 0%, rgba(229, 229, 229, 1) 100%);
                    background: -webkit-linear-gradient(top, rgba(247, 247, 247, 1) 0%, rgba(229, 229, 229, 1) 100%);
                    background: linear-gradient(to bottom, rgba(247, 247, 247, 1) 0%, rgba(229, 229, 229, 1) 100%);
                    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#f7f7f7', endColorstr='#e5e5e5', GradientType=0);
                }
                .icon-wrap > div:before {
                    content: '';
                    display: inline-block;
                    /*position: relative;*/
                    z-index: -1;
                    height: 70px;
                    width: 70px;
                    left: 5px;
                    top: -5px;
                    background-color: lightgray;
                    border-radius: 10px/15px;
                    background: rgb(247, 247, 247);
                    background: -moz-linear-gradient(top, rgba(247, 247, 247, 1) 0%, rgba(229, 229, 229, 1) 100%);
                    background: -webkit-linear-gradient(top, rgba(247, 247, 247, 1) 0%, rgba(229, 229, 229, 1) 100%);
                    background: linear-gradient(to bottom, rgba(247, 247, 247, 1) 0%, rgba(229, 229, 229, 1) 100%);
                    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#f7f7f7', endColorstr='#e5e5e5', GradientType=0);
                }
                .icon-wrap > div > img {
                    position: relative;
                    width: 40px;
                    height: 40px;
                    top: -70px;
                    left: 15px;
                }
                .icon-wrap > .icon-label {
                    position: relative;
                    top: -25px;
                    margin: 0;
                }
                #countdown{
                    margin: 0 auto;
                    position: relative;
                    top: -120px;
                    height: 80px;
                    width: 80%;
                    text-align: center;
                    border-radius: 10px;
                    font-size: 20px;
                    vertical-align: middle;
                    padding-top: 0px;
                    line-height: 35px;
                    background-color: #f4787b;
                    color:black;
                    font-weight: bold;
                }
                #labelPengantin{
                    margin: 0 auto;
                    position: relative;
                    top: -40px;
                    height: 40px;
                    width: 100%;
                    text-align: center;
                    font-size: 15px;
                    vertical-align: middle;
                    line-height: 40px;
                    background-color: #e7e7e7;
                    color:black;
                    font-weight: bold;
                }

                .heart{
                    margin: 0 auto;
                    position: relative;
                    top: -150px;
                    width: 100px;
                    height: 90px;
                    text-align: center;
                    font-size: 15px;
                    vertical-align: middle;
                    line-height: 40px;
                }
                .heart:before,
                .heart:after{
                    position: absolute;
                    content: "";
                    left: 50px;
                    top: 0;
                    width: 50px;
                    height: 80px;
                    background: #fc2e5a;
                    -moz-border-radius: 50px 50px 0 0;
                    border-radius: 50px 50px 0 0;
                    -webkit-transform: rotate(-45deg);
                    -moz-transform: rotate(-45deg);
                    -ms-transform: rotate(-45deg);
                    -o-transform: rotate(-45deg);
                    transform: rotate(-45deg);
                    -webkit-transform-origin: 0 100%;
                    -moz-transform-origin: 0 100%;
                    -ms-transform-origin: 0 100%;
                    -o-transform-origin: 0 100%;
                    transform-origin: 0 100%;
                }
                .heart:after{
                    left: 0;
                    -webkit-transform: rotate(45deg);
                    -moz-transform: rotate(45deg);
                    -ms-transform: rotate(45deg);
                    -o-transform: rotate(45deg);
                    transform: rotate(45deg);
                    -webkit-transform-origin: 100% 100%;
                    -moz-transform-origin: 100% 100%;
                    -ms-transform-origin: 100% 100%;
                    -o-transform-origin: 100% 100%;
                    transform-origin :100% 100%;
                }
                .labelCountDown{
                    margin: 0 auto;
                    position: relative;
                    top: -90px;
                    text-align: center;
                    font-size: 15px;
                    vertical-align: middle;
                    line-height: 80px;
                    color:black;
                    font-weight: bold;
                }
                .form-control{
                    background: transparent !important;
                }
                table {
                    border-collapse: collapse;
                }

                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 5px;
                    text-align: left;
                }
                .form_input{
                    width: 100%;
                }
            </style>