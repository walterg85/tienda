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
            <button type="button" class="btn btn-outline-secondary btnPanel" data-bs-toggle="offcanvas" data-bs-target="#offcanvasProduct"><i class="bi bi-plus-lg"></i> Add Product</button>
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
                <input type="text" id="inputDescription" name="inputDescription" class="form-control" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="inputDescriptionSp" class="form-label">Description Spanish</label>
                <input type="text" id="inputDescriptionSp" name="inputDescriptionSp" class="form-control" autocomplete="off">
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
                    <select class="form-select" id="inputCategory" name="inputCategory"></select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3 d-none img1">
                    <img src="#" class="img-thumbnail" alt="Product image" id="img1">
                    <span class="top-0 start-100 badge rounded-pill bg-danger removePhoto" data-control="image1" data-pic="1">
                        <i class="bi bi-x-lg"></i>
                    </span>
                </div>
                <div class="col-3 d-none img2">
                    <img src="#" class="img-thumbnail" alt="Product image" id="img2">
                    <span class="top-0 start-100 badge rounded-pill bg-danger removePhoto" data-control="image2" data-pic="2">
                        <i class="bi bi-x-lg"></i>
                    </span>
                </div>
                <div class="col-3 d-none img3">
                    <img src="#" class="img-thumbnail" alt="Product image" id="img3">
                    <span class="top-0 start-100 badge rounded-pill bg-danger removePhoto" data-control="image3" data-pic="3">
                        <i class="bi bi-x-lg"></i>
                    </span>
                </div>
                <div class="col-3 d-none img4">
                    <img src="#" class="img-thumbnail" alt="Product image" id="img4">
                    <span class="top-0 start-100 badge rounded-pill bg-danger removePhoto" data-control="image4" data-pic="4">
                        <i class="bi bi-x-lg"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <label for="image1" class="form-label">Add Image</label>
                <input class="form-control" type="file" id="image1">
            </div>

            <div class="mb-3">
                <label for="image2" class="form-label">Add Image</label>
                <input class="form-control" type="file" id="image2">
            </div>

            <div class="mb-3">
                <label for="image3" class="form-label">Add Image</label>
                <input class="form-control" type="file" id="image3">
            </div>

            <div class="mb-3">
                <label for="image4" class="form-label">Add Image</label>
                <input class="form-control" type="file" id="image4">
            </div>

            <div class="d-grid gap-2 my-5">
                <button class="btn btn-success btn-lg" type="button" id="addProduct">
                    <i class="bi bi-check2"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var productPhotos   = {},
        maxCroppedWidth = 420,
        maxCroppedHeight = 300,
        dataTableProduct = null,
        formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });

    $(document).ready(function(){
        $(".removePhoto").click( function(){
            let datas = $(this).data();
            $(`#${datas.control}`).parent().removeClass('d-none');
            $(`.img${datas.pic}`).addClass('d-none');

            productPhotos[datas.control] = null;
        });

        $("#addProduct").click( registerProduct);

        getProducts();
        loadCategories();
        initComponent();
    });

    function loadCategories(){
        let objData = {
            "_method":"Get"
        };

        $.post("../core/controllers/category.php", objData, function(result) {
            let optList = '<option value="0" selected>Select Category</option>';
            $.each( result.data, function( index, item){
                optList += `<option value="${item.id}">${item.name}</option>`;
            });
            $(optList).appendTo("#inputCategory");
        });
    }

    function registerProduct(){
        let form = $("#addProductForm")[0],
            formData = new FormData(form);

        formData.append("_method", "POST");

        $.each(productPhotos, function( index, value ) {
            if(value)
                formData.append("imagesproduct[]", value, `${index}.jpg`);
        });

        $.ajax({
            url: '../core/controllers/product.php',
            data: formData,
            type: 'POST',
            dataType: 'json',
            success: function(response){

                $("#addProductForm")[0].reset();
                $(".btnPanel").click();

                productPhotos = {};

                $(`#image1, #image2, #image3, #image4`).parent().removeClass('d-none');
                $(`.img1, .img2, .img3, .img4`).addClass('d-none');

                getProducts();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function getProducts(){
        let objData = {
            "_method":"GET"
        };

        if (dataTableProduct != null)
            dataTableProduct.destroy();

        $.post("../core/controllers/product.php", objData, function(result) {
            let mypaging =  false;

            if( (result.data).length > 20 )
                mypaging = true;

            dataTableProduct = $("#productList").DataTable({
                data: result.data,
                order: [[ 0, "desc" ]],
                columns:
                [
                    {
                        data: 'id',
                        title: '#',
                        width: "20px",
                        render: function(data, type, row) {
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
                                <img src="../${data}" class="rounded" alt="Image product" width="100">
                            `;
                        }
                    },
                    {
                        data: 'name',
                        title: 'Name'
                    },
                    {
                        data: 'descriptions',
                        title: 'Descriptions'
                    },
                    {
                        data: 'categoria',
                        title: 'Category',
                        render: function ( data, type, row ) {
                            return data.name;
                        }
                    },
                    {
                        data: 'price',
                        title: 'Price',
                        render: function (data, type, row) {
                            return formatter.format(data);
                        }
                    },
                    {
                        data: 'sale_price',
                        title: 'Sale price',
                        render: function (data, type, row) {
                            return formatter.format(data);
                        }
                    },
                    {
                        title: '',
                        data: null,
                        orderable: false,
                        class: "text-center",
                        render: function ( data, type, row ) {
                            return `
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btnEditProduct me-2" title="Edit"><i class="bi bi-eye"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnDeleteProduct" title="Delete"><i class="bi bi-trash"></i></a>
                            `;
                        }
                    }
                ],
                "fnDrawCallback":function(oSettings){
                    $(".btnDeleteProduct").unbind().click(function(){
                        let data = getData($(this), dataTableProduct),
                            buton = $(this);

                        if (confirm(`do you want to delete this product (${data.name})?`)){
                            buton.attr("disabled","disabled");
                            buton.html('<i class="bi bi-clock-history"></i>');

                            let objData = {
                                "_method":"Delete",
                                "productId": data.id
                            };

                            $.post("../core/controllers/product.php", objData, function(result) {
                                buton.removeAttr("disabled");
                                buton.html('<i class="bi bi-trash"></i>');

                                getProducts();
                            });

                        }
                    });

                    $(".btnEditProduct").unbind().click(function(){
                        let data = getData($(this), dataTableProduct),
                            buton = $(this),
                            currentImages = JSON.parse(data.images);

                        $("#inputName").val(data.name);
                        $("#inputNameSp").val(data.optional_name);
                        $("#inputDescription").val(data.descriptions);
                        $("#inputDescriptionSp").val(data.optional_description);
                        $("#inputPrice").val(data.price);
                        $("#inputSalePrice").val(data.sale_price);
                        $("#inputCategory").val(data.categoria.id);

                        $.each( currentImages, function( index, item){
                            let control = (item.split('/').pop()).substring(0,6),
                                pic = control.substring(5,6);

                            $(`.img${pic}`).removeClass('d-none');
                            $(`#img${pic}`).attr("src", `../${item}`);
                            $(`#${control}`).parent().addClass('d-none');
                        });

                        $(".btnPanel").click();
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
            inputFile1   = $("#image1")[0],
            inputFile2   = $("#image2")[0],
            inputFile3   = $("#image3")[0],
            inputFile4   = $("#image4")[0],
            $modal      = $('#modalCrop'),
            cropper     = null,
            curentInput = null; 

        inputFile1.addEventListener("change", function(e){
            picture   = $("#img1");
            let files = e.target.files,
                done  = function (url){
                    inputFile1.value = "";
                    image.src = url;
                    $modal.modal('show');
                    curentInput = inputFile1;
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

        inputFile2.addEventListener("change", function(e){
            picture   = $("#img2");
            let files = e.target.files,
                done  = function (url){
                    inputFile2.value = "";
                    image.src = url;
                    $modal.modal('show');
                    curentInput = inputFile2;
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

        inputFile3.addEventListener("change", function(e){
            picture   = $("#img3");
            let files = e.target.files,
                done  = function (url){
                    inputFile3.value = "";
                    image.src = url;
                    $modal.modal('show');
                    curentInput = inputFile3;
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

        inputFile4.addEventListener("change", function(e){
            picture   = $("#img4");
            let files = e.target.files,
                done  = function (url){
                    inputFile4.value = "";
                    image.src = url;
                    $modal.modal('show');
                    curentInput = inputFile4;
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
            curentInput.parentNode.classList.add("d-none");

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
                    .removeClass("d-none")
                    .parent().removeClass('d-none');

                canvas.toBlob(function (blob){
                    productPhotos[curentInput.id] = blob;
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