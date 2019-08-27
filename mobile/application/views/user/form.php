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
<div role="main" class="ui-content">

    <div class="pages_maincontent">
        <h2 class="page_title">Edit Profil</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>
        <div class="page_content"> 
            <?php
            if (($this->session->flashdata('success'))) {
                "<h4>" . $this->session->flashdata('success') . "</h4><hr>";
            } else {
                "";
            };
            ?>
            <h3>Form Edit Profil</h3>
            <form class="form-horizontal" action="<?= base_url() ?>User/save" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $id ?>">
                <div class="card">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Nama <span class="red">*</span></label>
                        <div class="col-md-9">
                            <input class="form_input" data-role="none" type="text" name="user_real_name" id="user_real_name" placeholder="Nama" required="required" value="<?= $user_real_name ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">User Name <span class="red">*</span></label>
                        <div class="col-md-9">
                            <input onkeyup="validationForm(this)" class="form_input" data-role="none" type="text" name="user_user_name" id="user_user_name" placeholder="Username" required="required" value="<?= $user_user_name ?>">
                            <span class="msg_form"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Email</label>
                        <div class="col-md-9">
                            <input class="form_input" data-role="none" type="text" name="user_email" id="user_email" placeholder="Email" value="<?= $user_email ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">No Telephone </label>
                        <div class="col-md-9">
                            <input class="form_input" data-role="none" type="text" name="user_phone" id="user_phone" placeholder="Telephone" value="<?= $user_phone ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Alamat </label>
                        <div class="col-md-9">
                            <input class="form_input" data-role="none" type="text" name="user_address" id="user_address" placeholder="Alamat" value="<?= $user_address ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="text-input">Keterangan</label>
                        <div class="col-md-9">
                            <input class="form_input" data-role="none" type="text" name="user_desc" id="user_desc" placeholder="Keterangan" value="<?= $user_desc ?>">
                        </div>
                    </div>
                    <!--                                    <div class="form-group row">
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
                                                        </div>-->
                    <button class="submit btn btn-sm btn-primary" type="submit" id="submit">
                        <i class="fa fa-dot-circle-o"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>