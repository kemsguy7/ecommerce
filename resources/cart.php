<!-- Configuration-->

<?php require_once("config.php"); ?>
<?php require_once("functions.php"); ?> 

<?php 
  if(isset($_GET['add'])) { 

    $query = query("SELECT * FROM products WHERE product_id =" . escape_string($_GET['add']) . " ");
    confirm($query);

    while($row = fetch_array($query)) {


      if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) { //if the number of items in the database is not equal to that of the product session, 
        // increase the products

        $_SESSION['product_' . $_GET['add']] +=1;
        redirect("../public/checkout.php");  

      } else {
        //if the number of items available has been exxceeded and the user keeps on incrementing, 
        //print an error message telling the user the number of products in the database
        set_message("We only have " . $row['product_quantity'] . " " . $row['product_title'] . " available");
        redirect("../public/checkout.php");
      }

    }

  //  $_SESSION['product_' . $_GET['add']] +=1; incrementing the quantity on every click
  }  

  if(isset($_GET['remove'])) { //remove functionality

    $_SESSION['product_' . $_GET['remove']]--; // if the remove button is clicked, remove 1 product at a time on every click

    if($_SESSION['product_' . $_GET['remove']] < 1) {

      //if the number of items is less than 1, unset the shopping cart an all
      unset($_SESSION['item_total']);
      unset($_SESSION['item_quantity']);
      //end of unset shopping cart

      redirect("../public/checkout.php");
      unset($_SESSION['item_total']);  
      unset($_SESSION['item_quantity']);

    } else {
      redirect("../public/checkout.php");
    }

  }


  if(isset($_GET['delete'])) { //delete functionality
    $_SESSION['product_' . $_GET['delete']] = '0'; //if the delete button is clicked, empty the shopping cart by setting it to 0, unset the subtotal and item_quantity
    //unset the sessions
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);

    redirect("../public/checkout.php");


  }


?>