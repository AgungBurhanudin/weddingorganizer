<style>
    .nav-item{
        detail-wedding: 0.1px solid gray;
    }
</style>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">The Wedding</li>
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Wedding">Wedding</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div id="ui-view"><div>
                <div class="animated fadeIn">
                    <div class="email-app">
                        <nav>
                            <center>
                                <div class="avatar">
                                    <img class="img-avatar" src="<?= base_url() ?>assets/img/avatars/1.jpg" alt="admin@bootstrapmaster.com">                              
                                </div>
                                <div class="avatar">
                                    <img class="img-avatar" src="<?= base_url() ?>assets/img/avatars/1.jpg" alt="admin@bootstrapmaster.com">                              
                                </div>
                                <br><br>
                                <b>2 Hari 23 Jam </b><br>
                                <b>Waktu Pengisian Data Sudah Habis</b>
                            </center>
                            <hr>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#wedding" role="tab" aria-controls="wedding">Data Wedding</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#pria" role="tab" aria-controls="pria">Catin Pria</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#wanita" role="tab" aria-controls="wanita">Catin Wanita</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#vendor" role="tab" aria-controls="vendor">Daftar Vendor</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#undangan" role="tab" aria-controls="undangan">Daftar Undangan</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#jadwal" role="tab" aria-controls="jadwal">Jadwal Meeting</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#log" role="tab" aria-controls="log">Log Aktivitas</a>
                                </li>
                            </ul>
                            <br>
                            <div>
                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Cetak Buku Wedding</button>
                            </div>
                        </nav>
                        <main>
                            <div class="tab-content" style="border: 0;" id="detail_wedding">
                                <div class="tab-pane active" id="wedding" role="tabpanel">
                                    <?php $this->load->view('wedding/form_wedding'); ?>
                                </div>
                                <div class="tab-pane" id="pria" role="tabpanel">
                                    <?php $this->load->view('wedding/form_pria'); ?>
                                </div>
                                <div class="tab-pane" id="wanita" role="tabpanel">
                                    <?php $this->load->view('wedding/form_wanita'); ?>
                                </div>
                                <div class="tab-pane" id="vendor" role="tabpanel">
                                    <?php $this->load->view('wedding/form_vendor'); ?>
                                </div>
                                <div class="tab-pane" id="undangan" role="tabpanel">
                                    <?php $this->load->view('wedding/form_undangan'); ?>
                                </div>
                                <div class="tab-pane" id="jadwal" role="tabpanel">
                                    <?php $this->load->view('wedding/jadwal_meeting'); ?>
                                </div>
                                <div class="tab-pane" id="log" role="tabpanel">
                                    <?php $this->load->view('wedding/form_log'); ?>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<script>
//    $("#detail_wedding *").attr("disabled", "disabled").off('click');
</script>