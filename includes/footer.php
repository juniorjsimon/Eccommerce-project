
  <link rel="stylesheet" href="src/css/style.css">
</div><br><br>
            <div class="col s12 m6">
              <div class="container-fluid about" id="about">
                <div class="container">
                  <div class="row">
                    <div class="col s12 m6">
                      <div class="card">
                        <div class="card-image">
                          <img src="slideimages/slide-image-3.jpg" alt="">
                        </div>
                      </div>
                    </div>


                      <h3 class="Title">About Us</h3>
                      <div class="divider"></div>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                        sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatur</p>
                      </div>

                    </div>
                  </div>
                </div>

                <!--Style shett to us pay pal icon fa fa-cc-paypal and social media icons-->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                	<section id="footer-bar">
                		<div class="row">
                			<div class="col-md-3">
                				<h2>Navigation</h2>
                				<ul class="nav">
                					<li><a href="./index.html">Homepage</a></li>
                					<li><a href="./about.html">About Us</a></li>
                					<li><a href="./contact.html">Contac Us</a></li>
                					<li><a href="./cart.html">Your Cart</a></li>
                					<li><a href="./register.html">Login</a></li>
                				</ul>
                			</div>


                			<div class="col-md-3">
                				<h2>Store</h2>
                				<ul class="nav">
                				<li><a class="glyphicon glyphicon-map-marker">88Riot</a></li>
                				<li><a class="glyphicon glyphicon-phone">(701)913-0652</a></li>
                				<li><a class="glyphicon glyphicon-envelope">88Riot@gmail.com</a></li>
                				<h2>We accept</h2>
                			<li><a class="fa fa-cc-paypal"> Paypal</a></p>
                			<br>
                		</ul>
                			</div>

                				<div class="col-md-3">
                					<h2>Contact</h2>
                        <p>Questions? Go ahead.</p>
                        <form action="/action_page.php" target="_blank">
                          <p><input type="text" class="form-control" id="name" placeholder="Name" name="Name" required></p>
                          <p><input type="email" class="form-control" id="email" placeholder="Email" name="Email" required></p>
                          <p><input type="text" class="form-control" id="subject" placeholder="Subject" name="Subject" required></p>
                          <p><input type="text" class="form-control" id="message" placeholder="Message" name="Message" required></p>
                          <button type="submit" class="btn btn-default">Send</button>
                        </form>
                				</div>

                				<div class="col-md-3">
                					<h2>Social media</h2>
                			  <div class="w3-xlarge w3-section">
                          <i class="fa fa-facebook-official w3-hover-opacity" style="font-size:24px"></i>
                          <i class="fa fa-instagram w3-hover-opacity" style="font-size:24px"></i>
                          <i class="fa fa-twitter w3-hover-opacity" style="font-size:24px"></i>
                          <i class="fa fa-linkedin w3-hover-opacity" style="font-size:24px"></i>
                      </div>
                			</div>
                			</div>
                	</section>


    <footer class="footer navbar-inverse" id="footer">&copy; Copyright 2018 88Riot</footer>



    <script>
        $(window).scroll(function(){
            var vscroll = $(this).scrollTop();
            $('#logotext').css({
                "transform": "translate(0px, "+vscroll/2+"px)"
            });

            $('#back').css({
                "transform": "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
            });

            $('#fore').css({
                "transform": "translate(0px, -"+vscroll/2+"px)"
            });
        });



        function detailsmodal(id){
           var data = {"id" : id};
           $.ajax({
             url : '/88riot/includes/detailsmodal.php',
             method : "post",
             data : data,
             success: function(data){
               $('body').append(data);
               $('#details-modal').modal('toggle');
             },
             error: function(){
               alert("Something went wrong!");
             }
            });
        }

        //update cart function
        function updateCart(mode,edit_id,edit_size){
          var data = {"mode" : mode, "edit_id" : edit_id, "edit_size": edit_size};
          jQuery.ajax({
            url : '/88riot/admin/parsers/update_cart.php',
            method : "post",
            data : data,
            success : function(){location.reload();},
            error : function(){alert("There was an error");},
          });
        }

        //add to cart function
        function add_to_cart(){
          jQuery('#modal_errors').html("");
          var size = jQuery('#size').val();
          var quantity = jQuery('#quantity').val();
          var available = jQuery('#available').val();
          var error = '';
          var data = jQuery('#add_product_form').serialize();
          if (size ==''||  quantity == '' || quantity == 0){
            error += '<p class= "text-danger text-center">You must choose a size and quantity.</p>';
            jQuery('#modal_errors').html(error);
            return;
          }else if(quantity > available){
            error += '<p class= "text-danger text-center">There are only '+available+' available.</p>';
            jQuery('#modal_errors').html(error);
            return;
        }else{
          jQuery.ajax({
            url : '/88riot/admin/parsers/add_cart.php',
            method : 'post',
            data : data,
            success : function(){
              location.reload();
            },
            error : function(){alert("something went wrong");}
          });

        }
        }
    </script>
    </body>
</html>
