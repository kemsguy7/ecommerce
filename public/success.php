 <?php require_once("../resources/config.php"); ?>
<?php require_once("cart.php"); ?>
<!-- Header-->
<?php include(TEMPLATE_FRONT .  "/header.php");?> 
<?php 

//This script handles the function after payment has been successfully made
	
	session_start();
	// if the payment is not successfull, redirect
	if(!$_GET['successfullypaid']) {
		header("Location: index.php");
		exit;
	} else {
		$reference = $_GET['successfullypaid'];
	} 
	$first_name = $_SESSION['first_name'];
	$last_name = $_SESSION['last_name'];
	$phone = $_SESSION['phone_number'];
	$email = $_SESSION['email'];
	$amount = $_SESSION['amount'];
	$product_name = $_SESSION['product_name'];

	//Insert the code into the database
	$sql = "INSERT INTO orders(first_name, last_name, phone, email, product_name, price, reference) VALUES ('$first_name', 
	'$last_name', '$phone', '$email','product_name', '$amount', '$reference') ";
	if($stmt = $pdo->prepare($sql)) {
		//Bind parameters
		$stmt->bindParam(':first_name',$first_name, PDO::PARAM_STR);
		$stmt->bindParam(':last_name',$last_name, PDO::PARAM_STR);
		$stmt->bindParam(':phone',$phone, PDO::PARAM_STR);
		$stmt->bindParam(':email',$email, PDO::PARAM_STR);
		$stmt->bindParam(':product_name',$product_name, PDO::PARAM_STR);
		$stmt->bindParam(':price',$price, PDO::PARAM_STR);
		$stmt->bindParam(':reference',$reference, PDO::PARAM_STR);
		//Attempt to execute
		if ($stmt->execute()) {
			echo "<script>alert('Your Payment was successfull, click ok to continue!.') </script>";
			//Prevent a resubmission 
			session_unset();
			session_destroy();
		} else {
			die("Sorry, something went wrong");
		}
		unset($stmt);
		//Close the connection
		unset($pdo); 
	}
?>
  <!DOCTYPE html>
  <html>
  <head>
  	<title>Paystack Payment Integration</title>
  	<link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  	<div class="container"> 
  		<h2> $first_name, your payment went through. You can download your ebook by clicking on the download button below!. </h2>

  		<table> 
  			<tr> 
  				<th>Summary  </th>

  			</tr>
  			<tr> 
  				<td>First Name : <?php echo $first_name; ?> </td>
  			</tr>
  			<tr> 
  				<td>Last Name : <?php echo $last_name; ?> </td>
  			</tr>
  			<tr> 
  				<td>Phone : <?php echo $phone; ?>  </td>
  			</tr>
  			<tr> 
  				<td>Price : <?php echo $amount; ?> </td>
  			</tr>
  			<tr> 
  				<td>Product Name : <?php echo $product_name; ?> </td>
  			</tr>
  			<tr> 
  				<td>Reference Code : <?php echo $reference; ?>  </td>
  			</tr>
  			<tr> 
  				<td><a href="#"> Download Now </a> </td>
  			</tr>

  		</table>
  	</div>
  </body>
  </html>