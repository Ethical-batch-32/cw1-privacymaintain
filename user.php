<?php
session_start();
include 'db.php';

// Check if user is logged in and has an active session
if(!isset($_SESSION['email'])){
    header("location: login.php");
    exit;
}

$email = $_SESSION['email'];

// check user tabvvvvvvvvvvvvvvvvle
$query = "SELECT id, name FROM users WHERE email='$email'";
$results = mysqli_query($conn, $query);

if (mysqli_num_rows($results) == 1) {
    $row = mysqli_fetch_assoc($results);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $email;
    $user = $row['name'];
    if(isset($_SESSION['admin_id']))
    unset($_SESSION['admin_id']);
}

// check admin table
$query = "SELECT id, name FROM admin WHERE email='$email'";
$results = mysqli_query($conn, $query);

if (mysqli_num_rows($results) == 1) {
    $row = mysqli_fetch_assoc($results);
    $_SESSION['admin_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $email;
    if(isset($_SESSION['user_id']))
    unset($_SESSION['user_id']);
    header('location: admin.php');
    exit();
}

// Check if logout button is clicked
if(isset($_POST['logout'])){
    session_destroy();
    setcookie('email', '', time()-1);
    setcookie('pass', '', time()-1);
    header('location: login.php');
    exit;
}

// Check if the update details form has been submitted
if(isset($_POST['update_details'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($password)) {
        // Hash the password for security
        $password = md5($password);
        // Update the user's details in the database
        $query = "UPDATE users SET name='$username', email='$email', password='$password' WHERE email='$email'";
    } else {
        // Update the user's details in the database without changing the password
        $query = "UPDATE users SET name='$username', email='$email' WHERE email='$email'";
    }
    mysqli_query($conn, $query);

    // Set a session variable to indicate that the details have been updated
    $_SESSION['details_updated'] = true;

    // Redirect the user to the same page
    header("location: user.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"  type="text/javascript"></script>
  <style type="text/css">

    .pacifico{
      font-family: 'Pacifico', cursive;
    }
    a.navbar-brand{
      font-family: 'Pacifico', cursive;
      font-size: 30px;
    }

    button.btn:hover i{
      color: white !important;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  
  </head>
  <body class="d-flex flex-column h-100">
    <header class="mb-5">
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a href="index.php" class="logo"> <i class="fas fa-heartbeat"></i> <strong>E</strong>medical </a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <
          <li class="nav-item">
          <a class="nav-link" href="index.php">Main Page</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://github.com/privacymaintain">About</a>
        </li>
      </ul>
      

      <form method="POST" class="form-inline mt-2 mt-md-0">
        <button class="btn btn-outline-success larger my-2 my-sm-0" name="logout" type="submit"><i class="fas fa-user text-success" style="color: red;"></i> Logout</button>
      </form>
      
    </div>
  </nav>
</header>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0 p-0">
  <div class="container">
    <h1 class="mt-5">Welcome <?=$user?>,</h1>
    <p></p>
    <p class="lead">E-pharmacy, also known as online pharmacy, is a type of business that 
      
    allows customers to purchase medications and other health-related products over the internet. These pharmacies typically have a website that allows customers to place orders and have the products delivered to their homes. Some e-pharmacies also offer virtual consultations with healthcare professionals, and may have more extensive product offerings than traditional brick-and-mortar pharmacies. E-pharmacies are becoming increasingly popular as they offer convenience and easy access to medications for those who have difficulty visiting a physical pharmacy. However, 
      it is important to ensure that the e-pharmacy you are using is legitimate and 
      licensed to sell medication in your country. </p>
  </div>
  
  <div class="modal" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <form action="" method="POST">
        <div class="form-group">
            <label for="username">Name</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user;?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="update_details" class="btn btn-primary">Save Changes</button>
      </form>
      </div>
    </div>
  </div>
</div>

</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <hr>
    <span class="text-muted float-right">&copy 2022:<a class="pacifico text-secondary" href="html/index.html"> @aaruhi </a></span>
  </div>
</footer>
  <!-- Bootstrap core JavaScript-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/  nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>