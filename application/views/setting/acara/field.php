
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Settings">Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Setting/Acara">Acara</a>
        </li>
        <li class="breadcrumb-item active">Field</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Data Field Paket Acara <?= $acara_tipe->nama_acara ?>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td style="width:5%">
                                        <input type="hidden" name="id_acara" id="id_acara" value="<?= $acara_tipe->id ?>">
                                        <input type="hidden" name="id" id="id" value="">
                                    </td>
                                    <td style="width:20%">
                                        <input type="text" name="label" id="label" class="form-control" placeholder="Label">
                                    </td>
                                    <td style="width:20%">
                                        <input type="text" name="nama_field" id="nama_field" class="form-control" placeholder="Nama Field">
                                    </td>
                                    <td style="width:15%">
                                        <select name="jenis_field" id="jenis_field" class="form-control">
                                            <option value="">Jenis Field</option>
                                            <option value="text">Textbox</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="angka">Angka</option>
                                            <option value="tanggal">Tanggal</option>
                                            <option value="combobox">Combobox</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="addabletext">Textbox Add</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="deskripsi_field" id="deskripsi_field" class="form-control" placeholder="Deskripsi Field">
                                    </td>
                                    <td style="width:10%">
                                        <button type="button" class="btn btn-mini btn-primary" onclick="saveField()"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                            </table>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_field">
                                <span id="conten_alert_field"></span>
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div id="content_acara">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">No</th>
                                            <th style="width:20%">Label</th>
                                            <th style="width:20%">Nama Field</th>
                                            <th style="width:15%">Jenis Field</th>
                                            <th>Deskripsi Field</th>
                                            <th style="width:10%">Urutan</th>
                                            <th style="width:10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                        <?php
                                        $no = 1;
                                        foreach ($acara_field as $val) {
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $val->nama_label ?></td>
                                                <td><?= $val->nama_field ?></td>
                                                <td><?= $val->type ?></td>
                                                <td><?= $val->ukuran ?></td>
                                                <td>
                                                    <input onfocusout="saveUrutan('<?= $val->id ?>')" type="number" id="urutan_<?= $val->id ?>" name="urutan_<?= $val->id ?>" value="<?= $val->urutan ?>" class="form-control" style="width: 80px">
                                                </td>
                                                <td>
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
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>
<script>
    function showAlert(tipe, message) {
        $("#alert_field").addClass(tipe);
        $("#conten_alert_field").html(message);
        $("#alert_field").show();
    }
    function hideAlert() {
        $("#alert_field").hide();
    }
    function saveField() {
        var baris = $("#table_body tr").length;
        var id = $("#id").val();
        var id_acara = $("#id_acara").val();
        var label = $("#label").val();
        var nama_field = $("#nama_field").val();
        var jenis_field = $("#jenis_field").val();
        var deskripsi_field = $("#deskripsi_field").val();
        var valid = true;
        if (label == "") {
            showAlert('warning', 'Label Harus di isi');
            $("#label").focus();
            valid = valid && false;
        } else if (nama_field == "") {
            showAlert('warning', 'Nama Field Harus di isi');
            $("#nama_field").focus();
            valid = valid && false;
        } else if (jenis_field == "") {
            showAlert('warning', 'Jenis Field Harus di isi');
            $("#jenis_field").focus();
            valid = valid && false;
        }

        if (valid) {
            hideAlert();
            $.ajax({
                url: "<?= base_url() ?>Setting/Acara/saveField",
                type: "POST",
                data: "id=" + id + "&id_acara=" + id_acara + "&nama_label=" + label + "&nama_field=" + nama_field + "&jenis_field=" + jenis_field + "&deskripsi_field=" + deskripsi_field,
                dataType: "JSON",
                success: function (data) {
                    if (data.resp_code == 200) {
                        showAlert('success', "Berhasil menambah/mengedit field");
                        $("#content_acara").load(location.href + " #content_acara");
                        $("#id").val('');
                        $("#nama_field").val('');
                        $("#label").val('');
                        $("#jenis_field").val('');
                        $("#deskripsi_field").val('');
//                        baris = baris + 1;
//                        var table = "<tr><td>" + baris + "</td><td>" + label + "</td><td>" + nama_field + "</td><td>" + jenis_field + "</td><td>" + deskripsi_field + "</td><td></td></tr>";
//                        $("#table_body").append(table);
                    }
                }
            });
        }
    }

    function editField(id) {
        $.ajax({
            url: "<?= base_url() ?>Setting/Acara/getField",
            type: "GET",
            data: "id=" + id,
            dataType: "JSON",
            success: function (data) {
                if (data.resp_code == 200) {
                    $("#id").val(data.data.id);
                    $("#nama_field").val(data.data.nama_field);
                    $("#label").val(data.data.nama_label);
                    $("#jenis_field").val(data.data.type);
                    $("#deskripsi_field").val(data.data.ukuran);
                    $("#label").focus();
                } else {
                    showAlert('warning', 'Data tidak di temukan');
                }
            }
        });
    }

    function deleteField(id, e) {
        confirmModal('Delete Field', 'Apakah anda yakin akan menghapus field ini', '<?= base_url() ?>Setting/Acara/deleteField?id=' + id);
//        $(e).parent().parent().remove();
    }

    function saveUrutan(id) {
        var urutan = $("#urutan_" + id).val();
        $.ajax({
            url: "<?= base_url() ?>Setting/Acara/saveUrutan",
            type: "POST",
            data: "id=" + id + "&urutan=" + urutan,
            dataType: "JSON",
            success: function (data) {
                $("#content_acara").load(location.href + " #content_acara");
//                $("#urutan_" + id).focus();
            }
        });
    }

    $(function () {
        hideAlert();
//        var flasdata_error = "<?= $this->session->flashdata('error') ?>";
//        var flasdata_ok = "<?= $this->session->flashdata('success') ?>";
//        if (flasdata_error != "") {
//            alert(flasdata);
//            showAlert('warning', flasdata);
//        } else if (flasdata_ok != "") {
//            alert(flasdata);
//            showAlert('success', flasdata);
//        } else {
//            hideAlert();
//        }
    });
</script>