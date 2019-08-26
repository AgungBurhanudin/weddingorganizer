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
        <link rel="icon" type="image/ico" href="<?= base_url() ?>assets/icon.jpg" sizes="any" />
        <link href="<?= base_url() ?>assets/vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
        <!-- Main styles for this application-->
        <link href="<?= base_url() ?>assets/css/style.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
        <!-- Include SmartWizard CSS -->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard.min.css" rel="stylesheet" type="text/css" />-->

        <!-- Optional SmartWizard theme -->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard_theme_circles.min.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard_theme_dots.min.css" rel="stylesheet" type="text/css" />-->
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>

        <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/sweet/min/jquery.sweet-modal.min.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.scrolling-tabs.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/datatable.min.css" />
<!--        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />-->

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
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <!-- Wedding Organizer and necessary plugins-->
        <script src="<?= base_url() ?>assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/vendors/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?= base_url() ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/vendors/pace-progress/pace.min.js"></script>
        <script src="<?= base_url() ?>assets/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="<?= base_url() ?>assets/vendors/@coreui/coreui/dist/js/coreui.min.js"></script>
        <!-- Plugins and scripts required by this view-->
<!--        <script src="<?= base_url() ?>assets/vendors/chart.js/dist/Chart.min.js"></script>-->
        <script src="<?= base_url() ?>assets/vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
        <!--<script src="<?= base_url() ?>assets/js/main.js"></script>-->
        <script src="<?= base_url() ?>assets/vendors/sweet/min/jquery.sweet-modal.min.js"></script>
        <!--<script type="text/javascript" src="<?= base_url() ?>assets/smartWizard/js/jquery.smartWizard.min.js"></script>-->
        
        <script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
        <script src="<?= base_url() ?>assets/js/select2.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.scrolling-tabs.js"></script>
        <script src="<?= base_url() ?>assets/js/datatable.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>-->
        <script>
            //Image preview
            $(function () {
                $(".table-datatable").DataTable();
                
                $(document).on("change", ".uploadFile", function ()
                {
                    var uploadFile = $(this);
                    var files = !!this.files ? this.files : [];
                    if (!files.length || !window.FileReader)
                        return; // no file selected, or no FileReader support

                    if (/^image/.test(files[0].type)) { // only image file
                        var reader = new FileReader(); // instance of the FileReader
                        reader.readAsDataURL(files[0]); // read the local file

                        reader.onloadend = function () { // set image data as background of div
                            //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                            uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                        }
                    }

                });
            });

            function swal(tipe, content) {
                var icon = null;
                if (tipe == "success") {
                    icon = $.sweetModal.ICON_SUCCESS;
                } else if (tipe == "warning") {
                    icon = $.sweetModal.ICON_WARNING;
                }
                $.sweetModal({
                    content: content,
                    icon: icon
                });
            }
        </script>
        <style>
            .red{
                color:red;
                font-style: italic;
                font-size: 12px;
            }
            .msg_form{
                font-size: 10px;
                color: red;
                font-style: italic;
            }

            .stepwizard-step p {
                margin-top: 0px;
                color:#666;
            }
            .stepwizard-row {
                display: table-row;
            }
            .stepwizard {
                display: table;
                width: 100%;
                position: relative;
            }
            .stepwizard-step button[disabled] {
                /*opacity: 1 !important;
                filter: alpha(opacity=100) !important;*/
            }
            .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
                opacity:1 !important;
                color:#bbb;
            }
            .stepwizard-row:before {
                top: 14px;
                bottom: 0;
                position: absolute;
                content:" ";
                width: 100%;
                height: 1px;
                background-color: #ccc;
                z-index: 0;
            }
            .stepwizard-step {
                display: table-cell;
                text-align: center;
                position: relative;
                width: 20%;
            }
            .btn-circle {
                width: 30px;
                height: 30px;
                text-align: center;
                padding: 6px 0;
                font-size: 12px;
                line-height: 1.428571429;
                border-radius: 15px !important;
                -moz-border-radius: 15px !important;
            }
            /*image preview*/

            .imagePreview {
                width: 100%;
                height: 180px;
                background-position: center center;
                background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
                background-color:#fff;
                background-size: contain;
                background-repeat:no-repeat;
                display: inline-block;
                /*box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);*/
            }
            .btn-upload
            {
                display:block;
                border-radius:5px;
                box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
                margin-top:-5px;
            }
            .imgUp
            {
                margin-bottom:30px;
            }

            /*Form Pendaftaran Wedding*/
            .active_form{
                display: block;
            }
            .hide{
                display: none;
            }
            
            
            label .error{
                font-size: 9px;
                text-decoration: line-through;
                color: red;
                
            }
            .error{
                color: red;
                border-color: red;
            }

        </style>