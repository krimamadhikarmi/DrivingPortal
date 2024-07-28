<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Driving License Registration - Home</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <?php include 'nav.html'; ?>
    <div class="container">
      <h1>Welcome to Driving License Registration Site</h1>
      <p>
        Welcome to the official website for driving license registration. Here
        you can register for a new driving license and find useful information about the process.
      </p>
    </div>
  </body>
</html>
