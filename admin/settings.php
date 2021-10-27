<?php
    session_start();
    ob_start();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Save changes</button>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-3">
        <label for="inputCost" class="form-label">Shipping Cost</label>
        <input type="text" class="form-control shipingCost" placeholder="Shipping Cost" aria-label="Shipping Cost" id="inputCost">
    </div>
    <div class="col-3">
        <label for="inputFree" class="form-label">Free Shipping</label>
        <input type="text" class="form-control shipingFree" placeholder="Free Shipping" aria-label="Free Shipping" id="inputFree">
    </div>
</div>

<hr>

<div class="row g-3">
    <div class="col-3">
        <label for="inputUname" class="form-label">User name</label>
        <input type="text" class="form-control" placeholder="User name" aria-label="User name" id="inputUname" readonly>
    </div>
    <div class="col-4">
        <label for="inputMail" class="form-label">Email</label>
        <input type="mail" class="form-control" placeholder="Enter a email" aria-label="Enter a email" id="inputMail">
    </div>
    <div class="col-3">
        <label for="inputPass" class="form-label">Change Password</label>
        <input type="password" class="form-control" placeholder="New Password" aria-label="New Password" id="inputPass">
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        currentPage = "Settings";

        //listar Valores de configuracion
        fnGetconfig();
    });

    function fnGetconfig(){
        let objData = {
            "_method":"Get"
        };
        $.post("../core/controllers/setting.php", objData, function(result) {
             $.each( result.data, function( index, item){
                $(`.${item.parameter}`).val(item.value);
             });
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>