<?php
session_start();
if ((isset($_SESSION['login'])) && ($_SESSION['login']==true))
{
  header('Location: admin_panel.php');
  exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">

  <head>
    <?php header('Content-type: text/html; charset=utf-8'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="Shortcut icon" href="shortcut.png">
    <title>Logowanie do panelu</title>
    <script href="Bootstrap/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>

  <body class="login-body">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 offset-sm-2 bg1 login-box">
          <h1>Logowanie do panelu</h1>
          <form action="login.php" method="post">
            <label>
              Login: <input type="text" name="login">
            </label>
            <br>
            <label>
              Hasło: <input type="password" name="password">
            </label>
            <?php
            if(isset($_SESSION['error'])){
              echo "<br>".$_SESSION['error'];
              unset($_SESSION['error']);
            }	else{
              echo "<br>";
            } 
            ?>
            <br>
            <input type="submit" value="Zaloguj się">
          </form>
        </div>
      </div>

    </div>
  </body>

</html>
