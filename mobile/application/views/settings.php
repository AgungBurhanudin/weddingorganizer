
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <!-- <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">
          <a href="assets/#">Admin</a>
        </li> -->
        <li class="breadcrumb-item active">Settings</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">
                <div class="col-md-3">
                    <a href="<?= base_url() ?>Setting/Acara">
                        <button type="button" class="btn btn-lg btn-primary col-lg-12" >
                            <i class="fa fa-anchor"></i><br>
                            Setting Acara<br>&nbsp;</button>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url() ?>Setting/Upacara">
                        <button type="button" class="btn btn-lg btn-success col-lg-12" >
                            <i class="fa fa-archive"></i><br>
                            Setting Upacara<br>&nbsp;</button>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url() ?>Setting/Panitia">
                        <button type="button" class="btn btn-lg btn-warning col-lg-12" >
                            <i class="fa fa-users"></i><br>
                            Setting Panitia<br>&nbsp;</button>
                    </a>
                </div>
                
                <div class="col-md-3">
                    <a href="<?= base_url() ?>Setting/Tambahan">
                        <button type="button" class="btn btn-lg btn-dark col-lg-12" >
                            <i class="fa fa-bitbucket"></i><br>
                            Setting Paket Tambahan / Lampiran</button>
                    </a>
                </div>
            </div><br>
            <div class="row">
                <!--<div style="clear: both"></div><hr>-->
                <div class="col-md-3">
                    <a href="<?= base_url() ?>Settings/dokumen">
                        <button type="button" class="btn btn-lg btn-danger col-lg-12" >
                            <i class="fa fa-book"></i><br>
                            Template Dokumen Cetak<br>&nbsp;</button>
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>
</div>
