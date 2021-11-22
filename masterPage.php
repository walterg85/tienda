<?php
    // Url raiz, para todas las coneciones al controlador, este se debe cambiar cuando se publica el proecto con una DNS
    $base_url = 'http://localhost/tienda';
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

    <link href="<?php echo $base_url; ?>/assets/css/product.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/chat.css?v=1.1">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>Online Store</title>
</head>
<style type="text/css">
    .dropdown-menu{
        width: 100% !important;
    }
</style>
<body>
    <div class="container">
        <input type="checkbox" id="check"><label class="chat-btn" for="check"><i class="fa fa-commenting-o comment"></i><i class="fa fa-close close"></i></label>
        <div class="wrapper">
            <div class="header">
                <h6 class="labelChatTitle">Let's Chat - Online</h6>
            </div>
            <a href="javascript:void(0);"class="list-group-item lblControl d-none">
                <span><i class="fa fa-power-off"></i> <text class="labelFinish">Finish chatting</text></span>
            </a>
            <div class="text-center p-2">
                <span class="lblWelcome">Please fill out the form to start chat!</span>
                <div id="chatLog" class="d-none"></div>
            </div>
            <div class="chat-form">
                <div id="divRegistro">
                    <input type="text" class="form-control" placeholder="Name" id="inputName">
                    <input type="text" class="form-control" placeholder="Email" id="inputMail">
                    <textarea class="form-control" placeholder="Your Text Message" id="inputInitialMessage"></textarea>
                    <button class="btn btn-success btn-block pull-right" id="btnStart">Submit</button>
                </div>
                <div id="divConversasion" class="d-none">
                    <textarea class="form-control" placeholder="Your Message" id="inputNewMessage"></textarea>
                    <button class="btn btn-success btn-block pull-right" id="btnSendmessage">Send</button>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="row g-3">
            <div class="col-auto">
                <a class="text-warning text-decoration-none changeLang" href="javascript:void(0);"></a>
                <a href="javascript:void(0);" class="ms-2 text-decoration-none" id="checkCart" data-bs-toggle="modal" data-bs-target="#mdlCheckCart">View cart</a>
                <a href="javascript:void(2);" class="ms-2 text-decoration-none btnCheckout">Checkout</a>
            </div>
            <div class="col-sm-4">
                <div class="dropdown">
                    <input type="text" class="form-control dropdown-toggle" id="inputSearch" placeholder="Search..." autocomplete="off" >
                    <ul class="dropdown-menu" aria-labelledby="inputSearch"></ul>
                </div>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div class="container px-4 py-5 text-secondary">
            <h2 class="pb-2 text-center display-6 categories">Top Categories</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-2 row-cols-sm-5" id="categoriesList"></div>
            <div class="feature col catClone d-none">
                <div class="mb-3">
                    <img src="#" class="img-fluid rounded-circle border border-3 border-warning catImage">
                </div>
                <P class="text-center catName"></P>
            </div>
        </div>

        <!-- Aqui se imprime todo el contedido de las paginas secundarias capturados del buffer -->
        <?php echo $content; ?>

        <!-- Footer -->
        <div>
            <hr>
        </div>
    </div>

    <!-- Modal para ver items agregados al carrito -->
    <div class="modal fade" tabindex="-1" id="mdlCheckCart" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myCart">My Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group mb-3" id="cartListItem"></ul>
                    <li class="list-group-item d-flex justify-content-between lh-sm cartItemClone d-none">
                        <img src="#" alt="twbs" height="32" class="rounded flex-shrink-0 prdImg">

                        <div class="input-group input-group-sm contBtn ms-2" style="width:90px; height: fit-content;">
                            <button class="btn btn-outline-secondary btnDown" type="button">-</button>
                            <input type="text" class="form-control intQty text-center" disabled>
                            <button class="btn btn-outline-secondary btnUp" type="button">+</button>
                        </div>

                        <div class="w-50 ms-2">
                            <h6 class="my-0 prodName">Women's glove</h6>
                        </div>
                        <span class="text-muted prodPrice">$45.50</span>
                        <a href="javascript:void(0);" class="text-danger btnRemove ms-2">X</a>
                    </li>

                    <p class="lead text-danger text-end" id="lblTotal"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btnKeepShopping" data-bs-dismiss="modal">Keep Shopping</button>
                    <button type="button" class="btn btn-primary btnCheckout">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para seleccion de producto -->
    <div class="modal fade" id="mdlProDetalle" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mdltitle2" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdltitle2">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-6 border-end">
                                <div class="d-flex flex-column justify-content-center">
                                    <div class="main_image"> <img src="#" id="main_product_image" class="img0" width="350"></div>
                                    <div class="thumbnail_images">
                                        <ul id="thumbnail">
                                            <li class="d-none"><img onclick="changeImage(this)" src="#" width="70" class="img0"></li>
                                            <li class="d-none"><img onclick="changeImage(this)" src="#" width="70" class="img1"></li>
                                            <li class="d-none"><img onclick="changeImage(this)" src="#" width="70" class="img2"></li>
                                            <li class="d-none"><img onclick="changeImage(this)" src="#" width="70" class="img3"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 right-side">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="lblMdlName"></h3> <span class="heart"><i class='bx bx-heart'></i></span>
                                    </div>
                                    <div class="mt-2 pr-3 content">
                                        <p class="lblDescription"></p>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3 dvSizes d-none">
                                            <label class="form-label">Sizes</label><br>
                                            <div class="form-check form-check-inline d-none chSizes">
                                                <input class="form-check-input chk" type="radio" name="chsizes" value="0">
                                                <label class="form-check-label lbl">Small</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3 dvColors d-none">
                                            <label class="form-label">Colors</label><br>
                                            <div class="form-check form-check-inline d-none chColors">
                                                <input class="form-check-input chk" type="radio"  name="chcolors" value="0">
                                                <label class="form-check-label lbl">Small</label>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="lblMdlPrice"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="mdlAddtoCart">Add to cart</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

