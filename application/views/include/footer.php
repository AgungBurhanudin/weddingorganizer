<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirm_title"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="confirm_body">
                <p></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="confirm_url">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-info" type="button" onclick="doConfirmModal()">OK</button>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
<footer class="app-footer">
    <div>
        <!--<button class="btn btn-info mb-1" type="button" data-toggle="modal" data-target="#infoModal">Info modal</button>-->
        <a href="salatigaweb.com">Wedding Organizer</a>
        <span>&copy; 2019 .</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a href="salatigaweb.com">Wedding Organizer</a>
    </div>
</footer>
<script>
    function confirmModal(title, message, url) {
        $("#confirmModal").modal('show');
        $("#confirm_title").html(title);
        $("#confirm_body").html(message);
        $("#confirm_url").val(url);
    }
    function doConfirmModal() {
        var url = $("#confirm_url").val();
        $.ajax({
            url: url,
            dataType: "JSON",
            success: function (data) {
                if (data.resp_code == 200) {
                    $("#confirmModal").modal('hide');
                }
            }
        });
    }

    function validationForm(e) {
        var value = $(e).val();
        var msg = "<br>";
        var valid = true;
        if($(e).attr("id") == "password"){
            if(value.length < 6){
                msg += "Password harus 6 karakter atau lebih";
                valid = false;
            }
        }else if($(e).attr("id") == "repassword"){
            var password = $("#password").val();
            if(password != value){
                msg += "Password tidak sama";
                valid = false;
            }
        }else if($(e).attr("id") == "user_user_name"){
            if(value.length < 6){
                msg += "Username harus 6 karakter atau lebih dan tidak ada spasi";
                valid = false;
            }
        }
        if(valid == false){
            $(e).parent().parent().parent().parent().parent().parent().parent().find(".submit").attr("disabled","disabled");
        }else{
            $(e).parent().parent().parent().parent().parent().parent().parent().find(".submit").removeAttr("disabled");
        }
        $(e).parent().find(".msg_form").html(msg);
    }
</script>
</body>
</html>