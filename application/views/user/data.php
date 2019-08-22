
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">
            <a href="#">User</a>
        </li>
        <li class="breadcrumb-item active">Data</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">

                    <a href="<?= base_url() ?>User/add">
                        <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah User</button>
                    </a>
                    <br><br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Data User</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Aktif</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $val->user_real_name ?></td>
                                            <td><?= $val->user_email ?></td>
                                            <td><?= $val->user_phone ?></td>
                                            <td><?= $val->user_active == 1 ? "Aktif" : "Tidak Aktif" ?></td>
                                            <td>
                                                <a href="<?= base_url() ?>User/edit?id=<?= $val->user_id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                                <a href="<?= base_url() ?>User/delete?id=<?= $val->user_id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>

                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- <ul class="pagination">
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
                            </ul> -->
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>
