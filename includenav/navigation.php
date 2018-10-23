

  <!--  <link rel="stylesheet" href="src/css/font-awesome-4.6.3/css/font-awesome.min.css">-->

    <link type="text/css" rel="stylesheet" href="src/css/materialize.min.css"  media="screen,projection"/>
     <!--animate css-->
    <link rel="stylesheet" href="src/css/animate.css-master/animate.min.css">
    <!-- My own style-->
    <link rel="stylesheet" href="src/css/style.css">

    <?php
    	$sql = "SELECT * FROM categories WHERE parent = 0";
    	$pquery = $db->query($sql);
    ?>
    <body>
<div class="navbar navbar-fixed-top" >
 <nav class="navwhite">
   <div class="nav-wrapper nav-wrapper-2 container white">
   <ul class="left show-on-med-and-down">
     <li><a class="dark-text" href="index.php">HOME</a></li>
      <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
        <?php
        $parent_id = $parent['id'];
        $sql2 = "SELECT * FROM categories WHERE Parent = '$parent_id'";
        $cquery = $db->query($sql2);
        ?>

          <!--Menu Items-->
    <li  class="dropdown">
       <a href="#" class="dropdown-toggle dark-text" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $parent['category']; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
              <li> <a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
              <?php endwhile; ?>
          </ul>
     </li>
              <?php endwhile; ?>


   </ul>



   <ul  class="right show-on-med-and-down">
     <li><a href="admin/login.php" class="waves-effect waves-light btn button-rounded">Sign In</a></li>
     <li><a href="cart.php" class="dark-text baskett"><i class="material-icons">shopping_cart</i>
       <span class="badge <?php if(!isset($_SESSION['item']) OR $_SESSION['item'] == 0) echo'hide'; ?>"><?= $_SESSION['item']; ?></span></a></li>
   </ul>

 </div>
 </nav>
</div>
</body>

</html>
