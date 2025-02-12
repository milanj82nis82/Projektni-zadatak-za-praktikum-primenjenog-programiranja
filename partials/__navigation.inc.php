
<div class="container">
  <div class="row">
    <div class="col-md-12">




<nav class="navbar navbar-expand-lg bg-light navbar-light ">
  <!-- Container wrapper -->
  <div class="container-fluid">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#"><?php echo SITE_NAME; ?></a>


    

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Link -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="all-tasks.php">Zadaci</a>
        </li>        

             
        <li class="nav-item">
          <a class="nav-link" href="about-us.php">About us</a>
        </li>    

        <li class="nav-item">
          <a class="nav-link" href="contact-us.php">Contact us</a>
        </li>

        <!-- Dropdown -->


      </ul>

 
      <ul  class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php
try {
 
  
  if (isset($_SESSION['user'])) {
   
    
    ?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
role="button" data-bs-toggle="dropdown" aria-expanded="false">
  Welcome back , <?php echo $_SESSION['user']['first_name'] . ' 
  ' . $_SESSION['user']['last_name'] ?>
</a>
<!-- Dropdown menu -->
<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
  <li>
    <a class="dropdown-item" href="my-account.php">My account</a>
  </li>
  <li>
    <a class="dropdown-item" href="my-tasks.php">My tasks</a>
  </li>
  <li>

  <?php
try {

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userLogout'])) {
    
    $user = new classes\User();
    $user->userLogout();
    header('Location: login.php');
    exit();
    

  }// main isset


}catch ( PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

?>
    <form action="" method="POST">
      <button class="dropdown-item" type="submit" name="userLogout">Logout</button>
    </form>
  
    
  </li>
</ul>
</li>
<?php



  } else {
?>

<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
          role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Welcome back , Guest
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="login.php">Login</a>
            </li>
            <li>
              <a class="dropdown-item" href="register.php">Register</a>
            </li>
            <li>
              <a class="dropdown-item" href="password-reset.php">Password reset</a>
            </li>
          </ul>
        </li>

<?php
}





}catch ( PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  } 
?>
      </ul>

      <!-- Search -->
      <form class="w-auto">
        <input type="search" class="form-control" placeholder="Type query" aria-label="Search">
      </form>

    </div>
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->
</div>
  </div>
</div>