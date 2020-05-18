<?php include 'view/header.php';?>
<?php include 'view/sidebar.php'; ?>

<main>
<h1>Производи на неделата</h1>

<table class="table">
    <?php foreach ($products as $product) :
        
        $price = $product->getPrice();
        $description = $product->getDescription();
              
    ?>
        <tr>
            <td  >
                <img src="images/<?php echo htmlspecialchars($product->getCode()); ?>.jpg"
                     alt="&nbsp;" width="400" height="400">
            </td>
            <td>
                <p>
                    <a href="products?product_id=<?php echo
                           $product->getID(); ?>">
                        <?php echo htmlspecialchars($product->getName()); ?>
                    </a>
                </p>
                <p>
                    <b>Цена:</b>
                    <?php echo number_format($price, 2); ?> ден.
                </p>
                <p>
                    <!--<?php echo $first_paragraph; ?>-->
                    <?php echo htmlspecialchars($description); ?>
                </p>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>


<?php include 'view/footer.php';?>