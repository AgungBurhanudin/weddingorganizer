<?php
if (empty($data_user)) {
    $id = "";
    $company = "";
    $group = "";
    $user_real_name = "";
    $user_user_name = "";
    $user_email = "";
    $user_phone = "";
    $user_address = "";
    $user_desc = "";
    $user_foto = "";
} else {
    foreach ($data_user as $val) {
        $id = $val->user_id;
        $group = $val->user_group_id;
        $company = $val->user_company;
        $user_real_name = $val->user_real_name;
        $user_user_name = $val->user_user_name;
        $user_email = $val->user_email;
        $user_phone = $val->user_phone;
        $user_address = $val->user_address;
        $user_desc = $val->user_desc;
        $user_foto = $val->user_foto;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">
            <a href="#">User</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?= base_url() ?>User/save" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> User</div>
                            <div class="card-body ">
                                <div>
                                    <div class="col-md-6" style="float: left">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Perusahaan <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <select name="user_company" id="user_company" class="form-control">
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
                                            <label class="col-md-3 col-form-label" for="text-input">Nama <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="user_real_name" id="user_real_name" placeholder="Nama" required="required" value="<?= $user_real_name ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">User Name <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <input onkeyup="validationForm(this)" class="form-control" type="text" name="user_user_name" id="user_user_name" placeholder="Username" required="required" value="<?= $user_user_name ?>">
                                                <span class="msg_form"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Email</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="user_email" id="user_email" placeholder="Email" value="<?= $user_email ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Password <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <input onkeyup="validationForm(this)" class="form-control" type="password" name="password" id="password" placeholder="Password" required="required">
                                                <span class="msg_form"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Konfirmasi Password <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <input onkeyup="validationForm(this)" class="form-control" type="password" name="repassword" id="repassword" placeholder="Konfirmasi Password" required="required">
                                                <span class="msg_form"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="float: left">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Grup User <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <select name="user_group" id="user_group" class="form-control" required="required">
                                                    <option value=""> -- Pilih Grup --</option>
                                                    <?php
                                                    foreach ($app_group as $val) {
                                                        $select = ($group == $val->group_id) ? "selected" : "";
                                                        ?>
                                                    <option <?= $select ?> value="<?= $val->group_id ?>"><?= $val->group_name ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">No Telephone </label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="user_phone" id="user_phone" placeholder="Telephone" value="<?= $user_phone ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Alamat </label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="user_address" id="user_address" placeholder="Alamat" value="<?= $user_address ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Keterangan</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="user_desc" id="user_desc" placeholder="Keterangan" value="<?= $user_desc ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="file-input">Foto Profile</label>
                                            <div class="col-md-9">
                                                <input id="file-input" type="file" name="userfile"><br>
                                                <?php
                                                if (file_exists(realpath(APPPATH . '../files/foto/') . "/" . $user_foto)) {
                                                    echo "<img src='" . base_url() . "/files/foto/$user_foto' height='60px'>";
                                                } else {
                                                    echo "";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="submit btn btn-sm btn-primary" type="submit" id="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?= base_url() ?>User">
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
<script>
</script>
</div>