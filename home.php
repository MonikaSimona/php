<?php include 'view/header.php';?>

<main>
<h1>Производи на неделата</h1>

<table class="table">
    <?php foreach ($products as $product) :
        
        $list_price = $product['productPrice'];
        $description = $product['productDescription'];
              
    ?>
        <tr>
            <td  >
                <img src="images/<?php echo htmlspecialchars($product['productCode']); ?>_s.png"
                     alt="&nbsp;">
            </td>
            <td>
                <p>
                    <a href="products?product_id=<?php echo
                           $product['productID']; ?>">
                        <?php echo htmlspecialchars($product['productName']); ?>
                    </a>
                </p>
                <p>
                    <b>Your price:</b>
                    $<?php echo number_format($unit_price, 2); ?>
                </p>
                <p>
                    <?php echo $first_paragraph; ?>
                </p>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>

</main>