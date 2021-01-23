 

<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/functions.php"); ?>

<?php include(TEMPLATE_FRONT .  "/header.php"); ?>

    <!-- Page Content -->
    <div class="container">

      <header>
            <h1 class="text-center">Login</h1>
            <h2 class="text-center bg-warning"><?php display_message(); ?> </h2>
        <div class="col-sm-4 col-sm-offset-5">         
            <form class="" action="login.php" method="post" enctype="multipart/form-data">
               <?php login_user(); ?>
                <div class="form-group"><label for="">
                    username<input type="text" name="username" class="form-control"></label>
                </div>
                 <div class="form-group"><label for="password">
                    Password<input type="text" name="password" class="form-control"></label>
                </div>

                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" >
                </div>
            </form>
        </div>  


    </header>


        </div>

    </div>
    <!-- /.container -->

  <?php include(TEMPLATE_FRONT .  "/footer.php"); ?>