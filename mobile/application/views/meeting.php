<div role="main" class="ui-content">


    <div class="pages_maincontent">

        <h2 class="page_title">Jadwal Meeting</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>

        <div class="blog_content"> 

            <div class="blog-posts">
                <ul class="posts">
                    <?php
                    if (!empty($meeting)) {
                        foreach ($meeting as $val) {
                            ?>
                            ?>
                            <li style="display: inline-block;">
                                <div class="post_entry">
                                    <div class="post_date">
                                        <span class="day"><?= $val->tanggal ?></span>
                                        <span class="month"><?= $val->tanggal ?></span>
                                    </div>
                                    <div class="post_title">
                                        <h2><a href="#" data-transition="flip" class="ui-link">Di <?= $val->tempat ?><br><?= $val->keperluan ?></a></h2>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                    } else {
                        echo "<li>Data Meeting Masih Kosong</li>";
                    }
                    ?>
                </ul>

                <div class="clear"></div>  
                <div id="loadMore"><img src="images/load_posts.png" alt="" title=""></div> 
                <div id="showLess"><img src="images/load_posts.png" alt="" title=""></div> 
            </div>

        </div>

    </div>


</div>