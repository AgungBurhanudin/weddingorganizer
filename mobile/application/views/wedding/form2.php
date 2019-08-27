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
            <a href="<?= base_url() ?>Wedding">Data Wedding</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div id="ui-view"><div>
                <div class="animated fadeIn">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Detail Data Wedding</div>
                    <div class="email-app">
                        <nav>
                            <center>
                                <input type="hidden" name="id_wedding" id="id_wedding" value="<?= $id_wedding ?>">
                                <div class="avatar">
                                    <img class="img-avatar" src="<?= base_url() ?>files/images/<?= $pria->photo != "" ? $pria->photo : "user.jpg" ?>" alt="<?= $pria->nama_lengkap ?>">
                                </div>
                                <div class="avatar">
                                    <img class="img-avatar" src="<?= base_url() ?>files/images/<?= $wanita->photo != "" ? $wanita->photo : "user.jpg" ?>" alt="<?= $wanita->nama_lengkap ?>">
                                </div>
                                <br><br>
                                <b id="countdown">-- </b><br>
                                <b></b>
                            </center>
                            <hr>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link active" data-toggle="tab" href="#wedding" role="tab" aria-controls="wedding">Data Wedding</a>
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
                                    <a class="nav-link" data-toggle="tab" href="#acara" role="tab" aria-controls="acara">Paket Acara</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#upacara" role="tab" aria-controls="upacara">Paket Upacara</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#panitia" role="tab" aria-controls="panitia">Paket Panitia</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#tambahan" role="tab" aria-controls="tambahan">Paket Tambahan</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#log" role="tab" aria-controls="log">Log Aktivitas</a>
                                </li>
                            </ul>
                            <br>
                            <div>
                                <a href="<?= base_url() ?>Wedding/cetak?id=<?= $id_wedding ?>" target="_blank">
                                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Cetak Buku Wedding</button><br><br>
                                </a>
                                <button type="button" class="btn btn-sm btn-dark"><i class="fa fa-lock"></i> Nonaktifkan User</button>
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
                                <div class="tab-pane" id="acara" role="tabpanel">
                                    <?php $this->load->view('wedding/form_acara'); ?>
                                </div>
                                <div class="tab-pane" id="upacara" role="tabpanel">
                                    <?php $this->load->view('wedding/form_upacara'); ?>
                                </div>
                                <div class="tab-pane" id="panitia" role="tabpanel">
                                    <?php $this->load->view('wedding/form_panitia'); ?>
                                </div>
                                <div class="tab-pane" id="tambahan" role="tabpanel">
                                    <?php $this->load->view('wedding/form_tambahan'); ?>
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

// Set the date we're counting down to
    var countDownDate = new Date("<?= $wedding->tanggal ?> <?= $wedding->waktu ?>").getTime();

// Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $("#countdown").html(days + " Hari " + hours + " Jam ");
//                + minutes + " Menit " + seconds + " Detik ");

            if (distance < 0) {
                clearInterval(x);
                $("#countdown").html("Waktu Pengisian Data Sudah Habis");
                $("#detail_wedding *").attr("disabled", "disabled").off('click');
            }
        }, 1000);
        $(function () {
//        $('#tabAcara').scrollingTabs();
//        $('#tabPanitia').scrollingTabs();
//        $('#tabTambahan').scrollingTabs();
//        $('#tabUpacara').scrollingTabs();
        });
        $(".id_wedding").val('<?= $id_wedding ?>');
//    $("#detail_wedding *").attr("disabled", "disabled").off('click');


        function saveupacara(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?= base_url() ?>Wedding/upacara/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else if (type == "checkbox") {
                var val = "";
                if ($("#" + value).is(":checked")) {
                    val = $("#" + value).val();
                }
                dataForm = "id=" + id + "&value=" + val + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?= base_url() ?>Wedding/upacara/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?= base_url() ?>Wedding/upacara/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }

        function savepanitia(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?= base_url() ?>Wedding/panitia/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?= base_url() ?>Wedding/panitia/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }

        function savetambahan(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?= base_url() ?>Wedding/tambahan/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?= base_url() ?>Wedding/tambahan/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }
</script>