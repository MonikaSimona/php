<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<?php
require_once('model/product_db.php');

$ids = array(1,2,3,4);

$products = array();
foreach($ids as $id){
    $product = getProduct($id);
    $products[] = $product;
}

include('home.php');
?>