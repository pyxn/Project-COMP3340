<?php

session_start();
if(!isset($_SESSION['user'])){
    header('location:adminlogin_editrecord.php');
}
?>

<html>
<head>
    <!-- set title of the webpage as "Edit Record" -->
	<title>
		Edit Record
	</title>
    <!-- set proper meta-tag information of the page -->
    <meta name="keywords" content="edit, city, population, ">
    <meta name="description" content="This webpage is for editing user records.">
    <!-- include external style sheet -->
    <?php 
    $blue = $_POST["blue"];
    $yellow = $_POST["yellow"];
    $pink = $_POST["pink"];
    if($blue){
        $_SESSION['color']="styles/admin.css";
    }
    if($yellow){
        $_SESSION['color']="styles/admin_yellow.css";
    }
    if($pink){
        $_SESSION['color']="styles/admin_pink.css";
    }
    if(!isset($_SESSION['color'])){
        $_SESSION['color']="styles/admin.css";
    }
    ?>
    <link rel="stylesheet" href=<?php echo $_SESSION['color']; ?>>
</head>

<body>
    <?php
    $id = $_POST["id"];
    $rank = $_POST["rank"];
    $city = $_POST["city"];
    $choosebutton = $_POST["chooserec"];
    $savebutton = $_POST["editrec"];
    $inPop = "";
    $inHomeprice = "";
    $inPayment = "";
    $inIncome = "";
    $inSenary = "";

    $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
    if(!$conn){
        die("connection fail: ". mysqli_connect_error());
    }
    mysqli_select_db($conn, 'qiao6_comp3340');

    if ($choosebutton){
        if($_POST["rank"]=="" && $_POST["city"]==""){
            echo '<script>alert("Please choose a record to edit.")</script>';
        }
        else{

        $query = "SELECT * from cities WHERE rank='$rank' OR city_town='$city'";
        $result = mysqli_query($conn, $query);
        $row=$result->fetch_assoc();

        $inRank = $row['rank'];
        $inCity = $row['city_town'];
        $inPop = $row['population'];
        $inHomeprice = $row['avg_home_price_2020'];
        $inPayment = $row['avg_mortgage_payment_20_down'];
        $inIncome = $row['min_income_required_20_down'];
        $inSenary = $row['scenery_rating'];

        $id = $inRank;
        }
    }

    if($savebutton){
        if($_POST["id"]==""){
            echo '<script>alert("Please choose a record to edit.")</script>';
        }
        else{
            $inputPop = $_POST["pop"];
            $inputPrice = $_POST["price"];
            $inputPayment = $_POST["payment"];
            $inputIncome = $_POST["income"];
            $inputSenary = $_POST["senary"];
            
            $r="UPDATE cities SET population = '$inputPop', avg_home_price_2020 = '$inputPrice', min_income_required_20_down='$inputIncome', scenery_rating='$inputSenary' WHERE rank='$id' ";
            mysqli_query($conn, $r);
  
        }
        $id="";
    }
    $conn->close();
    ?>

    <!-- link to Edit User -->
	<a href="edituser.php" >Edit Record</a>&nbsp;&nbsp;  
    <!-- link to Edit Record -->
	<span style = 'color: #333A56;'>Edit Record</span>

    <br><br>
    <section>
        <br>
        <h4> CHOOSE RECORD </h4>
        <form method="post" action="editrecord.php">
            <label>Rank:</label>
            <input type="number" min="1" max="166" name="rank" value=<?php echo $inRank?>>&nbsp;&nbsp;&nbsp;&nbsp;
            <label>City/Town Name :</label>
            <input type="text" name="city" value=<?php echo $inCity;?>>
            <input type="submit" name="chooserec" class="button" value="EDIT">
        </form>
        <br>
    </section>
    <br>

    <section>
        <br>
        <h4> EDIT RECORD </h4>
        <form method="post" action="editrecord.php">
            <label>Population:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="number" name="pop" value=<?php echo $inPop;?>><br>
            <label>Avg Home Price:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="number" name="price" value=<?php echo $inHomeprice;?>><br>
            <label>Avg Mortgage Payment:</label>
            <input type="number" name="payment" value=<?php echo $inPayment?>><br>
            <label>Min Income Required:</label>&nbsp;&nbsp;
            <input type="number" name="income" value=<?php echo $inIncome?>><br>
            <label>Scenery Rating:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="number" name="senary" min="1" max="5" value=<?php echo $inSenary?>><br><br>
            <input type="submit" name="editrec" class="button" value="SAVE">
            <input type="hidden" name="id" value="<?php echo (empty($id))?"":$id; ?>">
        </form>
        <br>
    </section>
    <br>
    <br>

    <p>Choose Scheme</p>
    <form method="post" action="editrecord.php"><input type="submit" name="blue" class="button" value="BLUE">
    <input type="submit" name="yellow" class="button" value="YELLOW">
    <input type="submit" name="pink" class="button" value="PINK"></form>

    <a href='adminlogout.php'>Log Out</a>
    
  
</body>
</html>
