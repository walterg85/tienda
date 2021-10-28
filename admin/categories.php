<?php
    session_start();
    ob_start();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="input-group me-2">
            <input type="text" class="form-control" placeholder="Category name" aria-label="Category name" aria-describedby="btnAddCategory" id="inputName" autocomplete="off">
            <button class="btn btn-outline-secondary" type="button" id="btnAddCategory"><i class="bi bi-plus-lg"></i> Add Category</button>
        </div>
    </div>
</div>

<table class="table" id="categoryList"><thead class="table-light"></thead></table>

<script type="text/javascript">
    let dataTableCategory = null;

    $(document).ready(function(){
        currentPage = "Categories";

        $("#btnAddCategory").click( fnRegisterCategory);

        //listar categorias
        fnGetCategories();
    });

    function fnRegisterCategory(){
        $("#btnAddCategory").attr("disabled","disabled");
        $("#btnAddCategory").html('<i class="bi bi-clock-history"></i> Registering');

        let objData = {
            "_method":"POST",
            "name": $("#inputName").val()
        };

        $.post("../core/controllers/category.php", objData, function(result) {
            $("#btnAddCategory").removeAttr("disabled");
            $("#btnAddCategory").html('<i class="bi bi-plus-lg"></i> Add Category');

            $("#inputName").val("");

            fnGetCategories();
        });
    }

    function fnGetCategories(){
        let objData = {
            "_method":"Get"
        };

        if (dataTableCategory != null)
            dataTableCategory.destroy();

        $.post("../core/controllers/category.php", objData, function(result) {
            let mypaging =  false;

            if( (result.data).length > 20 )
                mypaging = true;

            dataTableCategory = $("#categoryList").DataTable({
                data: result.data,
                order: [[ 0, "desc" ]],
                columns:
                [
                    {
                        data: 'id',
                        title: '#',
                        width: "20px",
                        render: function(data, type, row){
                            return pad(data, 5);
                        }
                    },
                    {
                        data: 'name',
                        title: 'Name'
                    },
                    {
                        title: '',
                        data: null,
                        orderable: false,
                        class: "text-center",
                        render: function ( data, type, row )
                        {
                            return `
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnDeleteCategory" title="Delete"><i class="bi bi-trash"></i></a>
                            `;
                        }
                    }
                ],
                "fnDrawCallback":function(oSettings){
                    $(".btnDeleteCategory").unbind().click(function(){
                        let data = getData($(this), dataTableCategory),
                            buton = $(this);

                        if (confirm(`do you want to delete this category (${data.name})?`)){
                            buton.attr("disabled","disabled");
                            buton.html('<i class="bi bi-clock-history"></i>');

                            let objData = {
                                "_method":"Delete",
                                "categoryId": data.id
                            };

                            $.post("../core/controllers/category.php", objData, function(result) {
                                buton.removeAttr("disabled");
                                buton.html('<i class="bi bi-trash"></i>');

                                fnGetCategories();
                            });

                        }
                    });
                },
                searching: false,
                pageLength: 20,
                info: false,
                lengthChange: false,
                paging: mypaging
            });
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>