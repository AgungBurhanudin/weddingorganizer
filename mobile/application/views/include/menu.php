<?php
$this->load->model(array('wedding_model'));
$auth = $this->session->userdata('auth');
$id_wedding = $auth['id_wedding'];
$dataWedding = $this->wedding_model->getOneData($id_wedding);
?>
<div data-role="panel" id="left-panel" data-display="reveal" data-position="left">

    <nav class="main-nav">
        <ul>
            <li><a href="<?= base_url() ?>Dashboard" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/home.png" alt="" title="" /><span>Home</span></a></li>
            <li><a href="<?= base_url() ?>Upacara" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/toggle.png" alt="" title="" /><span>Upacara</span></a></li>
            <li><a href="<?= base_url() ?>Acara" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/docs.png" alt="" title="" /><span>Acara</span></a></li>
            <li><a href="<?= base_url() ?>Panitia" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/team.png" alt="" title="" /><span>Panitia</span></a></li>
            <li><a href="<?= base_url() ?>Tambahan" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/briefcase.png" alt="" title="" /><span>Tambahan/Lampiran</span></a></li>
            <li><a href="<?= base_url() ?>Undangan" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/heart.png" alt="" title="" /><span>Undangan</span></a></li>
            <li><a href="<?= base_url() ?>Dashboard/log" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/support.png" alt="" title="" /><span>Log Aktivitas</span></a></li>
            <li><a href="<?= base_url() ?>Cetak" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/icons/white/message.png" alt="" title="" /><span>Buku Acara</span></a></li>
        </ul>
    </nav> 

</div><!-- /panel -->

<div data-role="panel" id="right-panel" data-display="reveal" data-position="right">

    <div class="user_login_info">

        <div class="user_thumb_container">
            <img src="<?= base_url() ?>assets/images/back2.jpg" alt="" title="" /> 
            <div class="user_thumb">
                <img src="<?= base_url() ?>../files/images/<?= $dataWedding->foto_pria != "" ? $dataWedding->foto_pria : "user.jpg" ?>" alt="" title="" />     
                <img src="<?= base_url() ?>../files/images/<?= $dataWedding->foto_wanita != "" ? $dataWedding->foto_wanita : "user.jpg" ?>" alt="" title="" />     
            </div>  
        </div>

        <div class="user_details">
            <p><?= $dataWedding->nama_pria ?> & <?= $dataWedding->nama_wanita ?></p>
        </div>  


        <nav class="user-nav">
            <ul>
                <li><a href="<?= base_url() ?>User/edit"><img src="<?= base_url() ?>assets/images/icons/white/settings.png" alt="" title="" /><span>Edit Profile</span></a></li>
                <li><a href="<?= base_url() ?>User/password"><img src="<?= base_url() ?>assets/images/icons/white/briefcase.png" alt="" title="" /><span>Ganti Password</span></a></li>
                <li>&nbsp;<br></li>
                <li><a href="<?= base_url() ?>Logout"><img src="<?= base_url() ?>assets/images/icons/white/lock.png" alt="" title="" /><span>Logout</span></a></li>
            </ul>
        </nav>
    </div>
    <div class="close_loginpopup_button"><a href="#" data-rel="close"><img src="<?= base_url() ?>assets/images/icons/white/menu_close.png" alt="" title="" /></a></div>

</div><!-- /panel -->


</div><!-- /page -->