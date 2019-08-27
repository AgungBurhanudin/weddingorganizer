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
        <h2 class="page_title">Ganti Password</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>
        <div class="page_content"> 

            <h3>Ganti Password</h3>

            <form class="form-horizontal" action="<?= base_url() ?>User/save" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $id ?>">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Password <span class="red">*</span></label>
                    <div class="col-md-9">
                        <input onkeyup="validationForm(this)" class="form_input" data-role="none" type="password" name="password" id="password" placeholder="Password" required="required">
                        <span class="msg_form"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">Konfirmasi Password <span class="red">*</span></label>
                    <div class="col-md-9">
                        <input onkeyup="validationForm(this)" class="form_input" data-role="none" type="password" name="repassword" id="repassword" placeholder="Konfirmasi Password" required="required">
                        <span class="msg_form"></span>
                    </div>
                </div>
                <button class="submit btn btn-sm btn-primary" type="submit" id="submit">
                    <i class="fa fa-dot-circle-o"></i> Simpan</button>
            </form>
        </div>
    </div>
</div>
<script>

    function validationForm(e) {
        var value = $(e).val();
        var msg = "<br>";
        var valid = true;
        if ($(e).attr("id") == "password") {
            if (value.length < 6) {
                msg += "Password harus 6 karakter atau lebih";
                valid = false;
            }
        } else if ($(e).attr("id") == "repassword") {
            var password = $("#password").val();
            if (password != value) {
                msg += "Password tidak sama";
                valid = false;
            }
        } else if ($(e).attr("id") == "user_user_name") {
            if (value.length < 6) {
                msg += "Username harus 6 karakter atau lebih dan tidak ada spasi";
                valid = false;
            }
        }
        if (valid == false) {
            $(e).parent().parent().parent().parent().parent().parent().parent().find(".submit").attr("disabled", "disabled");
        } else {
            $(e).parent().parent().parent().parent().parent().parent().parent().find(".submit").removeAttr("disabled");
        }
        $(e).parent().find(".msg_form").html(msg);
    }
</script>