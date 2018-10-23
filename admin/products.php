<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/88riot/System/init.php';
if (!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/leftbar.php';

//delete product
if (isset($_GET['delete'])){
  $id = sanitize($_GET['delete']);
  $db->query("UPDATE products SET Deleted = 1 WHERE id = '$id'");
  header('Location: products.php');
}

if (isset($_GET['add'])) {
  $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");//select everything in brand table
  $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");//select everything in categories table
  $sizesArray = array();

  if ($_POST) {
    $title = sanitize($_POST['title']);
    $brand = sanitize($_POST['brand']);
    $categories = sanitize( $_POST['child']);
    $price = sanitize($_POST['price']);
    $list_price = sanitize($_POST['list_price']);
    $sizes = sanitize($_POST['sizes']);
    $description = sanitize($_POST['description']);
    $dbpath = '';
    $errors = array();
    if (!empty($_POST['sizes'])) {
      $sizeString = sanitize($_POST['sizes']);
      $sizeString = rtrim($sizeString,',');
      $sizesArray = explode(',',$sizeString);
      $sArray = array();
      $qArray = array();
      foreach ($sizesArray as $ss) {
        $s = explode(':',$ss);
        $sArray[] = $s[0] ;
        $qArray[] = $s[1] ;
      }

    }else{$sizeArray = array();}
    $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
    foreach($required as $field){
      if($_POST[$field] == ''){
        $errors[] = 'All Fields With an Astrisk are required. ';
        break;
      }
    }

    if($_FILES['photo']['name'] != '') {
      $photo = $_FILES['photo'];
      $name = $photo['name'];
      $nameArray = explode('.',$name);
      $fileName = $nameArray[0];
      $fileExt = $nameArray[1];
      $mime = explode('/',$photo['type']);
      $mimeType = $mime[0];
      $mimeExt = $mime[1];
      $tmpLoc = $photo['tmp_name'];
      $fileSize = $photo['size'];
      $allowed = array('png','jpg','jpeg','gif');
      $uploadName =md5(microtime()).'.'.$fileExt;
      $uploadPath = BASEURL.'Productimages/'.$uploadName;
      $dbpath = '/88riot/Productimages/'.$uploadName;
      if ($mimeType != 'image') {
        $errors[] = 'The File must be an image.';
      }
      if (!in_array($fileExt, $allowed)) {
        $errors[] = 'The file extension must be png, jpg, jpeg, or gif.';
      }
      if ($fileSize > 15000000) {
        $errors[] ='The file size must be under 15 MB.';
      }
      if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
        $errors[] = 'File extension does not match the file.';
      }
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //upload file and insert into database
      move_uploaded_file($tmpLoc,$uploadPath);
      $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`)
      VALUES ('$title','$price','$list_price','$brand','$categories','$sizes','$dbpath','$description')";
      $db->query($insertSql);
      header('Location: products.php');
    }
  }
  ?>
  <h2 class="text-center">Add A New Product</h2><hr>
  <form action="products.php?add=1" method="POST" enctype="multipart/form-data">
    <div class="form-group col-md-3">
      <label for="title">Title*:</label>
      <input type="text" name="title" class="form-control"id="title" value="<?=((isset($_POST['title']))?sanitize($_POST['title']):'')?>">
    </div>
    <div class="form-group col-md-3">
      <label for="brand">Brand*:</label>
      <select class="form-control" id="brand" name="brand">
        <option value="" <?=((isset($_POST['brand']) && $_POST['brand'] == '')?' selected':'');?>></option>
        <?php while($brand = mysqli_fetch_assoc($brandQuery)): ?>
          <option value="<?=$brand['id'];?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id'])?' selected':'');?>><?=$brand['brand'];?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="form-gorup col-md-3">
      <label for="parent">Parent Category*:</label>
      <select class="form-control" id="parent" name="parent">
        <option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':'');?>></option>
        <?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
          <option value="<?=$parent['id'];?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?' select':'');?>><?=$parent['category'];?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="child">Child Category*:</label>
      <select id="child" name="child" class="form-control">
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="price">Price*:</label>
      <input type="text" name="price" id="price" class="form-control" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'');?>">
    </div>
    <div class="form-group col-md-3">
      <label for="price">List Price:</label>
      <input type="text" name="list_price" id="list_price" class="form-control" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'');?>">
    </div>
    <div class="form-group col-md-3">
      <label>Quantity & Sizes*:</label>
      <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
    </div>
    <div class="form-group col-md-3">
      <label for="sizes">Sizes & Quantity Priview</label>
      <input type="text" class="form-control" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:'');?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="photo">Product Photo</label>
      <input type="file" name="photo" id="photo" class="form-control">
    </div>
    <div class="from-group col-md-6">
      <label for="description">Description:</label>
      <textarea name="description" id="description" class="form-control" rows="6"><?=((isset($_POST['Descrition']))?sanitize($_POST['description']):'');?></textarea></div>
      <div class="form-group pull-right">
        <input type="submit" value="Add Product" class="form-control btn btn-success">
      </div><div class="clearfix"></div>

    </form>
    <!-- Modal -->
    <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="sizesModalLabel">Size &Quantity</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <?php for($i=1;$i <= 12;$i++): ?>
                <div class="form-group col-md-4">
                  <label for="size<?=$i;?>">Size:</label>
                  <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
                </div>
                <div class="form-group col-md-2">
                  <label for="qty<?=$i;?>">Quantity:</label>
                  <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
                </div>
              <?php endfor; ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
          </div>
        </div>
      </div>
    </div>

  <?php }else{
    $sql = "SELECT * FROM Products WHERE Deleted = 0";
    $presults = $db->query($sql);

    if(isset($_GET['featured'])) {
      $id = (int)$_GET['id'];
      $featured = (int)$_GET['featured'];
      $db->query("UPDATE products SET featured = '{$featured}' WHERE id = '{$id}'");
      header("Location: products.php");
    }
    ?>
    <h2 class="text-center">Products</h2>
    <a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
    <hr>
    <table class="table table-sm table-hover ">
      <thead-dark>
        <th></th>
        <th>Product</th>
        <th>Price</th>
        <th>List Price</th>
        <th>Category</th>
        <th>Image</th>
        <th>featured</th>
        <th>Sold</th>
      </thead>
      <tbody>
        <?php
        while($product = mysqli_fetch_assoc($presults)):
          $childID = $product['categories'];
          $catSql = "SELECT * FROM categories WHERE id = '$childID'";
          $result = $db->query($catSql);
          $child = mysqli_fetch_assoc($result);

          $parentID = $child['parent'];
          $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
          $presult = $db->query($pSql);
          $parent = mysqli_fetch_assoc($presult);
          $category = $parent['category'].' -- '.$child['category'];
          ?>
          <tr>
            <td>

              <a href="products.php?delete= <?php echo $product ['id']; ?>" class = "btn btn-default"><span class="glyphicon glyphicon-remove">Delete</span></a>
            </td>
            <td><?php echo $product['title']; ?></td>
            <td><?php echo money($product['price']); ?></td>
            <td><?php echo money($product['list_price']); ?></td>
            <td><?php echo $category; ?></td>
            <td><img class="img-thumb" style="width:90px; height:100px" src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>"></td>
            <td><a href="products.php?featured=<?php echo (($product['featured'] == 0)?'1' : '0'); ?>&id=<?php echo $product['id']; ?>" class=" btn btn-xs btn-default ">
              <span class ="glyphicon glyphicon-<?php echo (($product['featured'] == 1)?'minus': 'plus');?>"></span>
            </a>&nbsp; <?php echo (($product['featured'] == 1)?'featured Product' : ''); ?></td>
            <td>0</td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>


    <script>
    jQuery ('document').ready(function(){
      get_child_options('<?= $category; ?>');
      updateSizes();
    });
  </script>

<?php }
include 'includes/leftbar.php';
include 'includes/footer.php' ?>
