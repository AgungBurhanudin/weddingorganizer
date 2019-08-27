
<div role="main" class="ui-content">
    <div class="pages_maincontent">
        <h2 class="page_title">Vendor</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>
        <div class="page_content"> 
            <form class="form-horizontal" action="<?= base_url() ?>Dashboard/saveVendor" id="formVendor" method="post">
                <input type="hidden" class="id_wedding" name="id_wedding" value="<?= $id_wedding ?>">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Kategori Vendor </label>
                    <div class="col-md-9">
                        <select class="form_input" data-role="none" name="kategori_vendor" id="kategori_vendor" onchange="getVendor(this.value)" style="width: 100%; height: 40px">
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
                        <select class="form_input" data-role="none" name="vendor" id="vendorcombobox" onchange=getVendor(this.value)">
                            <option value=""><?php foreach ($vendor as $v) { ?>
                                <option value="<?= $v->id ?>"><?= $v->vendor ?></option> <?php } ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-email">Nama Vendor</label>
                    <div class="col-md-9">
                        <input name="nama_vendor" id="nama_vendor" type="text" required="required" class="form_input" data-role="none" placeholder="" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Alamat </label>
                    <div class="col-md-9">
                        <input name="alamat" id="alamat" type="text" required="required" class="form_input" data-role="none" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">CP </label>
                    <div class="col-md-9">
                        <input name="cp" id="cp" type="text" required="required" class="form_input" data-role="none" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">No Telepone</label>
                    <div class="col-md-9">
                        <input name="nohp" id="nohp" type="text" required="required" class="form_input" data-role="none" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Biaya</label>
                    <div class="col-md-9">
                        <input name="biaya" id="biaya" type="number" required="required" class="form_input" data-role="none" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Di Bayar oleh </label>
                    <div class="col-md-9">
                        <select class="form_input" data-role="none" name="bayar_oleh" id="bayar_oleh">
                            <option value="">-- Pilih Pembayaran --</option>
                            <option value="wo">Mahkota / Tiara</option>
                            <option value="sendiri">Sendiri</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"></label>
                    <div class="col-md-9">                        
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

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