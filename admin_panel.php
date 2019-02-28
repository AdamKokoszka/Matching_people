<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=true){
  header("location: index.php");
  exit();
} 
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8">
    <?php header('Content-type: text/html; charset=utf-8'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="Shortcut icon" href="shortcut.png">
    <title>Generator losowania</title>
    <script href="Bootstrap/bootstrap.min.js"></script>
    <script src="jquery.js"></script>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include('connect.php'); ?>
    <?php
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    $sql1="SELECT * FROM all_data";
    $result = mysqli_query($connection, $sql1);
    $NumRows=mysqli_num_rows($result);
    $members=array();

    if ($NumRows <= 0) {
      echo "0 results";
    } else {
      while($row = mysqli_fetch_assoc($result)) {
        $members[] = $row;
      }
    }
    mysqli_close($connection);
    ?>

  </head>
  <body>
    <div class="container-fluid">  
      <div class="row">
        <div class="col-sm-12 bg1">
          <h1>Dobieranie osób według listy</h1>
          <div class="row">
            <div class="col-sm-5">
              <div id="result-bin"></div>
            </div>
            <div class="col-sm-7">
              <div id="result-string"></div>
            </div>
          </div>
          <button class="button-margin" onclick="Change_week()">Następny tydzień</button>
          <div id="repeated-user">
          </div>
          <div id="repeated-user-name">
          </div>
          <div id="repeated-end">
          </div>
          <div id="whitch-week"></div>
        </div>
        <div class="col-sm-12 bg2">
          <h1>Lista uczestników</h1>
          <p id="all-members"></p>
          <div id="list">
          </div>
        </div>
        <div class="col-sm-12 bg3">
          <h1>Dodawanie osoby</h1>
          <form action="add_member.php" method="post">
            <p>Podaj dane osoby:</p> 
            <input name="add-member" placeholder="np:.Marek Kowalski"type="text">
            <p style="margin-top:10px;">Podaj tydzien od ktorego ma należeć: </p> 
            <input name="week" min="1" type="number">
            <input type="submit" value="Dodaj osobę!">
          </form>
          <p id="info-add-week">Jeśli dodajesz osobę na samym początku ustaw 1, a jeśli w trakcie trwania, dopisz tydzien od którego ma należeć.</p>
          <div id="info-add">
            <?php
            if(isset($_SESSION["info-add"])){
              echo $_SESSION["info-add"];
              unset($_SESSION["info-add"]);
            }
            ?>
          </div>
        </div>
        <div class="col-sm-12 bg4">
          <h1>Osoby dodane później</h1>
          <div id="add_later">
          </div>
        </div>

        <div class="col-sm-12 bg5">
          <h1>Usuwanie osoby</h1>
          <form action="delete_member.php" method="post">
            <select name="dell-member" id="removal">
            </select>
            <input type="submit" value="Zatwierdz!">
          </form>
          <div id="info-delete">
            <?php
            if(isset($_SESSION["info-delete"])){
              echo $_SESSION["info-delete"];
              unset($_SESSION["info-delete"]);
            }
            ?>
          </div>
        </div>
        <div class="col-sm-12 logout">
         <h1>Jestes zalogowany jako Admin - 
          <a href="logout.php"> Wyloguj!</a>
          </h1>
        </div>
      </div>
      <script>
        var arr1= [];
        var arr2= [];
        var arr3 =<?php echo json_encode($members); ?>;
        var lg3 = arr3.length;
        var week=0;
        for(var k=0;k<lg3; k++){
          arr1[k]=k;
          arr2[k]=k;
        }
        Change_week();
        function Change_week(){
          document.getElementById('result-bin').innerHTML=("");
          document.getElementById('result-string').innerHTML=("");
          week++;
          var deleted = arr2.shift();
          arr2[lg3-1]=deleted;
          for(var i=0; i<lg3; i++){
            document.getElementById('result-bin').innerHTML+=(arr1[i] + " --> " + arr2[i] + "<br>");
          }
          for(var i=0; i<lg3; i++){
            document.getElementById('result-string').innerHTML+=(arr3[arr1[i]]['members'] + " --> " + arr3[arr2[i]]['members'] + "<br>");
          }
          document.getElementById('whitch-week').innerHTML="Tydzien: " + week;

          for(var m=0;m<lg3; m++){
            if(week==arr3[m]['week'] && week!=0 && week!=1){
              document.getElementById("repeated-user").innerHTML='Dodano osobę w trakcie - pomiń ten tydzień';
              break;
            } else {
              document.getElementById("repeated-user").innerHTML="";
            }
          }
          if(arr1[0]==arr2[0]){
            document.getElementById("repeated-end").innerHTML="Wykonano cały obieg!";
          } else {
            document.getElementById("repeated-end").innerHTML="";
          }
        }
        //List and number of people
        for(var l=0; l<lg3; l++){
          document.getElementById('list').innerHTML+=arr3[l]['members']+"<br>";
        }
        document.getElementById('all-members').innerHTML="Ilość osób: "+lg3;
        //Select
        document.getElementById('removal').innerHTML+='<select><option value="wybierz">--- Wybierz Osobe ---</option>';
        for(var z=0; z<lg3; z++){
          document.getElementById('removal').innerHTML+='<option value="'+arr3[arr1[z]]['members']+'">'+arr3[arr1[z]]['members']+"</option>";
        }
        document.getElementById('removal').innerHTML+="</select>";
        
        //People add later
        var later_exist=false;
        for(var p=0; p<lg3; p++){
          if(arr3[p]['week']>1){
            later_exist=true;
            document.getElementById('add_later').innerHTML+=arr3[p]['members']+" ---> "+arr3[p]['week']+" tydzień<br>";
          }
        }
        if(later_exist==false){
          document.getElementsByClassName('bg4')[0].style.display = 'none';
        }

      </script>
    </div>
  </body>
</html>