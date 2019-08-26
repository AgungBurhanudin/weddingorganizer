
<div role="main" class="ui-content">

    <div class="pages_maincontent">
        <h2 class="page_title">Biodata</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>
        <div class="tabs_content"> 

            <div data-role="tabs" id="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#one" class="ui-btn-active">Biodata Pria</a></li>
                        <li><a href="#two">Biodata Wanita</a></li>
                    </ul>
                </div>
                <div id="one">
                    <h3>Biodata Pria</h3>
                    <p>
                        <?= $this->load->view('biodata/pria') ?>
                    </p>
                </div>

                <div id="two">
                    <h3>Biodata Wanita</h3>
                    <p>
                        <?= $this->load->view('biodata/wanita') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>        
</div><!-- /content -->