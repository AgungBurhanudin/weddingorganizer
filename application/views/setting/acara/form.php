<?php
if (empty($acara_tipe)) {
    $id = "";
    $nama = "";
} else {
    foreach ($acara_tipe as $val) {
        $id = $val->id;
        $nama = $val->nama_acara;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Settings">Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Acara</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?= base_url() ?>Setting/Acara/simpan" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> Paket Acara</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Paket Acara</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="nama_acara" id="nama_acara" placeholder="Nama Paket Acara" required="required" value="<?= $nama ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Apakah menggunakan panitia?</label>
                                    <div class="col-md-9">
                                        <label>
                                            <input type="checkbox" onclick="usePanitia()" name="use_panitia" id="use_panitia"  value="1"> Ya
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Daftar Panitia</label>
                                    <div class="col-md-9">
                                        <select input class="form-control" name="id_panitia_tipe" id="id_panitia_tipe" disabled="disabled">
                                            <option value="">-- Pilih Daftar Panitia -- </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Keterangan</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="keterangan" id="keterangan" placeholder="Keterangan" required="required" value="<?= $nama ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?= base_url() ?>Setting/Acara">
                                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-back"></i> Cancel</button>
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>
<script>
    function usePanitia() {
        // Get the checkbox
        var checkBox = document.getElementById("use_panitia");
        // Get the output text
        var text = $("#id_panitia_tipe");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true) {
            text.removeAttr("disabled");
        } else {
            text.attr("disabled","disabled");
        }
    }
</script>