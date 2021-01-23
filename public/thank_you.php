<!-- Configuration-->

<!-- This script echoes a thak you after products have been bought -->


<?php require_once("../resources/config.php"); ?>
<?php require_once("cart.php"); ?>
<!-- Header-->
<?php include(TEMPLATE_FRONT .  "/header.php");?>


<?php 

//get the staatus of the order and the transaction id
if(isset($_GET['tx'])) { //tx for transaction

  $amount =$_GET ['amt'];
  $currency = $_GET['cc'];
  $transaction = $_GET['tx'];
  $status = $_GET['st'];

  $query = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency) VALUES('{$amount}',
  '{$currency}','{$transaction}', '{$status}')");

  confirm($query);
 
} else {

  redirect("index.php");
}

?>


    <!-- Page Content -->
    <div class="container">

      <h1 class="text-center"> Thank You </h1>

    </div>




 </div><!--Main Content-->

</div><!-- End of container -->
<?php include(TEMPLATE_FRONT .  "/footer.php");?>
