</div><br><br>

    <footer class="text-center" id="footer">&copy; Copyright 2018 88riot</footer>

    <script>
    //update sizes function
	    function updateSizes() {
		  var sizeString = '';
		  for(var i = 1; i <= 12; i++) {
			if(jQuery('#size'+i).val() != '') {
				sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+','; // find the value of size and qty:
                                                                             // example output: small:7,medium:8,
			  }
		  }
	   	jQuery('#sizes').val(sizeString);// pass it to the product sec
	     }
        function updateQuantity(){
            var quantityString = '';
            quantityString+=$('#quantity').val();
            $('#qty_prev').val(quantityString);

        }

        //ajax request to the child category
        function get_child_options(selected){
            if(typeof selected === 'undefined'){
                var selected = '';
            }

            var parentID = $('#parent').val();
            $.ajax({
                url: '/88riot/admin/parsers/child_categories.php',
                type: 'POST',
                data: {parentID: parentID, selected: selected},
                success: function(data){
                    $('#child').html(data);
                },
                error: function(){alert("Something went wrong with the child options.")},
            });
        }
        $('select[name="parent"]').change(function(){
            get_child_options();
        });
    </script>
    </body>
</html>