<script type="text/javascript">
    var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }),
        searchRequest = null,
        productLimite = 0,
        base_url = "<?php echo $base_url; ?>",
        refreshLog          = null,
        lang                = (window.navigator.language).substring(0,2),
        intervalContador    = null, // Contador para establecer los 20 segundos para lanzar el chat
        contador            = 0;

    $(document).ready(function(){
        loadCategories();

        $("#btnStart").on("click", function(){
            // Validar que se hayan ingresado todos los datos adecuadamente
            if(($("#inputMail").val()).length == 0 || ($("#inputName").val()).length == 0 || ($("#inputInitialMessage").val()).length == 0)
                return false;

            $(".lblWelcome").addClass("d-none");
            $("#divRegistro").addClass("d-none");
            $("#divConversasion").removeClass("d-none");
            $("#chatLog").removeClass("d-none");
            $(".lblControl").removeClass("d-none");

            sendMessage($("#inputInitialMessage").val(), 1);
        });

        $("#btnSendmessage").on("click", function(){
            sendMessage($("#inputNewMessage").val(), 2);
        });

        $(".lblControl").on("click", function(){
            if (confirm('Do you really want to end the chat with tech support?')){
                $(".lblWelcome").removeClass("d-none");
                $("#divRegistro").removeClass("d-none");
                $("#divConversasion").addClass("d-none");
                $("#chatLog").addClass("d-none");
                $(".lblControl").addClass("d-none");

                $("#chatLog").html("");
                clearInterval(refreshLog);
                localStorage.removeItem("cliData");

                let dt = new Date(),
                    time = dt.getHours() + ":" + dt.getMinutes();

                let objData = {
                    email: $("#inputMail").val(),
                    name: $("#inputName").val(),
                    _method: "POST",
                    _action: "closeChat",
                    _time: time
                };

                $.post(`${base_url}/core/controllers/chat.php`, objData);
            }
        });

        let cliData = JSON.parse( localStorage.getItem("cliData") );
        if(cliData){
            $("#inputMail").val(cliData.mail);
            $("#inputName").val(cliData.name);

            $(".lblWelcome").addClass("d-none");
            $("#divRegistro").addClass("d-none");
            $("#divConversasion").removeClass("d-none");
            $("#chatLog").removeClass("d-none");
            $(".lblControl").removeClass("d-none");

            loadLog();
            refreshLog = setInterval(loadLog, 2500);
        }else{
            intervalContador = setInterval( function(){
                // Incrementar el contador en 1
                contador += 1;

                // Verificar si pasaron los 20 segundos, detener el contador y mostrar el formulario del chat
                if(contador > 20){
                    clearInterval(intervalContador);
                    $(".chat-btn").click();
                }

            }, 1000);
        }

        $(".btnCheckout").click( function(){
            // A todas las referencias de directorios locales se le concatena la variable base_url, para indicar la ruta absoluta
            window.location.href = `${base_url}/checkout/index.php`
        });

        if( localStorage.getItem("currentLag") ){
            lang = localStorage.getItem("currentLag");
        }else{
            localStorage.setItem("currentLag", lang);
        }

        $(".changeLang").click( function(){
            if (localStorage.getItem("currentLag") == "es") {
                localStorage.setItem("currentLag", "en");
                lang = "en";
            }else{
                localStorage.setItem("currentLag", "es");
                lang = "es";
            }
            switchLanguage(lang);
        });

        switchLanguage(lang);

        $("#mdlAddtoCart").click( function() {
            let currentItem = $(this).data("item"),
                newItem = {},
                currentCart = JSON.parse(localStorage.getItem("currentCart")),
                config = JSON.parse(currentItem.dimensions),
                size = null,
                color = null,
                newItemId = currentItem.id;

            if(!currentCart){
                localStorage.setItem("currentCart", "{}");
                currentCart = {};
            }

            if((config[0].sizes).length > 0){
                size = $("input[type=radio][name=chsizes]:checked").val();
                newItemId += `|s-${size}`;
                newItem.size = size;
            }

            if(config[1].colors[0] != ""){
                color = $("input[type=radio][name=chcolors]:checked").val();
                newItemId += `|c-${color}`;
                newItem.color = color;
            }

            newItem.id = currentItem.id;
            newItem.name = currentItem.name;
            newItem.descriptions = currentItem.descriptions;
            newItem.optional_name = currentItem.optional_name;
            newItem.optional_description = currentItem.optional_description;
            newItem.thumbnail = currentItem.thumbnail;

            if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
                newItem.price = currentItem.sale_price;
            }else{
                newItem.price = currentItem.price;
            }

            if(currentCart[newItemId]){
                currentCart[newItemId].qty = currentCart[newItemId].qty + 1;
            }else{
                newItem.qty = 1;
                currentCart[newItemId] = newItem;
            }

            localStorage.setItem("currentCart", JSON.stringify(currentCart));
            countCartItem();

            $("#mdlProDetalle").modal("hide");

            // Ejecutar para redirigir al checkout
            $(".btnCheckout").click();
        });

        $('#inputSearch').keyup(function(){
            if(searchRequest)
                searchRequest.abort();

            searchRequest = $.ajax({
                url:`${base_url}/core/controllers/product.php`,
                method:"POST",
                data:{
                    _method:'search',
                    strQuery: $('#inputSearch').val()
                },
                success:function(data){
                    let items = '';
                    $.each(data.data, function(index, prod){
                        let img = (prod.thumbnail != "" &&  prod.thumbnail != "0") ? `${base_url}/${prod.thumbnail}` : `${base_url}/assets/img/default.jpg`;

                        items += `
                            <li>
                                <a class="dropdown-item" href="${base_url}/product/index.php?pid=${prod.id}">
                                    <img src="${img}" alt="twbs" height="32" class="rounded flex-shrink-0 me-2">
                                    ${prod.name}
                                </a>
                            </li>
                        `;
                    });

                    $(".dropdown-menu")
                        .html(items)
                        .addClass("show");
                }
            });
        });

        $('body').click(function() {
            if(searchRequest)
                searchRequest.abort();

            $(".dropdown-menu")
                .html("")
                .removeClass("show");
        });

        // Cuando el modal se inicia, se procesa la lista de productos en el carrito
        $("#mdlCheckCart").unbind().on('shown.bs.modal', function(){
            printList();
        });
    });

    function getProducts(limite) {
        productLimite = limite;

        let objData = {
            "_method":"GET",
            "limite": productLimite
        };

        $.post(`${base_url}/core/controllers/product.php`, objData, function(result) {
            $("#ListProduct").html("");
            $.each( result.data, function( index, item){
                let productCard = $(".itemClone").clone();

                if(lang == "en"){
                    productCard.find(".card-title").html(item.name);
                    productCard.find(".card-text").html(item.descriptions);
                }else{
                    productCard.find(".card-title").html(item.optional_name);
                    productCard.find(".card-text").html(item.optional_description);
                }                    

                if( (item.sale_price).length > 0 && item.sale_price > 0){
                    productCard.find(".lblOldPrice").html( formatter.format(item.price)).removeClass("d-none");
                    productCard.find(".lblPrice").html(formatter.format(item.sale_price));
                    productCard.find(".brandPrice").removeClass("d-none");
                }else{
                    productCard.find(".lblPrice").html( formatter.format(item.price) );
                }

                let img = (item.thumbnail != "" &&  item.thumbnail != "0") ? `${base_url}/${item.thumbnail}` : `${base_url}/assets/img/default.jpg`;

                productCard.find(".card-img-top").attr("src", `${img}`);
                productCard.find(".card-img-top").parent().attr("href", `${base_url}/product/index.php?pid=${item.id}`);

                productCard.find(".btnAddtocart").data("item", item);

                productCard.removeClass("d-none itemClone");
                $(productCard).appendTo("#ListProduct");
            });

            $(".btnAddtocart").unbind().click(function(){
                let currentItem = $(this).data("item"),
                    newItem = {},
                    currentCart = JSON.parse(localStorage.getItem("currentCart")),
                    config = JSON.parse(currentItem.dimensions);

                if( config=="0" || ((config[0].sizes).length == 0 && config[1].colors[0] == "") ){
                    if(!currentCart){
                        localStorage.setItem("currentCart", "{}");
                        currentCart = {};
                    }                    

                    newItem.id = currentItem.id;
                    newItem.name = currentItem.name;
                    newItem.optional_name = currentItem.optional_name;
                    newItem.descriptions = currentItem.descriptions;
                    newItem.optional_description = currentItem.optional_description;
                    newItem.thumbnail = currentItem.thumbnail;

                    if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
                        newItem.price = currentItem.sale_price;
                    }else{
                        newItem.price = currentItem.price;
                    }

                    if(currentCart[currentItem.id]){
                        currentCart[currentItem.id].qty = currentCart[currentItem.id].qty + 1;
                    }else{
                        newItem.qty = 1;
                        currentCart[currentItem.id] = newItem;
                    }

                    localStorage.setItem("currentCart", JSON.stringify(currentCart));
                    countCartItem();

                    // Ejecutar para redirigir al checkout
                    $(".btnCheckout").click();
                }else{
                    if(lang == "en"){
                        $(".lblMdlName").html(currentItem.name);
                        $(".lblDescription").html(currentItem.descriptions);
                    }else{
                        $(".lblMdlName").html(currentItem.optional_name);
                        $(".lblDescription").html(currentItem.optional_description);
                    }                        

                    if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
                        $(".lblMdlPrice").html( formatter.format(currentItem.sale_price) );
                    }else{
                        $(".lblMdlPrice").html( formatter.format(currentItem.price) );
                    }

                    $("#mdlAddtoCart").data("item", currentItem);

                    let images = JSON.parse(currentItem.images);
                    $.each( images, function( index, item){
                        $(`.img${index}`)
                            .attr("src", `${base_url}/${item}`)
                            .parent().removeClass("d-none");
                    });

                    $(".dvSizes").addClass("d-none");
                    if((config[0].sizes).length > 0){
                        $(".dvSizes").removeClass("d-none");
                        $(".toRemoves").remove();

                        $.each(config[0].sizes, function(index, item){
                            let dv = $(".chSizes").clone();

                            dv.find(".chk").val(item).attr("id", `ch${item}`);

                            if(item == "sm")
                                dv.find(".lbl").html("Small");

                            if(item == "m")
                                dv.find(".lbl").html("Medium");

                            if(item == "l")
                                dv.find(".lbl").html("Large");

                            if(item == "xl")
                                dv.find(".lbl").html("Extra large");

                            dv.find(".lbl").attr("for", `ch${item}`);
                            
                            if(index == 0)
                                dv.find(".chk").prop("checked", true);

                            dv.removeClass("d-none chSizes");
                            dv.addClass("toRemoves");
                            $(dv).appendTo(".dvSizes");
                        });
                    }

                    $(".dvColors").addClass("d-none");
                    if(config[1].colors[0] != ""){
                        $(".dvColors").removeClass("d-none");
                        $(".toRemovec").remove();

                        let items = (config[1].colors[0]).split(",");
                        $.each(items, function(index, item){
                            let dv = $(".chColors").clone();

                            dv.find(".chk").val(item).attr("id", `rd${item}`);
                            dv.find(".lbl").html(item).attr("for", `rd${item}`);

                            if(index == 0)
                                dv.find(".chk").prop("checked", true);

                            dv.removeClass("d-none chColors");
                            dv.addClass("toRemovec");
                            $(dv).appendTo(".dvColors");

                        });
                    }

                    $("#mdlProDetalle").modal("show");
                }
            });

            countCartItem();
        });
    }

    function loadCategories(){
        let objData = {
            "_method":"Get"
        };

        $.post(`${base_url}/core/controllers/category.php`, objData, function(result) {
            $("#categoriesList").html("");
            $.each( result.data, function( index, item){
                if(item.parent == 1){
                    let cat = $(".catClone").clone();

                    if(lang == "en"){
                        cat.find(".catName").html(item.name.toUpperCase());
                    }else{
                        cat.find(".catName").html(item.nameSp.toUpperCase());
                    }

                    let img = (item.thumbnail) ? `${base_url}/${item.thumbnail}` : `${base_url}/assets/img/defaultCat.jpg`;

                    cat.find(".catImage").attr("src", `${img}`);
                    cat.data("catId", item.id);

                    cat.removeClass("d-none catClone");
                    $(cat).appendTo("#categoriesList");
                }                    
            });

            $(".feature").click( function () {
                let catId = $(this).data("catId");
                window.location.href = `${base_url}/category/index.php?cid=${catId}`;
            });
        });
    }

    function printList() {
        let currentCart = JSON.parse(localStorage.getItem("currentCart"));
        $("#cartListItem").html("");

        $.each( currentCart, function( index, item){
            let listItem = $(".cartItemClone").clone(),
                size = '',
                color = '';

            if(item.size){
                if(item.size == "sm")
                    size = "Small";

                if(item.size == "m")
                    size = "Medium";

                if(item.size == "l")
                    size = "Large";

                if(item.size == "xl")
                    size = "Extra large";
            }

            if(item.color)
                color = `${item.color}`;

            let img = (item.thumbnail != "" &&  item.thumbnail != "0") ? `${base_url}/${item.thumbnail}` : `${base_url}/assets/img/default.jpg`;

            listItem.find(".prdImg").attr("src", img);

             if(lang == "en"){
                listItem.find(".prodName").html(`${item.name} ${color} ${size}`);
            }else{
                listItem.find(".prodName").html(`${item.optional_name} ${color} ${size}`);
            }

            listItem.find(".prodPrice").html(formatter.format(item.price));
            listItem.find(".intQty").val(item.qty);

            listItem.find(".contBtn").data("item", item);
            listItem.data("item", item);

            listItem.removeClass("d-none cartItemClone");
            $(listItem).appendTo("#cartListItem");
        });

        $(".btnDown").unbind().click( function () {
            let currentCart = JSON.parse(localStorage.getItem("currentCart")),
                data = $(this).parent().data("item"),
                actualQty = 0,
                itemId = data.id;

            if(data.size)
                itemId += `|s-${data.size}`;

            if(data.color)
                itemId += `|c-${data.color}`;

            actualQty = currentCart[itemId].qty;

            if(actualQty > 1){
                currentCart[itemId].qty = actualQty - 1;
                localStorage.setItem("currentCart", JSON.stringify(currentCart));
                printList();
            }
        });

        $(".btnUp").unbind().click( function () {
            let currentCart = JSON.parse(localStorage.getItem("currentCart")),
                data = $(this).parent().data("item"),
                actualQty = 0,
                itemId = data.id;

            if(data.size)
                itemId += `|s-${data.size}`;

            if(data.color)
                itemId += `|c-${data.color}`;

            actualQty = currentCart[itemId].qty;

            if(actualQty > 0){
                currentCart[itemId].qty = actualQty + 1;
                localStorage.setItem("currentCart", JSON.stringify(currentCart));
                printList();
            }
        });

        $(".btnRemove").unbind().click( function(){
            let currentCart = JSON.parse(localStorage.getItem("currentCart")),
                data = $(this).parent().data("item"),
                itemId = data.id;


            if(data.size)
                itemId += `|s-${data.size}`;

            if(data.color)
                itemId += `|c-${data.color}`;

            delete currentCart[itemId];
            localStorage.setItem("currentCart", JSON.stringify(currentCart));
            printList();
            countCartItem();
        });

        resumen();
    }

    function countCartItem(){
        let currentCart = JSON.parse(localStorage.getItem("currentCart"));
        if(currentCart)
            $(".qtyCart").html(Object.keys(currentCart).length);
    }

    function resumen(){
        let currentCart = JSON.parse(localStorage.getItem("currentCart")),
            grantotal = 0;

        $.each(currentCart, function(index, item){
            grantotal += item.price * item.qty;
        });

        $("#lblTotal").html(`<strong>${formatter.format(grantotal)}</strong>`);
    }

    function switchLanguage(lang){
        $.post(`${base_url}/assets/lang.json`, {}, function(data) {
            $(".changeLang").html('<i class="bi bi-globe2"></i> ' + data[lang]["buttonText"]);

            let myLang = data[lang]["home"];

            // Formulario principal
            $("#checkCart").html('<i class="bi bi-cart3"></i> ' + myLang.checkCart + ' <span class="badge bg-warning rounded-pill qtyCart">0</span>'); 

            $(".btnCheckout").html(myLang.btnCheckout);
            $("#inputSearch").attr("placeholder", myLang.search);
            $(".btnAddtocart").html(data[lang]["addToCart"]);
            $("#myCart").html(myLang.myCart);
            $(".btnKeepShopping").html(myLang.btnKeepShopping);
            $(".categories").html(myLang.categories);
            $(".products").html(myLang.products);

            // Page title
            document.title = myLang.pageTitle;
            if(productLimite > 0)
                getProducts(productLimite);

            loadCategories();
            countCartItem();

            myLang = data[lang]["chat"];

            $(".labelChatTitle").html(myLang.chatTitle);
            $(".lblWelcome").html(myLang.chatSubTitle);
            $("#inputName").attr("placeholder", myLang.inputName);
            $("#inputMail").attr("placeholder", myLang.inputMail);
            $("#inputInitialMessage").attr("placeholder", myLang.inputInitialMessage);
            $("#btnStart").html(myLang.btnStart);
            $("#inputNewMessage").attr("placeholder", myLang.inputNewMessage);
            $("#btnSendmessage").html(myLang.btnSendmessage);
            $(".labelFinish").html(myLang.labelFinish);
        });
    }

    function changeImage(element) {
        var main_prodcut_image = document.getElementById('main_product_image');
        main_prodcut_image.src = element.src;
    }

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    function sendMessage(strMessage, round){
        let dt = new Date(),
            time = dt.getHours() + ":" + dt.getMinutes();

        let objData = {
            message: strMessage,
            email: $("#inputMail").val(),
            name: $("#inputName").val(),
            round: round,
            _method: "POST",
            _time: time
        };

        $.post(`${base_url}/core/controllers/chat.php`, objData);

        if(round == 1){
            localStorage.setItem("cliData", JSON.stringify({name: $("#inputName").val(), mail: $("#inputMail").val()}));
            $("#inputInitialMessage").val("");
            refreshLog = setInterval(loadLog, 2500);
        }else{
            $("#inputNewMessage").val("");
        }

        loadLog();
        return false;
    }

    function loadLog(){
        let objData = {
            email: $("#inputMail").val(),
            name: $("#inputName").val(),
            _method: "GET"
        },
        oldscrollHeight = $("#chatLog")[0].scrollHeight - 20;

        $.post(`${base_url}/core/controllers/chat.php`, objData, function(result) {
            $("#chatLog").html(result);

            let newscrollHeight = $("#chatLog")[0].scrollHeight - 20;
            if(newscrollHeight > oldscrollHeight)
                $("#chatLog").animate({ scrollTop: newscrollHeight }, 'normal');

            let isClose = $("#inputClose").val();
            if(isClose){
                clearInterval(refreshLog);
                localStorage.removeItem("cliData");
            }
        }).fail(function() {
            $(".lblWelcome").removeClass("d-none");
            $("#divRegistro").removeClass("d-none");
            $("#divConversasion").addClass("d-none");
            $("#chatLog").addClass("d-none");
            $(".lblControl").addClass("d-none");

            $("#chatLog").html("");
            clearInterval(refreshLog);
            localStorage.removeItem("cliData");
        });
    }
</script>
</html>