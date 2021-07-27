<?php

session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
}

?>
<html>
<head>
    <title>My Favorite Cities</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
</head>

<body>
    <nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <h3 style="color: #fff;">My Favorite Cities</h3>
    </div>
    </nav>

    <div class="container">
        <br><br><br>
        <h3 style="color: #707070;font-weight: bold;">
        Hello, <?php echo $_SESSION['username']?></h3>
        <h4 style="color: #707070;">Here is the list of cities you like!</h4>
        
		<br><br><br>
        <hr>

        <div class="row">
             <table class="table table-striped table-hover">
                 <thead>
                    <tr>
                        <th>Rank</th>
                        <th>City/Town</th>
                        <th>Province</th>
                        <th>Population</th>
                        <th>Avg Home Price</th>
                        <th>Min Income Required</th>
                        <th>Scenery Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
                    if(!$conn){
                        die("connection fail: ". mysqli_connect_error());
                    }

                    mysqli_select_db($conn, 'qiao6_comp3340');
                    $username=$_SESSION['username'];
                    $query = "SELECT * from favorites WHERE username='$username'";
                    $data = mysqli_query($conn, $query);
                    if(mysqli_num_rows($data)>0){
                        while($row = mysqli_fetch_assoc($data)){
                            $rank=$row["favorite_city_rank"];
                            $query = "SELECT * from cities WHERE rank='$rank'";
                            $city = mysqli_query($conn, $query);
                            $city_row = mysqli_fetch_assoc($city);
                            
                            $cityname = $city_row["city_town"];
                            $province = $city_row["province"];
                            $pop = $city_row["population"];
                            $avg_price = $city_row["avg_home_price_2020"];
                            $min_income = $city_row["min_income_required_20_down"];
                            $rating = $city_row["scenery_rating"];
                            echo "<tr onclick=\"window.location='city.php?rk=$rank'\" >";
                            ?>
                            <td><?php echo $rank; ?></td>
                                <td><?php echo $cityname; ?></td>
                                <td><?php echo $province; ?></td>
                                <td><?php echo $pop; ?></td>
                                <td>$<?php echo $avg_price; ?></td>
                                <td>$<?php echo $min_income; ?></td>
                                <td><?php for($i=0; $i<$rating; $i++){echo "☆";} ?></td>
                            </tr>
                            <?php
                        }
                    }
                    else{
                        ?>
                        <tr>
                            <td colspan="2">No records.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
             </table>
        </div>
        <hr>

        <h5 style="color: #707070;">If you want to change your username or password</h5>
        <form class="form-horizontal" action="userchange.php" method="POST">
        <input type="submit" class="btn btn-primary" name="submit" value="Click Here">
        </form>

    </div>
<body>