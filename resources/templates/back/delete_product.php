<?php

//This script deletes the products from the database from the database 
	require_once("../../config.php");

	if(isset($_GET['id'])) {

		$query = query("DELETE FROM products WHERE product_id = "  . escape_string($_GET['id']) . " ");
		confirm($query);

		set_message("Product Deleted Succesfully");
		redirect("../../../public/admin/index.php?product"); //redirec 3 folders back to the orders page in the admin panel

	} else {
		redirect("../../../public/admin/index.php?product");
	}
?>