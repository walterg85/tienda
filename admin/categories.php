<?php
    session_start();
    ob_start();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="input-group me-2">
            <input type="text" class="form-control" placeholder="Category name" aria-label="Category name" aria-describedby="btnAddCategory">
            <button class="btn btn-outline-secondary" type="button" id="btnAddCategory">Add Category</button>
        </div>
    </div>
</div>

<table class="table" id="categoryList"><thead class="table-light"></thead></table>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>