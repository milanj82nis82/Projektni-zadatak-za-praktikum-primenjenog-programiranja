<?php
// Include necessary configuration, database, and class autoloader files
require_once 'include/config.inc.php';
require_once 'include/db.inc.php';
require_once 'include/classAutoloader.inc.php';
require_once 'include/phpSessionMessages/src/FlashMessages.php';
use \Plasticbrain\FlashMessages\FlashMessages;
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
use Include\DbConnect;
use classes\User;
try {
/* check if user is already logged in */

  if (isset($_SESSION['user'])) {
    header("Location: my-account.php");
    exit();
  }


} catch ( PDOException $e ){
  echo $e -> getMessage();
}
?>
<!doctype html>
<html lang="en">
  <head>
   <?php require_once 'partials/__head.inc.php'; ?>
    <title>New token request | <?php echo SITE_NAME; ?></title>
  </head>
  <body>


  <?php require_once 'partials/__navigation.inc.php'  ?>


  
    
  <section class="h-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6 d-none d-xl-block">
              <img src="img/register.webp"
                alt="Sample photo" class="img-fluid"
                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
            </div>
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <h3 class="mb-5 text-uppercase">Password Reset</h3>
<?php
try {


  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['passwordReset'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $user = new classes\User();
    $user -> passwordReset($email);
  }

 
  $msg -> display();
} catch ( PDOException  $e ){
  echo $e -> getMessage();
}


?>
                <form action="" method="POST">

                
                <div class="row">
     
                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example8">Email address</label>
                  <input type="email" name="email" id="form3Example8" class="form-control form-control-lg" />
                
                </div>

             
                

                <div class="d-flex justify-content-end pt-3">
                  
                  <button  type="submit" data-mdb-button-init data-mdb-ripple-init 
                  class="btn btn-warning btn-lg ms-2" name="passwordReset">Reset password</button>
                </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  
<footer>
  <?php require_once 'partials/__footer.inc.php'  ?>
</footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
