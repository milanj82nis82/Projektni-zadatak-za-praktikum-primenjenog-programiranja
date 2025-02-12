<?php
// Include necessary configuration, database, and class autoloader files
require_once 'include/config.inc.php';
require_once 'include/db.inc.php';
require_once 'include/classAutoloader.inc.php';
require_once 'include/phpSessionMessages/src/FlashMessages.php';
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
   <title>User Registration | <?php echo SITE_NAME; ?></title>
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
                <h3 class="mb-5 text-uppercase">User registration</h3>

<?php
try {

  if( isset($_POST['submitRegistration']) ){
          /* form input sanitization */
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_repeat = filter_input(INPUT_POST, 'password_repeat', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_NUMBER_INT);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_STRING);
    $birth_date = filter_input(INPUT_POST, 'birth_date', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

    // Further processing and validation can be done here
    
    $user = new classes\User();
    $user -> submitRegistration( $first_name , $last_name , $username , $password , $password_repeat , 
    $gender , $state , $city , $postal_code , $birth_date , $address , $phone , $email );


  }// main isset


$msg = new \Plasticbrain\FlashMessages\FlashMessages();
  $msg -> display();
} catch ( PDOException $e ){
  echo $e -> getMessage();
}



?>

        <form action="" method="POST">

               
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1m">First name</label>
                      <input type="text" id="form3Example1m" class="form-control form-control-lg"
                      name="first_name" />
                     
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1n">Last name</label>
                      <input type="text" id="form3Example1n" class="form-control form-control-lg" 
                      name="last_name" />
                     
                    </div>
                  </div>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example8">Username</label>
                  <input type="text" id="form3Example8" class="form-control form-control-lg" name="username"/>
                  
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example8">Email address</label>
                  <input type="email" id="form3Example8" class="form-control form-control-lg" name="email"/>
                  
                </div>
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1m1">Password</label>
                      <input type="password" id="form3Example1m1" class="form-control form-control-lg"
                      name="password" />
                      
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1n1">Password repeat</label>
                      <input type="password" id="form3Example1n1" class="form-control form-control-lg" 
                      name="password_repeat"/>
                      
                    </div>
                  </div>
                </div>

  

                <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                  <h6 class="mb-0 me-4">Gender: </h6>

                 <br>
                  <select class="form-select" name="gender">
  
                    <option value="0">Male</option>
                    <option value="1">Female</option>

                  </select>

                </div>

                <div class="row">
                
                <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1m">State</label>
                      <input type="text" id="form3Example1m" class="form-control form-control-lg"
                      name="state" />
                     
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1n">City</label>
                      <input type="text" id="form3Example1n" class="form-control form-control-lg" 
                      name="city" />
                     
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1m1">Postal Code</label>
                      <input type="text" id="form3Example1m1" class="form-control form-control-lg"
                      name="postal_code" />
                      
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="form3Example1n1">Birth date</label>
                      <input type="date" id="form3Example1n1" class="form-control form-control-lg" 
                      name="birth_date"/>
                      
                    </div>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example8">Address</label>
                  <input type="text" id="form3Example8" class="form-control form-control-lg" 
                  name="address"/>
                  
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example8">Phone</label>
                  <input type="text" id="form3Example8" class="form-control form-control-lg" name="phone"/>
                  
                </div>
                <div class="row">
                <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                    
                    <button type="reset" class="btn btn-danger">Reset Form</button>

                      
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                   
                    <button name="submitRegistration" type="submit" class="btn btn-primary">Submit Registration</button>
                      
                    </div>
                  </div>
                </div>

                </div>
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
