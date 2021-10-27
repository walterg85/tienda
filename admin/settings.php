<?php
    session_start();
    ob_start();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnUpdateData"><i class="bi bi-check2"></i> Save changes</button>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-3">
        <label for="inputshipingCost" class="form-label">Shipping Cost</label>
        <input type="text" class="form-control" placeholder="Shipping Cost" aria-label="Shipping Cost" id="inputshipingCost">
    </div>
    <div class="col-3">
        <label for="inputshipingFree" class="form-label">Free Shipping</label>
        <input type="text" class="form-control" placeholder="Free Shipping" aria-label="Free Shipping" id="inputshipingFree">
    </div>
</div>

<hr>

<div class="row g-3">
    <div class="col-3">
        <label for="inputUname" class="form-label">User name</label>
        <input type="text" class="form-control" placeholder="User name" aria-label="User name" id="inputUname" readonly value="<?php echo $_SESSION['authData']->owner; ?>">
    </div>
    <div class="col-4">
        <label for="inputMail" class="form-label">Email</label>
        <input type="mail" class="form-control" placeholder="Enter a email" aria-label="Enter a email" id="inputMail" value="<?php echo $_SESSION['authData']->email; ?>">
    </div>
    <div class="col-3">
        <label for="inputPass" class="form-label">Change Password</label>
        <input type="password" class="form-control" placeholder="New Password" aria-label="New Password" id="inputPass">
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        currentPage = "Settings";

        $("#btnUpdateData").click( fnUpdateData);

        //listar Valores de configuracion
        fnGetconfig();
    });

    function fnGetconfig(){
        let objData = {
            "_method":"Get"
        };
        $.post("../core/controllers/setting.php", objData, function(result) {
             $.each( result.data, function( index, item){
                $(`#input${item.parameter}`).val(item.value);
             });
        });
    }

    function fnUpdateData(){
        $("#btnUpdateData").attr("disabled","disabled");
        $("#btnUpdateData").html('<i class="bi bi-clock-history"></i> Updating');

        let objData = {
            "_method":"updateData",
            "shipingCost": $("#inputshipingCost").val(),
            "shipingFree": $("#inputshipingFree").val(),
            "owner": $("#inputUname").val(),
            "email": $("#inputMail").val(),
            "password": $("#inputPass").val()

        };

        $.post("../core/controllers/setting.php", objData, function(result) {
            alert(result.message);
            isNew = <?php echo $_SESSION['authData']->isDefault; ?>;

            $("#btnUpdateData").removeAttr("disabled");
            $("#btnUpdateData").html('<i class="bi bi-check2"></i> Save changes');
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>