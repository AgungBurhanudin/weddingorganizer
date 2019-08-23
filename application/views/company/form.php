<?php
if (empty($data_company)) {
    $id = "";
    $nama = "";
    $alamat = "";
    $notelp = "";
    $email = "";
} else {
    foreach ($data_company as $val) {
        $id = $val->id;
        $nama = $val->nama;
        $alamat = $val->alamat;
        $notelp = $val->notelp;
        $email = $val->email;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">
            <a href="#">Company</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?=base_url()?>Company/save" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> Company</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Perusahaan</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="nama" id="nama" placeholder="Nama Perusahaan" required="required" value="<?= $nama ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Alamat </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="alamat" id="alamat" placeholder="Alamat" required="required"  value="<?= $alamat ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">No Telp </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="notelp" id="notelp" placeholder="No Telp" required="required"  value="<?= $notelp ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Email </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="email" id="email" placeholder="Email" required="required"  value="<?= $email ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="file-input">Logo</label>
                                    <div class="col-md-9">
                                        <input id="file-input" type="file" name="userfile">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?=base_url()?>Company">
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