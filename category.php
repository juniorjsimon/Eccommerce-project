<?php
require_once 'system/init.php';
include 'includes/head.php';
include 'includenav/navigation.php';
include 'includes/headerpartial.php';
include 'includes/rightbar.php';


if(isset($_GET['cat'])){
    $cat_id = sanitize($_GET['cat']);
}else{
    $cat_id='';
}
//select all from the categories table
$sql = "SELECT * FROM  products WHERE categories = '$cat_id' AND deleted = 0";
$productQuery = $db->query($sql);
$category = get_category($cat_id);

?>

            <!-- Main Content -->
            <!-- dislpay items when select a subcategory(child) -->
            <div class="col-md-8" style="padding-top: 50px; padding-bottom:80px;">
                <div class="row">
                    <h3 class="text-center"><?=$category['parent'].' '. $category['child'];?></h3>
                    <br>
                    <?php while($product = mysqli_fetch_assoc($productQuery)) : ?>
                        <div class="col-md-3">
                            <h5><?= $product['title']; ?></h5>
                            <img class="img-thumb" style="margin-left: -70px;" src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
                            <p class="list-price text-danger">List Price <s><?= money($product['list_price']);?></s></p>
                            <p class="price">Our Price: <?= money($product['price']);?></p>
                            <button type="button" class="btn btn-sm btn-info" onclick="detailsmodal(<?= $product['id']; ?>)" >Details</button>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>

<?php
include 'includes/rightbar.php';
include 'includes/footer.php';
?>
