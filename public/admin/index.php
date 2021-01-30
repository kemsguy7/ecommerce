   <?php //Admin Home page ?>                 
                
<?php require_once("../../resources/config.php"); ?>

<?php include(TEMPLATE_BACK . "/header.php") ?>
        <div id="page-wrapper">



                <?php  

                if($_SERVER['REQUEST_URI'] == "/ecomm-udem/public/admin/" || $_SERVER['REQUEST_URI'] == "/ecomm-udem/public/admin/index.php")  {
                    include(TEMPLATE_BACK . "/admin_content.php");
                }
                    

                if(isset($_GET['orders'])) {

                      include(TEMPLATE_BACK . "/orders.php"); 
                }

                if(isset($_GET['categories'])) {

                      include(TEMPLATE_BACK . "/categories.php"); 
                }

                if(isset($_GET['product'])) {

                      include(TEMPLATE_BACK . "/products.php"); 
                }

                if(isset($_GET['add_product'])) {

                      include(TEMPLATE_BACK . "/add_product.php"); 
                }

                 if(isset($_GET['edit_product'])) {

                      include(TEMPLATE_BACK . "/edit_product.php"); 
                }
                ?>
              
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include(TEMPLATE_BACK . "/footer.php"); ?>