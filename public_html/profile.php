<?php
  $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
  if(!$conn){
    die("connection fail: ". mysqli_connect_error());
  }
  $myUsername = $_POST['username'];
  $sql = "SELECT * FROM favorites WHERE username = $myUsername";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  if($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo $row["favorite_city_rank"].$row["favorite_city_name"]."<br>" ;
    }
  }
  else {
    echo "You have not favorite any cities!"
  }

  mysqli_close($conn);

?>
