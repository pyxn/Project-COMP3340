<?php
//  include_once 'includes/dbh.inc.php';
//?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User Profile</title>
  </head>
  <body>

  <?php
    $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
    if(!$conn){
      die("connection fail: ". mysqli_connect_error());
    }    
    //$selected_username      = $_POST['username'];
    $sql = "SELECT * FROM favorites";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo $row['favorite_city_rank'].$row['favorite_city_name']"<br>" ;
      }
    }
  ?>

  </body>
</html>
