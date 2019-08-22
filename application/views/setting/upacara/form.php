<?php
if (empty($upacara_tipe)) {
    $id = "";
    $nama = "";
    $form = "";
} else {
    foreach ($upacara_tipe as $val) {
        $id = $val->id;
        $nama = $val->nama_upacara;
        $form = $val->form;
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
            <a href="<?= base_url() ?>Setting/Upacara">Upacara</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?= base_url() ?>Setting/Upacara/simpan" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> Paket Upacara</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Paket Upacara</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="nama_upacara" id="nama_upacara" placeholder="Nama Paket Upacara" required="required" value="<?= $nama ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Form</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="form" id="form" placeholder="FORM" required="required" value="<?= $form ?>">
                                    </div>
                                </div>
                                <?php
                                if ($tipe == "edit") {
                                    ?>
                                    <table class="table">
                                        <tr>
                                            <td style="width:5%">
                                                <input type="hidden" name="id_upacara" id="id_upacara" value="<?= $id ?>">
                                                <input type="hidden" name="id_detail" id="id_detail" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" placeholder="Nama Kegiatan">
                                            </td>
                                            <td style="width:10%">
                                                <button type="button" class="btn btn-mini btn-primary" onclick="saveKegiatan()"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_kegiatan_upacara">
                                        <span id="conten_alert_kegiatan_upacara"></span>
                                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div id="kegiatan_upacara">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th style="width:12%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                                <?php
                                                $no = 1;
                                                foreach ($kegiatan as $val) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $val->nama_upacara ?></td>
                                                        <td>
                                                            <a href="<?= base_url() ?>Setting/Upacara/field?id=<?= $val->id ?>" class="btn btn-sm btn-success"><i class="fa fa-list"></i></a>
                                                            <a href="#" onclick="editField('<?= $val->id ?>')" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" onclick="deleteField('<?= $val->id ?>', this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?= base_url() ?>Setting/Upacara">
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
    function showAlert(tipe, message) {
        $("#alert_kegiatan_upacara").addClass(tipe);
        $("#conten_alert_kegiatan_upacara").html(message);
        $("#alert_kegiatan_upacara").show();
    }
    function hideAlert() {
        $("#alert_kegiatan_upacara").hide();
    }
    function saveKegiatan() {
        var baris = $("#table_body tr").length;
        var id = $("#id_detail").val();
        var id_upacara = $("#id_upacara").val();
        var nama_kegiatan = $("#nama_kegiatan").val();
        var valid = true;
        if (nama_kegiatan == "") {
            showAlert('warning', 'Nama Kegiatan di isi');
            $("#nama_kegiatan").focus();
            valid = valid && false;
        }

        if (valid) {
            hideAlert();
            $.ajax({
                url: "<?= base_url() ?>Setting/Upacara/saveKegiatan",
                type: "POST",
                data: "id=" + id + "&id_upacara=" + id_upacara + "&nama_kegiatan=" + nama_kegiatan,
                dataType: "JSON",
                success: function (data) {
                    if (data.resp_code == 200) {
                        showAlert('success', "Berhasil menambah/mengedit field");
                        $("#kegiatan_upacara").load(location.href + " #kegiatan_upacara");
                        $("#id").val('');
                        $("#nama_kegiatan").val('');
                    }
                }
            });
        }
    }

    function editField(id) {
        $.ajax({
            url: "<?= base_url() ?>Setting/Upacara/getKegiatan",
            type: "GET",
            data: "id=" + id,
            dataType: "JSON",
            success: function (data) {
                if (data.resp_code == 200) {
                    $("#id_detail").val(data.data.id);
                    $("#nama_kegiatan").val(data.data.nama_upacara);
                    $("#nama_kegiatan").focus();
                } else {
                    showAlert('warning', 'Data tidak di temukan');
                }
            }
        });
    }

    function deleteField(id, e) {
        confirmModal('Delete Field', 'Apakah anda yakin akan menghapus kegiatan ini', '<?= base_url() ?>Setting/Upacara/deleteField?id=' + id);
//        $(e).parent().parent().remove();
    }


    $(function () {
        hideAlert();
    });
</script>