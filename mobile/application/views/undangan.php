<div role="main" class="ui-content">

    <div class="pages_maincontent">
        <h2 class="page_title">Undangan</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>
        <div class="page_content"> 

            <h3>Daftar Tamu Undangan</h3>
            <ul class="features_list">
                <?php
                $no = 1;
                if (!empty($undangan)) {
                    foreach ($undangan as $val) {
                        ?>
                        <li><a href="#" data-transition="slidefade" class="ui-link"><span><img src="<?= base_url() ?>assets/images/icons/black/user.png" alt="" title="">&nbsp;&nbsp;<?= $val->nama ?></span></a></li>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>Data Vendor Masih Kosong</td></tr>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>