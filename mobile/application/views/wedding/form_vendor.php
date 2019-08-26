<h2>Daftar Vendor</h2>
<hr>
<a href="#" data-toggle="modal" data-target="#vendorModal">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah Vendor</button>
</a>
<br>
<br>
<table class="table table-responsive-sm table-hover table-outline mb-0">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nama Vendor</th>
            <th>CP</th>
            <th>Phone</th>
            <th>Tipe Vendor</th>
            <th>Biaya</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($vendor)) {
            foreach ($vendor as $val) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $val->nama_vendor ?></td>
                    <td><?= $val->cp ?></td>
                    <td><?= $val->nohp_cp ?></td>
                    <td><?= $val->kategori_nama ?></td>
                    <td><?= $val->biaya ?></td>
                    <td>
                        <a href="<?= base_url() ?>Wedding/vendor/edit?id=<?= $val->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="<?= base_url() ?>Wedding/vendor/delete?id=<?= $val->id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>Data Vendor Masih Kosong</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Vendor</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" id="formVendor" method="post">
                    <input type="hidden" class="id_wedding" name="id_wedding">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kategori Vendor </label>
                        <div class="col-md-9">
                            <select class="form-control" name="kategori_vendor" id="kategori_vendor" onchange="getVendor(this.value)" style="width: 100%; height: 40px">
                                <option value="">-- Pilih Tipe Vendor --</option>
                                <?php
                                foreach ($kategori_vendor as $kv) {
                                    ?>
                                    <option value="<?= $kv->id ?>"><?= $kv->nama_kategori ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Vendor Yang Tersedia </label>
                        <div class="col-md-9">
                            <select class="form-control" name="vendor" id="vendorcombobox" onchange=getVendor(this.value)">
                                <option value=""><?php foreach ($vendor as $v) { ?>
                                    <option value="<?= $v->id ?>"><?= $v->vendor ?></option> <?php } ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">Nama Vendor</label>
                        <div class="col-md-9">
                            <input name="nama_vendor" id="nama_vendor" type="text" required="required" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Alamat </label>
                        <div class="col-md-9">
                            <input name="alamat" id="alamat" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">CP </label>
                        <div class="col-md-9">
                            <input name="cp" id="cp" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Telepone</label>
                        <div class="col-md-9">
                            <input name="nohp" id="nohp" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Biaya</label>
                        <div class="col-md-9">
                            <input name="biaya" id="biaya" type="number" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Di Bayar oleh </label>
                        <div class="col-md-9">
                            <select class="form-control" name="bayar_oleh" id="bayar_oleh">
                                <option value="">-- Pilih Pembayaran --</option>
                                <option value="wo">Mahkota / Tiara</option>
                                <option value="sendiri">Sendiri</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit" onclick="simpanVendor()">Simpan</button>
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
    $(function () {
        $("#kategori_vendor").select2();
    });

    function getVendor(kategori) {
        $.ajax({
            url: "<?= base_url() ?>Combobox/vendor?kategori=" + kategori,
            success: function (data) {
                $("#vendorcombobox").html(data);
            }
        });
    }

    function simpanVendor() {
        var formData = new FormData($("#formVendor")[0]);
        $('#formVendor').validate({
            rules: {
                nama_vendor: {
                    required: true,
                    minlength: 2
                },
                bayar_oleh: "required"
            },
            messages: {
                nama_vendor: {
                    required: "Please enter a Nama Vendor",
                    minlength: "Nama Vendor minimal 2 karakter"
                },
                bayar_oleh: "Pilih Pembayaran"
            },
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Wedding/vendor/add',
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            swal("success", "Berhasil menambah vendor!");
                            $("#vendorModal").modal('hide');
                        } else {
                            swal("warning", "Gagal menambah vendor!");
                        }
                    }
                });
            }
        });
    }
</script>