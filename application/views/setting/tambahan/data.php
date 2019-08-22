
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Settings">Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Tambahan / Lampiran</a>
        </li>
        <li class="breadcrumb-item active">Data</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">

                    <a href="<?= base_url() ?>Setting/Tambahan/add">
                        <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah Paket Tambahan / Lampiran</button>
                    </a>
                    <br><br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Data Paket Tambahan / Lampiran</div>
                        <div class="card-body">

                            <div class="col-md-6">
                                <form class="form-horizontal" action="<?= base_url() ?>Setting/Tambahan" method="get">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label" for="text-input">Nama Paket Acara</label>
                                        <div class="col-md-5">
                                            <input class="form-control" type="text" name="nama_tambahan_paket" id="nama_tambahan_paket" placeholder="Nama Paket Tambahan / Lampiran" value="<?= isset($key['nama_tambahan_paket']) ? $key['nama_tambahan_paket'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row " style="text-align:center">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit" style="margin : 0 auto">
                                                <i class="fa fa-search"></i> Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:30px">No</th>
                                        <th>Nama Paket Tambahan / Lampiran</th>
                                        <!--<th style="width:80px">Status</th>-->
                                        <th style="width:180px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tambahan_tipe as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $val->nama_tambahan_paket ?></td>
<!--                                            <td>
                                                <label class="switch switch-label switch-pill switch-success">
                                                    <input class="switch-input" type="checkbox" checked="">
                                                    <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                                                </label>
                                            </td>-->
                                            <td>
                                                <a href="<?= base_url() ?>Setting/Tambahan/field?id=<?= $val->id ?>" class="btn btn-sm btn-success"><i class="fa fa-list"></i></a>
                                                <a href="<?= base_url() ?>Setting/Tambahan/edit?id=<?= $val->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url() ?>Setting/Tambahan/delete?id=<?= $val->id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <i>Keterangan : </i><br>
                            <a href="#" class="btn btn-sm btn-success"><i class="fa fa-list"></i></a> Untuk mengedit field inputan didalam paket<br>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a> Untuk mengedit nama paket<br>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> Untuk menghapus data

                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>
