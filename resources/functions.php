<?php 
	//this script stores the helper functions
	
	$upload_directory = 'uploads';
	// helper functions

	function last_id() { // This function generates and returns the last inserted id

		global $connection;

		return mysqli_insert_id($connection);

	}

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

		$product_image = display_image($row['product_image']);

		$product = <<<DELIMETER
		<div class="col-sm-4 col-lg-4 col-md-4">
              <div class="thumbnail">
                            <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
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

		$product_image = display_image($row['product_image']);

		$product = <<<DELIMETER
		<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem Ipsum</p>
                        	<p class="block1">
                            		<a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
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

		//Image functionality
		$product_image = display_image($row['product_image']);

		$product = <<<DELIMETER
		<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img height="250" src="../resources/{$product_image}" alt="Product Image">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem Ipsum</p>
                        	<p class="block1">
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-default">More Info</a>
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






	/*********************** BACK END FUNCTIONS ********************************/
	function display_orders() {

		$query = query("SELECT * FROM orders");
		confirm($query);

		while($row = fetch_array($query)) {

			$orders = <<< DELIMETER

			<tr class="table table-stripped"> 
				<td>{$row['order_id']} </td>
				<td>{$row['order_amount']} </td>
				<td>{$row['order_transaction_tx']} </td>
				<td>{$row['order_date']} </td>
				<td>{$row['order_status']} </td>
				<td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a> </td>
				

			</tr>
DELIMETER;

echo $orders;
		}
	}

	/*************************************   ADMIN PRODUCTS PAGE   *********************************/


	function display_image($picture) {

		global $upload_directory ;
		return "$upload_directory" . DS . $picture;


	}

	function get_products_in_admin() {
			$query = query("SELECT * FROM products"); //		query is a helper function defined above
		confirm($query);
		while($row = fetch_array($query)) { //fetch array is a helper function defined above

		$category = show_product_category_title($row['product_category_id']);

		$product_image = display_image($row['product_image']);

		$product = <<<DELIMETER
		
				<tr>
		            <td>{$row['product_id']}</td>
		            <td style="height:50px">{$row['product_title']} <br>
		             <a href="index.php?edit_product&id={$row['product_id']}"> <img width="100" height="20" src="../../resources/{$product_image}" class="img-responsive" height="20px" alt=""> </a>
		            </td>
		            <td>{$category}</td>
		            <td>{$row['product_price']}</td>
		             <td>{$row['product_quantity']}</td>
		             <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a> </td>
       			</tr>
 
DELIMETER;

                     echo $product;

		}
	}

	function show_product_category_title($product_category_id) { //This function shows the product category title on the product page
		$category_query = query("SELECT * FROM categories WHERE cat_id = {$product_category_id} ");
		confirm($category_query);

		while ($category_row = fetch_array($category_query)) {
			
			return $category_row['cat_title'];
		}

	}

	/***************************************** ADDING PRODUCTS IN ADMIN ************************************/

	function add_product() {

		//if we are getting any data from the form
		if(isset($_POST['publish'])) {

			$product_title 	=	escape_string($_POST['product_title']);
			$product_category_id 	=	escape_string($_POST['product_category_id']);
			$product_price 	=	escape_string($_POST['product_price']);
			$product_description 	=	escape_string($_POST['product_description']);
			$product_short_desc 	=	escape_string($_POST['product_short_desc']);
			$product_quantity 	=	escape_string($_POST['product_quantity']);
			$product_image 	=	($_FILES['file']['name']); // image form name
			$image_temp_location 	=	($_FILES['file']['tmp_name']); //temporary location name
/*
			//Uploading image processing
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			//Check if image file is an acctual image or fake image
			
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}

				// Check if file exists already
				if(file_exists($target_file)) {
					echo "Sorry, file already exists.";
					$uploadOk = 0;
				}

				//Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" &&$imageFileType != "png") {
					echo "Sorry, only JPG, JPEG, PNG and GIF files are allowed.";
					$uploadOk = 0;
				}
			
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Sorry your file was not uploaded.";
					//if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($image_temp_location, $target_file)) {
						echo " The file ". htmlspecialchars(basename($_FILES['file']['name'])). " has been uploaded.";
					} else {
						echo "Sorry there was an error uploading file";
					}
				}*/

			move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS .  $product_image);

  






 


			$query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_image) VALUES ('$product_title','$product_category_id','$product_price','$product_description','$product_short_desc','$product_quantity','$product_image')");
			$last_id  =  last_id();
			confirm($query); //confirm the query
			set_message("New Product with id{$last_id} Just Added"); //success message
			redirect("index.php?product");
			
		}
	}


	function show_categories_add_product() {
		$query = query("SELECT * FROM categories");
		confirm($query);
                		

        while($row = mysqli_fetch_array($query)) {
			$categories_options = <<<DELIMETER
			<option value="{$row['cat_id']}">{$row['cat_title']} </option>

DELIMETER;
 
echo $categories_options;            		
                		}
	}


/************************************************  *************************************/
?>  