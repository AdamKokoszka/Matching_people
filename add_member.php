<?php
session_start();
if(isset($_POST['add-member']) && isset($_POST['week']) && !empty($_POST['add-member'])){
  $member = $_POST['add-member'];
  $week = $_POST['week'];
  include('connect.php');
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  $sql3 = 'INSERT INTO all_data (id, members, week) VALUES (NULL, "'.$member.'", '.$week.')';
  mysqli_query($connection, $sql3);
  $_SESSION["info-add"] = "Dodano użytkownika ".$member;
}
header("location: admin_panel.php");
?>