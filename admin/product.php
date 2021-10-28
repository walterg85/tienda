<?php
    session_start();
    ob_start();
?>

<!-- cropperCSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" integrity="sha512-w+u2vZqMNUVngx+0GVZYM21Qm093kAexjueWOv9e9nIeYJb1iEfiHC7Y+VvmP/tviQyA5IR32mwN/5hTEJx6Ng==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- cropperJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js" integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasProduct"><i class="bi bi-plus-lg"></i> Add Product</button>
        </div>
    </div>
</div>

<table class="table" id="productList"><thead class="table-light"></thead></table>

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

<!-- Panel lateral para agregar nuevo producto -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasProduct" aria-labelledby="offcanvasWithBackdropLabel"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Add a new product</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="addProductForm">
            <input type="hidden" name="productId" value="0">
            <div class="row">
                <div class="col mb-3">
                    <label for="inputName" class="form-label">Name</label>
                    <input type="text" id="inputName" name="inputName" class="form-control" autocomplete="off">
                </div>
                <div class="col mb-3">
                    <label for="inputNameSp" class="form-label">Name Spanish</label>
                    <input type="text" id="inputNameSp" name="inputNameSp" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="mb-3">
                <label for="inputDescription" class="form-label">Description</label>
                <input type="text" in="inputDescription" name="inputDescription" class="form-control" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="inputDescriptionSp" class="form-label">Description Spanish</label>
                <input type="text" in="inputDescriptionSp" name="inputDescriptionSp" class="form-control" autocomplete="off">
            </div>
            <div class="row">
                <div class="col-3 mb-3">
                    <label for="inputPrice" class="form-label">Price</label>
                    <input type="text" id="inputPrice" name="inputPrice" class="form-control" autocomplete="off">
                </div>
                <div class="col-3 mb-3">
                    <label for="inputSalePrice" class="form-label">Sale Price</label>
                    <input type="text" id="inputSalePrice" name="inputSalePrice" class="form-control" autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <label for="inputCategory" class="form-label">Category</label>
                    <select class="form-select" id="inputCategory" name="inputCategory">
                        <option value="0" selected>Select Category</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-3 d-none img1"><img src="#" class="img-thumbnail" alt="Product image" id="img1"></div>
                <div class="col-3 d-none img2"><img src="#" class="img-thumbnail" alt="Product image" id="img2"></div>
                <div class="col-3 d-none img3"><img src="#" class="img-thumbnail" alt="Product image" id="img3"></div>
                <div class="col-3 d-none img4"><img src="#" class="img-thumbnail" alt="Product image" id="img4"></div>
            </div>


            <div class="mb-3">
                <label for="image1" class="form-label">Add Image</label>
                <input class="form-control" type="file" id="image1" name="image1">
            </div>
            <div class="d-grid gap-2">
                <button type="button" name="addProduct" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var teamPhoto   = null,
        maxCroppedWidth = 420,
        maxCroppedHeight = 300,
        dataTableProduct = null;

    $(document).ready(function(){
        initComponent();
    });

    function initComponent() {
        // Controlar tipo de objeto que intentan subir
        $('input[type="file"]').unbind().change( function(){
            let ext = $( this ).val().split('.').pop();

            if ($( this ).val() != ''){
                if($.inArray(ext, ["jpg", "jpeg", "png", "bmp", "raw", "tiff"]) != -1){
                    if($(this)[0].files[0].size > 1048576){
                        $( this ).val('');
                        alert('Your selected file is larger than 1MB');
                    }
                }else{
                    $( this ).val('');
                    alert(`${ext} files not allowed, only images`);
                }
            }
        });

        // Image Cropper
        let picture = null,
            image       = $("#previewCrop")[0],
            inputFile   = $("#image1")[0],
            $modal      = $('#modalCrop'),
            cropper     = null;

        inputFile.addEventListener("change", function(e){
            $(".img1").removeClass("d-none");
            picture   = $("#img1");
            let files = e.target.files,
                done  = function (url){
                    inputFile.value = "";
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
                    viewMode: 3,
                    aspectRatio: maxCroppedWidth / maxCroppedHeight,
                };

            cropper = new Cropper(image, options);
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $("#cropImage").unbind().click( function(){
            let initialPhotoURL,
                canvas;

            $modal.modal("hide");

            if(cropper){
                canvas = cropper.getCroppedCanvas({
                    width: maxCroppedWidth,
                    height: maxCroppedHeight,
                });

                initialPhotoURL = picture.attr("src");
                picture
                    .attr("src", canvas.toDataURL())
                    .removeClass("d-none");

                canvas.toBlob(function (blob){
                    teamPhoto = blob;
                });
            }
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>