<?php

  function cart() { //this function controls the shopping cart
  		@session_start();
	  	//creating variables for the hidden input names
	  	$total = 0;
	  	$item_quantity = 0;
	  	$item_name = 1;
	  	$item_number = 1;
	  	$amount = 1;
	  	$quantity = 1;

	  	

	  	foreach ($_SESSION as $name => $value) { 
	  		if ($value > 0) {
		  		if(substr($name, 0 , 8) == "product_") {

			  		// pull out the id of the session by finding the length
			  		$length = strlen($name - 8); //find out the  length of the string

			  		$id = substr($name, 8 , $length);
			  				  	
					$query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
					confirm($query); 


					    while($row = fetch_array($query)) {

					    	//Assigning the sessions in the variables to be used in the payment processing page (pay.php)
			 					$_SESSION['display_name'] = $row["product_title"];
			 					$_SESSION['item_number'] = $row["product_id"];
			 					$_SESSION['quantity'] = $value;
			 					$_SESSION['amount'] = $row["product_price"];


							    $sub  = $row['product_price'] * $value; //calculating the subtotal
							    $item_quantity +=$value; // this line inside the code block prevents the session(item_quantity) from incrementing on refresh

							    //Assign the display image function to a variable
							    $product_image = display_image($row['product_image']);

$product = <<<DELIMETER
					         <tr>
					                <td>{$row['product_title']}<br>
					                		<img width='100' src='../resources/{$product_image}'>
					                </td>
					                <td>NGN {$row['product_price']}</td>
					                <td>{$value}</td>
					                <td>NGN {$sub}</td> 
					                <td><a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glphicon-minus'> </span></a> <a class ='btn btn-success' href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glphicon-plus'> </span></a>  

					                <a class ='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glphicon-remove'></span></a>  </td>
					   
					            </tr>

					            		<!-- This hidden field holds the values that are to be sent to paystack -->
							            <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                         	 		<input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                          			<input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                          			<input type="hidden" name="quantity_{$quantity} " value="{$value}">
						            

						            	<small> Price: N500 </small>
						            	
					            
					            
DELIMETER;
echo $product;

//incrementing the values sent to paystack by 1 every time it goes around
$item_name++;
$item_number++;
$amount++;
$quantity++;


	$_SESSION['display_name'] = $row["product_title"];
			 					$_SESSION['item_number'] = $row["product_id"];
			 					$_SESSION['quantity'] = $value;
			 					$_SESSION['amount'] = $sub;

    }



    $_SESSION['item_total'] = $total += $sub;   //subtotal count  - counts the subtotal
     $_SESSION['item_quantity'] = $item_quantity;  //item count - counts the total number of items in the cart
  }
		}
}

}




  function process_transaction() { //This function controls the report
  		@session_start();
  		global $connection;

	  	if(!$_GET['success']) {
		    header("Location: index.php");
		    exit;
	    } else { //IF Payment is succesful
	       $reference = $_GET['success'];
	     //  $display_name = $_SESSION['display_name'];
	       $quantity = $_SESSION['item_quantity'];
	       $amount = $_SESSION['item_total'];
	       $order_transaction = $reference;
	       $status = 'completed';
	        echo "Succesfully paid";
	   


	 

	  	//creating variables for the hidden input names
	  	$total = 0;
	  	$item_quantity = 0;
	    	

	  	foreach ($_SESSION as $name => $value) { 
	  		if ($value > 0) {
		  		if(substr($name, 0 , 8) == "product_") {

			  		// pull out the id of the session by finding the length
			  		$length = strlen($name - 8); //find out the  length of the string
			  		$id = substr($name, 8 , $length);
			  		$status = 'completed';
			  		$date = date_create()->format('Y-m-d H:i:s');


				   $send_order = query("INSERT INTO orders (order_amount, order_transaction_tx, order_status, order_date) 
				    VALUES('$amount','$order_transaction', '$status','$date')");

				   //get the last inserted id
				   $last_id = last_id(); //last_id() function predefined in the functions.php script
			 //confirm(query);
				  if($send_order) {
				     echo "Order Query inserted succesfully";
				      //if the  session order has been executed succesfully, destroy the session to prevent resubmission to the database
				     unset($quantity);
				     unset($amount);
				     
				  } else {
				    echo "Failed to insert " . mysqli_error($connection);
				  }



			  				  	
					$query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
					confirm($query); 


					    while($row = fetch_array($query)) {
					    		$product_price = $row['product_price'];
					    		$product_quantity = $row['product_quantity'];
					    	    $product_title = $row['product_title'];
							    $sub  = $row['product_price'] * $value; //calculating the subtotal
							    $item_quantity +=$value; // this line inside the code block prevents the session(item_quantity) from incrementing on refresh


 

							     $insert_report = query("INSERT INTO reports (product_id, order_id, product_price, product_title, product_quantity) VALUES('$id','$last_id','$product_price','$product_title', '$product_quantity')");

							     confirm($insert_report);

    }                                                                                                      

  $total += $sub;   //subtotal count  - counts the subtotal
  echo $item_quantity;  //item count - counts the total number of items in the cart
  }
		}
}
}
session_destroy();
}
	?>