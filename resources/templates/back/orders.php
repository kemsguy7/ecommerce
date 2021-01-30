


<div class="col-md-12">
<div class="row">
<h1 class="page-header"> 
   All Orders

</h1>

<h4 class="text-center bg bg-success"><?php display_message(); ?> </h4>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>id</th>
           <th>Amount</th>
           <th>Invoice Number</th>
           <th>Order Date</th>
           <th>Status</th>
      </tr>
    </thead>
    <tbody>
       
            <?php 
            //defined in the functions.php page
                display_orders(); 

            ?>
     
        

    </tbody>
</table>
</div>








