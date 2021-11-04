<?php
    @session_start();
    ob_start();
?>

<style type="text/css">
    .dropdown-menu {
        width: 20rem !important;
    }
</style>

<!-- cropperCSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" integrity="sha512-w+u2vZqMNUVngx+0GVZYM21Qm093kAexjueWOv9e9nIeYJb1iEfiHC7Y+VvmP/tviQyA5IR32mwN/5hTEJx6Ng==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders</h1>
</div>

<div class="table-responsive">
    <table class="table" id="orderList"><thead class="table-light"></thead></table>
</div>

<!-- Panel lateral para ver detalles del envio -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasOrder" aria-labelledby="offcanvasWithBackdropLabel"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Order detail</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    </div>
</div>

<script type="text/javascript">
    var dataTableOrder = null,
        formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });

    $(document).ready(function(){
        var myOffcanvas = document.getElementById('offcanvasOrder');
        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
        });

        getOrders();
    });

    function getOrders(){
        let objData = {
            "_method":"GetOrders"
        };

        if (dataTableOrder != null)
            dataTableOrder.destroy();

        $.post("../core/controllers/checkout.php", objData, function(result) {
            let mypaging =  false;

            if( (result.data).length > 20 )
                mypaging = true;

            dataTableOrder = $("#orderList").DataTable({
                data: result.data.order,
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
                        data: 'order_date',
                        title: 'Order date'
                    },
                    {
                        data: 'amount',
                        title: 'Amount',
                        render: function(data, type, row) {
                            return formatter.format(data);
                        }
                    },
                    {
                        data: 'ship_price',
                        title: 'Ship price',
                        render: function(data, type, row) {
                            return formatter.format(data);
                        }
                    },
                    {
                        data: 'shipping_address',
                        title: 'Ship to',
                        render: function(data, type, row) {
                            let objAddress = JSON.parse(data),
                                strAddress = "";

                            $.each(objAddress, function(index, item){
                                strAddress += `${index}: ${item}, `
                            });

                            return strAddress;
                        }
                    },
                    {
                        data: 'payment_data',
                        title: 'Receive',
                        render: function(data, type, row) {
                            let paypalorder = JSON.parse(data),
                                str = `${paypalorder.purchase_units[0].shipping.name.full_name}`

                            return str;
                        }
                    },
                    {
                        data: 'payment_data',
                        title: 'Paypal reference',
                        render: function(data, type, row) {
                            let paypalorder = JSON.parse(data),
                                str = `${paypalorder.purchase_units[0].payments.captures[0].id}`
                            return str;
                        }
                    },
                    {
                        title: '',
                        data: null,
                        orderable: false,
                        class: "text-center",
                        width: "180px",
                        render: function ( data, type, row ) {
                            return `
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btnEditProduct me-2" title="View details" data-bs-toggle="offcanvas" data-bs-target="#offcanvasOrder"><i class="bi bi-card-checklist"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnDeleteOrder me-2" title="Cancel order"><i class="bi bi-dash-circle"></i></a>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-geo-alt"></i>
                                    </button>
                                    <form class="dropdown-menu p-4 dropdown-menu-lg-end">
                                        <div class="mb-3">
                                            <label for="inputOrderId${row.id}" class="form-label">Enter the tracking guide and package name</label>
                                            <input type="email" class="form-control" id="inputOrderId${row.id}" placeholder="#0000000, package name" autocomplete="off">
                                        </div>
                                        <button type="button" class="btn btn-success tmpSetTracking">Ok</button>
                                    </form>
                                </div>
                            `;
                        }
                    }
                ],
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