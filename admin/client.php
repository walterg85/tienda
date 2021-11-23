<?php
    @session_start();
    ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Clients</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-secondary btnPanel" data-bs-toggle="offcanvas" data-bs-target="#offcanvasClient"><i class="bi bi-plus-lg"></i> Add new client</button>
        </div>
    </div>
</div>

<table class="table" id="clientList">
    <thead class="table-light">
        <th class="colA"></th>
        <th class="colB"></th>
        <th class="colC"></th>
        <th class="colD"></th>
    </thead>
</table>

<!-- Panel lateral para agregar nuevo producto -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasClient" aria-labelledby="offcanvasWithBackdropLabel"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Add a new client</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="addClientForm" class="needs-validation" novalidate>
            <input type="hidden" name="clientId" id="clientId" value="0">
            <div class="row">
                <div class="col mb-3">
                    <label for="inputName" class="form-label labelName">Name</label>
                    <input type="text" id="inputName" name="inputName" class="form-control" autocomplete="off" maxlength="250" required>
                </div>
                <div class="col mb-3">
                    <label for="inputLastname" class="form-label labelLastname">Last name</label>
                    <input type="text" id="inputLastname" name="inputLastname" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="inputAddress" class="form-label labelAddress">Address</label>
                <input type="text" id="inputAddress" name="inputAddress" class="form-control" autocomplete="off" maxlength="500" required>
            </div>
            <div class="mb-3">
                <label for="inputAddress2" class="form-label labelAddress2">Address 2</label>
                <input type="text" id="inputAddress2" name="inputAddress2" class="form-control" autocomplete="off" maxlength="500" required>
            </div>
            <div class="mb-3">
                <label for="inputPhone" class="form-label labelPhone">Phone</label>
                <input type="text" id="inputPhone" name="inputPhone" class="form-control" autocomplete="off" maxlength="20" required>
            </div>
            <div class="row">
                <div class="col-5 mb-3">
                    <label for="inputCity" class="form-label labelCity">City</label>
                    <input type="text" id="inputCity" name="inputCity" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col-4 mb-3">
                    <label for="inputState" class="form-label labelState">State</label>
                    <input type="text" id="inputState" name="inputState" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col-3 mb-3">
                    <label for="inputZip" class="form-label labelZip">Zip</label>
                    <input type="text" id="inputZip" name="inputZip" class="form-control" autocomplete="off" maxlength="10" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="inputInfo" class="form-label labelOtionalInfo">Optional info</label>
                <input type="text" id="inputInfo" name="inputInfo" class="form-control" autocomplete="off" maxlength="500">
            </div>
            <div class="d-grid gap-2 my-5">
                <button class="btn btn-success btn-lg" type="button" id="addClient">
                    <i class="bi bi-check2"></i> Save information
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var myOffcanvas     = document.getElementById('offcanvasClient'),
        dataTableClient = null;

    $(document).ready(function(){
        currentPage = "Clients";

        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            $("#clientId").val("0");
            $("#addClientForm")[0].reset();
            $("#addClientForm").removeClass("was-validated");
        });

        $("#addClient").click( registerClient);
    });

    function registerClient() {
        let forms       = document.querySelectorAll('.needs-validation'),
            continuar   = true;

        // Recore cada campo del formulario para valirdar su contenido
        Array.prototype.slice.call(forms).forEach(function (formv){ 
            if (!formv.checkValidity()) {
                    continuar = false;
            }

            formv.classList.add('was-validated');
        });

        // si todo esta validado correctamente, se procede al envio de informacion
        if(!continuar)
            return false;

        // se bloqueda el boton para evitar doble accion
        $("#addClient").attr("disabled","disabled");
        $("#addClient").html('<i class="bi bi-clock-history"></i> Saving...');

        let form        = $("#addClientForm")[0],
            formData    = new FormData(form);

        formData.append("_method", "POST");

        var request = new XMLHttpRequest();
        request.open("POST", "../core/controllers/client.php");
        request.send(formData);
        
        $("#addClient").removeAttr("disabled");
        $("#addClient").html('<i class="bi bi-check2"></i> Save information');

        $(".btnPanel").click();
    }

    function changePageLang(argument) {
        console.log(argument);
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>