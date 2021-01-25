<?php 
	//this script stores the helper functions

	// helper functions
	function set_message($msg) {
		if(!empty($msg)) {
			$_SESSION['message'] = $msg;
		} else { //if the session is empty
			$msg = "";
		}
	}

	function display_message() {
		if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
}
	}
	

	function redirect($location) {
		return	header("Location: $location ");
	}


	function query($sql) { // this hepler function queries the database
		global $connection;
		return mysqli_query($connection, $sql);
	}

	function confirm($result) {
		global $connection;
		if(!$result) {
			die("Query Failed " . mysqli_error($connection));
		}
	}

	function escape_string($string) {
		global $connection;
		return trim(htmlspecialchars(mysqli_real_escape_string($connection, $string)));
	}

	function fetch_array($result) {
		
		return mysqli_fetch_array($result);
	}

	//get products() 

	/*****************************************
	FRONT END  Functions*/

	function get_products() { //displays products on the home page in the public area
		$query = query("SELECT * FROM products"); //		query is a helper function defined above
		confirm($query);
		while($row = fetch_array($query)) { //fetch array is a helper function defined above

		$product = <<<DELIMETER
		<div class="col-sm-4 col-lg-4 col-md-4">
              <div class="thumbnail">
                            <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="httphttp://bootsnipp.com"></a>.</p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">15 reviews</p> 

                                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
                              
                            </div>
                        </div>
                    </div>'; 
DELIMETER;

                     echo $product;

		}
	}

	function get_categories() {
						$query = query("SELECT * FROM categories");
						confirm($query);
                		

                		while($row = mysqli_fetch_array($query)) {
$categories_links = <<<DELIMETER

	<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']} </a>

DELIMETER;
//dipsplay the categories
	echo $categories_links;            		
                		}
	}

	
	function get_products_in_cat_page() { // this function controls the get request for the category page
		$query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " "); //		query is a helper function defined above
		confirm($query);
		while($row = fetch_array($query)) { //fetch array is a helper function defined above

		$product = <<<DELIMETER
		<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3 >
                        <p>Lorem Ipsum</p>
                        	<p class="block1">
                            <a href="item.php?id={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
                        </p><br><br>
                    </div>
                </div>
            </div>

DELIMETER;

                     echo $product;

		}
	}



	function get_products_in_shop_page() { // this function controls the get request for the category page
		$query = query("SELECT * FROM products"); //		query is a helper function defined above
		confirm($query);
		while($row = fetch_array($query)) { //fetch array is a helper function defined above

		$product = <<<DELIMETER
		<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem Ipsum</p>
                        	<p class="block1">
                            <a href="cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
                        </p><br><br>  
                    </div>
                </div>
            </div>

DELIMETER;

                     echo $product;

		}
	}


	function login_user() { 
		if(isset($_POST['submit'])) {
			$username =	escape_string($_POST['username']);
			$password = escape_string($_POST['password']);

			$query = query("SELECT * FROM users WHERE username = '$username' AND password = '$password' ");
			confirm($query); 

			if(mysqli_num_rows($query) == 0 ) { //if results have not been found

				set_message("Your Password or Username are wrong");
				
				redirect("login.php");

			} else {
				//set_message("Welcome to Admin ".$username);
				redirect("admin");  
			}		
		}
	}


	function send_message() { //email function

		if(isset($_POST['submit'])) {

			$to 		= "mattidungafa@gmail.com";
			$from_name  = $_POST['name'];
			$subject	= $_POST['subject'];
			$email		= $_POST['email'];
			$message 	= $_POST['message'];

			$headers = "From: {$from_name} {$email}";

			$result = mail($to, $subject, $message, $headers);

			if(!$result) {
				set_message("Sorry we could not send your message");
				redirect("contact.php");
			} else {	
				set_message("Your Message has been sent");
				redirect("contact.php"); 
			}
		}
	}

	/*  function cart() { //this funciton controls the shopping cart

	  	//creating variables that connect that will connect to paystack
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

	  		$id = substr($name, 8, $length);
	  				  	
			    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
			    confirm($query); 


			    while($row = fetch_array($query)) {


			    $sub  = $row['product_price'] * $value; //calculating the subtotal
			    $item_quantity +=$value; // this line inside the code block prevents the session(item_quantity) from incrementing on refresh
$product = <<<DELIMETER
					         <tr>
					                <td>{$row['product_title']}</td>
					                <td>&#36;{$row['product_price']}</td>
					                <td>{$value}</td>
					                <td>&#36;{$sub}</td> 
					                <td><a class='btn btn-warning' href="cart.php?remove={$row['product_id']}"><span class='glyphicon glphicon-minus'> </span></a> <a class ='btn btn-success' href="cart.php?add={$row['product_id']}"><span class='glyphicon glphicon-plus'> </span></a>  

					                <a class ='btn btn-danger' href="cart.php?delete={$row['product_id']}"><span class='glyphicon glphicon-remove'></span></a>  </td>
					   
					            </tr>
					           		
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

    }
    $_SESSION['item_total'] = $total += $sub;   //subtotal count  - counts the subtotal
     $_SESSION['item_quantity'] = $item_quantity;  //item count - counts the total number of items in the cart
  }
		}
}

}*/
	/*********************** BACK END FUNCTIONS ********************************/
?>  