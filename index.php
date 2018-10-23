<?php
require_once 'system/init.php';
include 'includes/head.php';
include 'includenav/navigation.php';
include 'includes/slideshow.php';
include 'includes/leftbar.php';


$sql = "SELECT * FROM  products WHERE featured = 1";
$featured = $db->query($sql);
?>


            <!-- Main Contents of featured products -->
            <!-- retrieve featured products from database and display -->
            <div class="col-md-8" style="padding-top: 50px; padding-bottom:80px;" >
                <div class="row">
                    <h4 class="text-center">Featured Products</h4>
                    <?php while($product = mysqli_fetch_assoc($featured)) : ?>
                        <div class="col-md-3">
                            <h5><?= $product['title']; ?></h5>
                            <img class="img-thumb" style="margin-left: -70px;" src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
                            <p class="list-price text-danger">List Price <s><?= money($product['list_price']);?></s></p>
                            <p class="price">Our Price: <?= money($product['price']);?></p>
                            <button type="button" class="btn btn-sm btn-info" style="margin-bottom: 80px;" onclick="detailsmodal(<?= $product['id']; ?>)" >Details</button>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>

<?php
include 'includes/rightbar.php';
include 'includes/footer.php';
?>
