
<div role="main" class="ui-content">

    <div class="pages_maincontent">
        <h2 class="page_title">Paket Tambahan</h2> 
        <div style="float: right;margin-top: 15px;margin-right: 15px">
            <a href="<?= base_url() ?>Dashboard" data-rel="back" class="ui-link"><img src="<?= base_url() ?>assets/images/icons/black/menu_close.png" alt="" title="" height="30px"></a>
        </div>
        <div class="page_content"> 
            <input type="hidden" name="id_wedding" id="id_wedding" value="<?= $id_wedding ?>">
            <div class="tabs_content"> 
                <div data-role="tabs" id="tabs">
                    <div data-role="navbar">
                        <ul>
                            <?php
                            foreach ($tambahan as $val) {
                                ?>
                                <li><a onclick="getFieldTambahan('<?= $val->id_field ?>')" href="#tambahan_<?= $val->id_field ?>" >        <?= $val->nama_tambahan ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    foreach ($tambahan as $val) {
                        ?>
                                    <!--<h3><?= $val->nama_tambahan ?></h3>-->
                        <div id="tambahan_<?= $val->id_field ?>">
                            
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getFieldTambahan(id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/tambahan/field?id=" + id,
            success: function (data) {
                $("#tambahan_" + id).html(data);
            }
        });

    }

    function savetambahan(id, value, type = null) {
        var id_wedding = $("#id_wedding").val();
        if (type == "addabletext") {
            var dataForm = new FormData($("#form" + value)[0]);
            dataForm.append('id', id);
            dataForm.append('id_wedding', id_wedding);
            dataForm.append('type', type);
            dataForm.append('value', value);
            $.ajax({
                url: "<?= base_url() ?>Wedding/tambahan/add",
                type: "POST",
                data: dataForm,
                processData: false,
                contentType: false,
                success: function (data) {
                }
            });
        } else {
            dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
            $.ajax({
                url: "<?= base_url() ?>Wedding/tambahan/add",
                type: "POST",
                data: dataForm,
                success: function (data) {
                }
            });
        }
    }
</script>