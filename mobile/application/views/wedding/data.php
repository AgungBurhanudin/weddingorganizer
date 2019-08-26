<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">The Wedding</li>
        <li class="breadcrumb-item active">
            <a href="<?= base_url() ?>Wedding">Data Wedding</a>
        </li>
        <!--<li class="breadcrumb-item active">Data</li>-->
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">

                    <a href="<?= base_url() ?>Wedding/add">
                        <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> <i class="fa fa-users"></i> Tambah Wedding</button>
                    </a>
                    <br><br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Data Wedding</div>
                        <div class="card-body">

                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">
                                            <i class="icon-people"></i>
                                        </th>
                                        <th>Pengantin</th>
                                        <th>CP</th>
                                        <th>Alamat</th>
                                        <th>Waktu Pernikahan</th>
                                        <th>Aktivitas Terakhir</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($wedding)) {
                                        echo "<tr><td colspan='7'>Data Wedding kosong</td></tr>";
                                    } else {
                                        foreach ($wedding as $d) {
                                            ?>
                                            <tr>
                                                <td class="text-center" nowrap="nowarap">
                                                    <div class="avatar">
                                                        <img class="img-avatar" src="<?= base_url() ?>files/images/<?= $d->foto_pria ?>" alt="<?= $d->nama_pria ?>">
                                                    </div>
                                                    <div class="avatar">
                                                        <img class="img-avatar" src="<?= base_url() ?>files/images/<?= $d->foto_wanita != "" ? $d->foto_wanita : "user.jpg" ?>" alt="<?= $d->nama_wanita ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><?= $d->nama_pria ?> & <?= $d->nama_wanita ?></div>
                                                    <div class="small text-muted">
                                                        Registered: <?= $d->registration_date != "" ? DateToIndo($d->registration_date) : ""; ?></div>
                                                </td>
                                                <td>
                                                    <?= $d->cp ?>
                                                </td>
                                                <td>
                                                    <div><?= $d->tempat ?></div>
                                                    <div class="small text-muted">
                                                        <?= $d->alamat ?></div>
                                                </td>
                                                <td>
                                                    <div class="small text-muted">Married Date</div>
                                                    <strong><?= $d->tanggal != ""? DateToIndo($d->tanggal) : ""; ?></strong>
                                                </td>
                                                <td>
                                                    <div class="small text-muted"><?= $d->user_real_name ?> : <?= $d->deskripsi ?></div>
                                                    <strong><?= $d->datetime != "" ? DateToIndo($d->datetime) : ""; ?></strong>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url() ?>Wedding/form?id=<?= $d->id ?>">
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Detail</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!--                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">Prev</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">4</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>-->
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>