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
                    <td><?= $val->biayan ?></td>
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
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Tipe Vendor </label>
                        <div class="col-md-9">
                            <select class="form-control" name="tipe_undangan" id="tipe_undangan">
                                <option value="">-- Pilih Tipe Vendor --</option>
                                <option value="Teman">Teman</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="VIP">VIP</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Vendor Yang Tersedia </label>
                        <div class="col-md-9">
                            <select class="form-control" name="tipe_undangan" id="tipe_undangan">
                                <option value="">-- Pilih Tipe Vendor --</option>
                                <option value="Teman">Teman</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="VIP">VIP</option>
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
                        <label class="col-md-3 col-form-label" for="hf-password">Alamat </label>
                        <div class="col-md-9">
                            <input name="alamat_undangan" id="alamat_undangan" type="text" required="required" class="form-control"  />                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">CP </label>
                        <div class="col-md-9">
                            <input name="cp" id="cp" type="text" required="required" class="form-control"  />                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">No Telepone</label>
                        <div class="col-md-9">
                            <input name="nohp" id="nohp" type="text" required="required" class="form-control"  />                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Biaya</label>
                        <div class="col-md-9">
                            <input name="biaya" id="biaya" type="number" required="required" class="form-control"  />                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Di Bayar oleh </label>
                        <div class="col-md-9">
                            <select class="form-control" name="bayar_oleh" id="bayar_oleh">
                                <option value="">-- Pilih Pembayaran --</option>
                                <option value="wo">Mahkota / Tiara</option>
                                <option value="sendiri">Sendiri</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="button">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>