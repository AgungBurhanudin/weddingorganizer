

<div role="main" class="ui-content">
    <div class="pages_maincontent">
        <div class="featured_image">
            <img src="<?= base_url() ?>assets/images/back.jpg" alt="" title=""> 
        </div>
        <div class="labelCountDown" id="countdownLabel">-- Hari -- Jam</div>
        <!--        <div class="heart">
                    
                </div>-->
        <div id="countdown">
            <?= $wedding->nama_pria ?> <br> <?= $wedding->nama_wanita ?>
        </div>
        <div style="clear: both"></div>
        <div class="page_content" style="margin-top: -90px"> 
            <a href="<?= base_url() ?>Dashboard/biodata">
                <div class="icon-wrap">
                    <div>
                        <img src="<?= base_url() ?>assets/images/icons/black/user.png" alt="" title="" />
                    </div>
                    <span class="icon-label">Biodata</span>
                </div>
            </a>
            <a href="<?= base_url() ?>Dashboard/meeting">
                <div class="icon-wrap">
                    <div>
                        <img src="<?= base_url() ?>assets/images/icons/black/blog.png" alt="" title="" />

                    </div>
                    <span class="icon-label">Meeting</span>
                </div>
            </a>

            <a href="<?= base_url() ?>Dashboard/vendor">
                <div class="icon-wrap">
                    <div>
                        <img src="<?= base_url() ?>assets/images/icons/black/team.png" alt="" title="" />

                    </div>
                    <span class="icon-label">Vendor</span>
                </div>
            </a>

            <div style="clear: both"></div>

            <a href="<?= base_url() ?>Dashboard/payment">
                <div class="icon-wrap">
                    <div>
                        <img src="<?= base_url() ?>assets/images/icons/black/contact.png" alt="" title="" />
                    </div>
                    <span class="icon-label">Payment</span>
                </div>
            </a>

            <a href="<?= base_url() ?>Dashboard/contactus">
                <div class="icon-wrap">
                    <div>
                        <img src="<?= base_url() ?>assets/images/icons/black/phone.png" alt="" title="" />
                    </div>
                    <span class="icon-label">Contact Us</span>
                </div>
            </a>

            <a href="<?= base_url() ?>Dashboard/layout">
                <div class="icon-wrap">
                    <div>
                        <img src="<?= base_url() ?>assets/images/icons/black/docs.png" alt="" title="" />
                    </div>
                    <span class="icon-label">Layout</span>
                </div>
            </a>
            <br>
            <br>
            <br>
            <hr>
            <h3>Aktivitas Terakhir</h3>
            <ul class="features_list">
                <li><a href="photos.html" data-transition="slidefade" class="ui-link"><span> > <?= $wedding->user_real_name ?> <?= $wedding->deskripsi ?></span></a></li>
            </ul>
            <!--            <ul class="features_list_detailed">
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/photos.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>Photo gallery</h4>
                                    <a href="photos.html" data-transition="slidefade">Easy create your own photo gallery app. List and full screen options available.</a>
                                </div>
                                <div class="view_more"><a href="photos.html" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li> 
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/blog.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>Blog layout</h4>
                                    <a href="blog.html" data-transition="slidefade">Create your news app with blog and comments section.</a>
                                </div>
                                <div class="view_more"><a href="blog.html" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li> 
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/user.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>User login</h4>
                                    <a href="login.html" data-transition="slidedown">Add a login form to your app to control your private content.</a>
                                </div>
                                <div class="view_more"><a href="login.html" data-transition="slidedown"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li>
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/lock.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>User account</h4>
                                    <a href="#right-panel">Create an user account page with profile image and custom menu.</a>
                                </div>
                                <div class="view_more"><a href="#right-panel"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li>                
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/docs.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>Responsive tabs and toogles</h4>
                                    <a href="http://ow.ly/XqzNo
                                       " data-transition="slidefade">Add responsive tabs to any page or section in your app. Add content with toogles will save a lot of space in your app layout.</a>
                                </div>
                                <div class="view_more"><a href="tabs.html" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li>
            
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/contact.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>Contact form</h4>
                                    <a href="contact.html" data-transition="slidefade">Receive messages from your clients using the allready build in contact form.</a>
                                </div>
                                <div class="view_more"><a href="contact.html" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li>
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/heart.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>Social share</h4>
                                    <a href="social.html" data-transition="slidedown">Allow users to follow you on your social websites.</a>
                                </div>
                                <div class="view_more"><a href="social.html" data-transition="slidedown"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li>
            
                            <li>
                                <div class="feat_small_icon"><img src="<?= base_url() ?>assets/images/icons/black/responsive.png" alt="" title="" /></div>
                                <div class="feat_small_details">
                                    <h4>For mobile and tablet</h4>
                                    <a href="videos.html" data-transition="slidefade">Full width layout for mobile and tablet resolutions.</a>
                                </div>
                                <div class="view_more"><a href="videos.html" data-transition="slidefade"><img src="<?= base_url() ?>assets/images/load_posts_disabled.png" alt="" title="" /></a></div>
                            </li>
            
                        </ul>-->
        </div>
    </div>

</div><!-- /content -->
<script>

// Set the date we're counting down to
    var countDownDate = new Date("<?= $wedding->tanggal ?> <?= $wedding->waktu ?>").getTime();

// Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $("#countdownLabel").html(days + " Hari " + hours + " Jam ");
//                + minutes + " Menit " + seconds + " Detik ");

            if (distance < 0) {
                clearInterval(x);
                $("#countdownLabel").html("Waktu Pengisian Data Sudah Habis");
                $("#detail_wedding *").attr("disabled", "disabled").off('click');
            }
        }, 1000);
        $(function () {
//        $('#tabAcara').scrollingTabs();
//        $('#tabPanitia').scrollingTabs();
//        $('#tabTambahan').scrollingTabs();
//        $('#tabUpacara').scrollingTabs();
        });
</script>