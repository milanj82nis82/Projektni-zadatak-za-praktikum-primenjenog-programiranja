<?php
// Include necessary configuration, database, and class autoloader files
require_once 'include/config.inc.php';
require_once 'include/db.inc.php';
require_once 'include/classAutoloader.inc.php';
require_once 'include/phpSessionMessages/src/FlashMessages.php';
use Include\DbConnect;
use classes\User;
try {

  




} catch ( PDOException $e ){
  echo $e -> getMessage();
}
?>
<!doctype html>
<html lang="en">
  <head>
   <?php require_once 'partials/__head.inc.php'; ?>
   <title>Contact us | <?php echo SITE_NAME; ?></title>

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
                <h3 class="mb-5 text-uppercase">Contact Us</h3>
<?php
try {

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contactUs'])) {
   /* sanititzing the input */
    $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW);
    // Get the user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
   
    // Further processing, such as storing the sanitized data or sending an email
    $messages = new classes\Message();
    $messages -> sendUsMessage( $full_name, $subject, $email, $message , $ip_address );
   
  }

  $msg = new \Plasticbrain\FlashMessages\FlashMessages();
  $msg -> display();


} catch ( PDOException $e ){
  echo $e -> getMessage();
}
?>
             
                <form style="width: 26rem;" method="POST" action="">
  <!-- Name input -->
  <div data-mdb-input-init class="form-outline mb-4">
  <label class="form-label" for="form4Example1">Full name</label>
    <input type="text" id="form4Example1" class="form-control" 
    name="full_name"/>
  
  </div>
  <!-- Email input -->
  <div data-mdb-input-init class="form-outline mb-4">
  <label class="form-label" for="form4Example2">Subject</label>
    <input type="text" id="form4Example2" class="form-control" 
    name="subject"/>
 
  </div>

  <!-- Email input -->
  <div data-mdb-input-init class="form-outline mb-4">
  <label class="form-label" for="form4Example2">Email address</label>
    <input type="email" id="form4Example2" class="form-control"  
    name="email"/>
   
  </div>

  <!-- Message input -->
  <div data-mdb-input-init class="form-outline mb-4">
  <label class="form-label" for="form4Example3">Message</label>
    <textarea class="form-control" id="form4Example3" rows="4"
    name="message"></textarea>
    
  </div>

  
  
  <!-- Submit button -->
  <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4"
  name="contactUs">Send us message</button>
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
