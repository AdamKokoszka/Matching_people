<?php
session_start();
if(isset($_POST['dell-member']) && $_POST['dell-member']!="wybierz"){
  $value = $_POST['dell-member'];
  include('connect.php');
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  $sql2 = 'DELETE FROM all_data WHERE members="'.$value.'"';
  $result = mysqli_query($connection, $sql2);
  $_SESSION["info-delete"] = "Usunięto użytkownika ".$value;
}
header("location: admin_panel.php");
?>