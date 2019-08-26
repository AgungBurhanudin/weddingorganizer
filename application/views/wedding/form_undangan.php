<h2>Daftar Undangan</h2>
<hr>
<a href="#" data-toggle="modal" data-target="#myModal">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah Undangan</button>
</a>
<a href="#" target="_blank" style="float: right">
    <button type="button" class="btn btn-mini btn-success"><i class="fa fa-print"></i> Cetak Barcode Undangan</button>
</a>
<br>
<br>
<table class="table table-responsive-sm table-hover table-outline mb-0">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nama Undangan</th>
            <th>Alamat</th>
            <th>Tipe Undangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($undangan)) {
            foreach ($undangan as $val) {
                ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $val->nama ?></td>
            <td><?= $val->alamat ?></td>
            <td><?= $val->tipe_undangan ?></td>
            <td>
                <a href="<?= base_url() ?>Wedding/undangan/edit?id=<?= $val->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                <a href="<?= base_url() ?>Wedding/undangan/delete?id=<?= $val->id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
            </td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='7'>Data Undangan Masih Kosong</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tamu Undangan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" name="undangan" id="undangan" method="post">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">Nama Lengkap</label>
                        <div class="col-md-9">
                            <input name="nama_lengkap" id="nama_lengkap" type="text" required="required" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Alamat </label>
                        <div class="col-md-9">
                            <input name="alamat_undangan" id="alamat_undangan" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Tipe Undangan </label>
                        <div class="col-md-9">
                            <select class="form-control" name="tipe_undangan" id="tipe_undangan">
                                <option value="">-- Pilih Tipe Undangan --</option>
                                <option value="Teman">Teman</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="VIP">VIP</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit" onclick="simpanUndangan()">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>

<script>
    function simpanUndangan() {
        var formData = new FormData($("#undangan")[0]);
        $('#undangan').validate({
            rules: {
                nama: {
                    required: true,
                    minlength: 2
                },
            },
            messages: {
                nama: {
                    required: "Please enter a Nama Undangan",
                    minlength: "Nama Undangan minimal 2 karakter"
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Wedding/undangan/add',
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.code == "200") {
                            swal("success", "Berhasil menambah undangan!");
                            $("#myModal").modal('hide');
                        } else {
                            swal("warning", "Gagal menambah undangan!");
                        }
                    }
                });
            }
        });
    }
</script>