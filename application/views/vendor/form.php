<?php
if (empty($data_vendor)) {
    $id = "";
    $kategori = "";
    $company = "";
    $vendor = "";
    $cp = "";
    $nohp_cp = "";
    $keterangan = "";
} else {
    foreach ($data_vendor as $val) {
        $id = $val->id;
        $kategori = $val->id_kategori;
        $company = $val->id_company;
        $vendor = $val->vendor;
        $cp = $val->cp;
        $nohp_cp = $val->nohp_cp;
        $keterangan = $val->keterangan;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">
            <a href="#">Vendor</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?= base_url() ?>Vendor/save" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> Vendor</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Perusahaan</label>
                                    <div class="col-md-9">
                                        <select name="company" id="company" class="form-control">
                                            <option value=""> -- Pilih Perusahaan --</option>
                                            <?php
                                            foreach ($data_company as $val) {
                                                $select = ($company == $val->id) ? "selected" : "";
                                                ?>
                                                <option <?= $select ?> value="<?= $val->id ?>"><?= $val->nama ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Kategori Vendor </label>
                                    <div class="col-md-9">
                                        
                                        <select name="kategori" id="kategori" class="form-control">
                                            <option value=""> -- Pilih Kategori Vendor --</option>
                                            <?php
                                            foreach ($data_kategori as $val) {
                                                $select = ($kategori == $val->id) ? "selected" : "";
                                                ?>
                                                <option <?= $select ?> value="<?= $val->id ?>"><?= $val->nama_kategori ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Vendor </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="vendor" id="vendor" placeholder="Nama Vendor" required="required"  value="<?= $vendor ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Contact Person (CP) </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="cp" id="cp" placeholder="Contact Person" required="required"  value="<?= $cp ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">No Hp Contact Person (CP) </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="nohp_cp" id="nohp_cp" placeholder="No HP CP" required="required"  value="<?= $nohp_cp ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Keterangan</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="keterangan" id="keterangan" placeholder="No HP CP" required="required"  value="<?= $keterangan ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?= base_url() ?>Vendor">
                                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-back"></i> Cancel</button>
                                </a>
                            </div>
                        </div>
                </div>
                </form>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>