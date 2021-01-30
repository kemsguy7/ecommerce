<!-- Configuration-->

<!-- This script echoes a thak you after products have been bought -->
<?php @session_start(); ?> 

<?php require("../resources/config.php"); ?>

<!-- Header-->
<?php include(TEMPLATE_FRONT .  "/header.php");?>


<?php 

//report function defied in the cart_func.php page
  process_transaction();

?>


    <!-- Page Content -->
    <div class="container">

      <h1 class="text-center"> Thank You </h1>

    </div>




 </div><!--Main Content-->

</div><!-- End of container -->
<?php include(TEMPLATE_FRONT .  "/footer.php");?>
