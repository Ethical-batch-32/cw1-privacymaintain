<!doctype html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="description" content="A minimal and responsive HTML5 landing page built on lightweight, clean and customizable code.">
  <meta name="viewport" content="width=device-width">
  <link rel="apple-touch-icon-precomposed" href="media/favicon.png">
  <link rel="icon" href="media/favicon.png">
  <link rel="mask-icon" href="media/favicon.svg" color="rgb(36,38,58)">
  <link rel="shortcut icon" href="media/favicon.png">
  <link rel="stylesheet" href="css/main.css">
</head>
<body class="page page-onboarding preload">
<?php 
session_start();
if(isset($_SESSION['email'])){
    header("Location: user.php");
    exit;
}
?>
  <main>

    <a href="index.php" class="button button-close" role="button"></a>

    <section class="row no-gutter reverse-order">
      <div class="col-one-half middle padding">
        <div class="max-width-s">
          <h5>Welcome!</h5>
          <p class="paragraph">Enter your details to create an account.</p>
          <form action="submit-signup.php" method="post">
            <div class="form-group">
              <label for="name">Name:</label>
              <input id="name" type="text" name="name">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input id="email" type="email" name="email">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input id="password" type="password" name="password">
            </div>
            <input type="submit" value="Create Account" class="button button-primary full-width space-top">
          </form>
        </div>
        <div class="center max-width-s space-top">
          <span class="muted">By creating an account, you agree to our </span><a href="#">Terms</a><span class="muted">.</span>
        </div>
        <div class="center max-width-s">
          <span class="muted">Already have an account? </span><a href="login.php">Log In</a>
        </div>
      </div>
      <div class="col-one-half bg-image-04 featured-image"></div>
    </section>

  </main>

  <script src="js/main.js"></script>
</body>
</html>
