<?php
    @session_start();
    ob_start();
?>
<!-- cropperCSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" integrity="sha512-w+u2vZqMNUVngx+0GVZYM21Qm093kAexjueWOv9e9nIeYJb1iEfiHC7Y+VvmP/tviQyA5IR32mwN/5hTEJx6Ng==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- cropperJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js" integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <form id="frmCategorie" class="needs-validation" novalidate>
            <div class="input-group me-2">
                <input type="text" class="form-control" placeholder="Category name" aria-label="Category name" aria-describedby="btnAddCategory" id="inputName" name="inputName" autocomplete="off" required>
                <label class="input-group-text" for="inputPhoto" title="Click to select a photo"><i class="bi bi-camera"></i></label>
                <input type="file" class="form-control d-none" id="inputPhoto">
                <button class="btn btn-outline-secondary" type="button" id="btnAddCategory"><i class="bi bi-plus-lg"></i> Add Category</button>
            </div>
        </form>
    </div>
</div>

<table class="table" id="categoryList"><thead class="table-light"></thead></table>

<!-- Modal para editar las imagenes -->
<div class="modal fade" id="modalCrop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Edit / Crop the photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container mb-3" style="max-height: 500px">
                    <img id="previewCrop" src="#">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="cropImage">Apply</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let dataTableCategory = null,
        maxCroppedWidth = 300,
        maxCroppedHeight = 300,
        catPhoto = null;

    $(document).ready(function(){
        currentPage = "Categories";

        $("#btnAddCategory").click( fnRegisterCategory);

        // listar categorias
        fnGetCategories();

        // Iniciar componente de imagen
        initComponent();
    });

    function fnRegisterCategory(){
        let forms = document.querySelectorAll('.needs-validation'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (formv){ 
            if (!formv.checkValidity()) {
                    continuar = false;
            }

            formv.classList.add('was-validated');
        });

        if(!continuar)
            return false;

        $("#btnAddCategory").attr("disabled","disabled");
        $("#btnAddCategory").html('<i class="bi bi-clock-history"></i> Registering');

        let form = $("#frmCategorie")[0],
            formData = new FormData(form);

        formData.append("_method", "POST");

        if(catPhoto){
            let namePhoto = ($("#inputName").val()).replace(" ", "_");
            formData.append("imageCat", catPhoto, `${namePhoto}.jpg`);
        }

        $.ajax({
            url: '../core/controllers/category.php',
            data: formData,
            type: 'POST',
            dataType: 'json',
            success: function(response){
                $("#btnAddCategory").removeAttr("disabled");
                $("#btnAddCategory").html('<i class="bi bi-plus-lg"></i> Add Category');

                $("#inputName").val("");
                $("#frmCategorie").removeClass("was-validated");
                
                fnGetCategories();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
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
                        title: 'thumbnails',
                        data: 'thumbnail',
                        orderable: false,
                        class: "text-center",
                        width: "100px",
                        render: function ( data, type, row ) {
                            return `
                                <img src="../${data}" class="rounded" alt="Image cat" width="100">
                            `;
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

    function initComponent() {
        // Controlar tipo de objeto que intentan subir
        $('input[type="file"]').unbind().change( function(){
            let ext = $( this ).val().split('.').pop();

            if ($( this ).val() != ''){
                if($.inArray(ext, ["jpg", "jpeg", "png", "bmp", "raw", "tiff"]) != -1){
                    if($(this)[0].files[0].size > 5242880){
                        $( this ).val('');
                        alert('Your selected file is larger than 5MB');
                    }
                }else{
                    $( this ).val('');
                    alert(`${ext} files not allowed, only images`);
                }
            }
        });

        // Image Cropper
        let image       = $("#previewCrop")[0],
            inputFile1   = $("#inputPhoto")[0],
            $modal      = $('#modalCrop'),
            cropper     = null;

        inputFile1.addEventListener("change", function(e){
            let files = e.target.files,
                done  = function (url){
                    inputFile1.value = "";
                    image.src = url;
                    $modal.modal('show');
                },
                reader,
                file,
                url;

            if (files && files.length > 0){
                file = files[0];

                if (URL){
                    done(URL.createObjectURL(file));
                }
                else if (FileReader){
                    reader = new FileReader();
                    reader.onload = function(e){
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.unbind().on('shown.bs.modal', function(){
            let URL         = window.URL || window.webkitURL,
                container   = document.querySelector('.img-container'),
                download    = document.getElementById('download'),
                actions     = document.getElementById('cropper-buttons'),
                options     = {
                    viewMode: 1,
                    aspectRatio: maxCroppedWidth / maxCroppedHeight,
                };

            cropper = new Cropper(image, options);
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $("#cropImage").unbind().click( function(){
            let canvas;

            $modal.modal("hide");

            if(cropper){
                canvas = cropper.getCroppedCanvas({
                    width: maxCroppedWidth,
                    height: maxCroppedHeight,
                });

                canvas.toBlob(function (blob){
                    catPhoto = blob;
                });
            }
        });
    }

    function changePageLang(myLang){
        
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>