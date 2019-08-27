
<div role="main" class="ui-content">

    <div class="pages_maincontent">
        <h2 class="page_title">Paket Upacara</h2> 
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
                            foreach ($upacara as $val) {
                                ?>
                                <li><a onclick="getFieldUpacara('<?= $val->id_field ?>')" href="#upacara_<?= $val->id_field ?>" >        <?= $val->nama_upacara ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    foreach ($upacara as $val) {
                        ?>
                                    <!--<h3><?= $val->nama_upacara ?></h3>-->
                        <div id="upacara_<?= $val->id_field ?>">
                            
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
    function getFieldUpacara(id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/upacara/field?id=" + id,
            success: function (data) {
                $("#upacara_" + id).html(data);
            }
        });

    }

    function saveacara(id, value, type = null) {
        var id_wedding = $("#id_wedding").val();
        if (type == "addabletext") {
            var dataForm = new FormData($("#form" + value)[0]);
            dataForm.append('id', id);
            dataForm.append('id_wedding', id_wedding);
            dataForm.append('type', type);
            dataForm.append('value', value);
            $.ajax({
                url: "<?= base_url() ?>Wedding/upacara/add",
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
                url: "<?= base_url() ?>Wedding/upacara/add",
                type: "POST",
                data: dataForm,
                success: function (data) {
                }
            });
        }
    }
</script>