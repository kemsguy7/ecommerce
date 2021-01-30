<!-- Configuration-->

<?php require_once("../resources/config.php"); ?>

<!-- Header-->
<?php include(TEMPLATE_FRONT .  "/header.php");?>
<?php require_once("../resources/cart_func.php"); ?>



<?php 

    if(isset($_SESSION['product_1'])) {  

       // echo $_SESSION['item_total']; throws an undefined error when the shopping cart is reduced to -1
    }
?>


    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">
      <h4 class="text-center bg-danger"><?php display_message(); ?> </h4><!--If more products  than exists in the database is ordered, inform the user -->
      <h1>Checkout</h1>

<form action="">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
           <?php cart(); 
              // This function displays the shopping cart. it is declared in the cart_func.php
           ?>
        </tbody>
    </table>
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-6 col-md-3 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"> <?php 
        echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] = "0";
    ?></span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount"> NGN
    <?php //subtotal
        echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] = "0";
    ?>
</span></strong> <br>
 
</td>





</tr>


</tbody>
 
</table>

<div class="col-xs-12 col-md-12">   
    <form action="pay.php">
     
      <input type ="submit" class="btn btn-info btn-block" value="Checkout"> <br>
    </form>  
    
</div>

</div><!-- CART TOTALS-->




 </div><!--Main Content-->

</div><!-- End of container -->
<?php include(TEMPLATE_FRONT .  "/footer.php");?>
