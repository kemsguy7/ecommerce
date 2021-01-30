  <?php include_once ("../resources/config.php"); ?>
 
 <?php require_once("../resources/cart_func.php"); ?>

 <?php
  	/*
 	
 	$display_name = '';
 	$item_number = '';
 	$quantity = '';
 	$amount = '';
 	*/

 	$email = "mattidungafa@gmail.com";
 	/*
 	$_SESSION['display_name'] = $display_name;
 	$_SESSION['item_number'] = $item_number;
 	$_SESSION['quantity'] = $quantity;
 	$_SESSION['amount'] = $amount;
 	*/

 	


 ?>

 
  <!DOCTYPE html>
  <html>
  <head>
  	<title>Paystack Payment Integration</title>
  	
  </head>
  <body>
  	<div class="container"> 
  		<h2> <?php echo 'Hello,'.$email; ?>  

  		<?php echo ($_SESSION['amount']);
  						 ?>

  		<?php echo ($_SESSION['item_quantity']);
  						 ?>
  		
  		<?php echo $_SESSION["item_total"];
  						 ?>		

  		<?php echo $_SESSION['display_name'];
  						 ?>
  		</h2>

  		<form>
  		<script src="https://js.paystack.co/v1/inline.js"> </script>
  		<button type="button" onclick="payWithPaystack()">Pay Now</button>
  	</form>
  	
  	<script>
	  	/*const paymentForm = document.getElementById('paymentForm');
		paymentForm.addEventListener("submit", payWithPaystack, false);*/
		function payWithPaystack() {
	    var api = "pk_test_136189608580fa22ca4a02bc495062a776f16c2b";
	    let handler = PaystackPop.setup({
	    key: api, // Replace with your public key
	    email: "<?php echo $email;  ?>",
	    amount: <?php echo $_SESSION['item_total']; ?>*100,
	    currency: "NGN",
	    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
	    // label: "Optional string that replaces customer email"
	   // item_name: "<?php// echo //'{$row["product_title"]}' ?>",
	    //: "<?php// echo {$row['product_title']} ?>",
	    metadata: {
	    	custom_fields: [
	    		{
	    			display_name: "<?php echo '$display_name' ?>",
	    			item_number: "<?php echo '$item_number' ?>",
	    			quantity: "<?php echo '$quantity' ?>", 
	    		}
	    	]
	    },
	    onClose: function(){
	      alert('Window closed.');
	    },
	    callback: function(response){
	      const referenced = response.reference;
	      window.location.href='thank_you.php?success='+referenced; //If the payment is succesfull, it redirect to the succes.php page
	    }
	  });
	  handler.openIframe();
	}
	  </script>
  </div>
  </body>
  </html>