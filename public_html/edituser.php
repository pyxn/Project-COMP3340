<?php

session_start();
if(!isset($_SESSION['user'])){
    header('location:adminlogin_edituser.php');
}
?>

<html>
<head>
    <!-- set title of the webpage as "Edit User" -->
	<title>
		Edit User
	</title>
    <!-- set proper meta-tag information of the page -->
    <meta name="keywords" content="edit, username, password">
    <meta name="description" content="This webpage is for editing user records.">
    <!-- include external style sheet -->
    <?php 
    $style="styles/admin.css";
    $yellow = $_POST["yellow"];
    $pink = $_POST["pink"];
    if($yellow){
        $style="styles/admin_yellow.css";
    }
    if($pink){
        $style="styles/admin_pink.css";
    }
    ?>
    <link rel="stylesheet" href=<?php echo $style; ?>>
</head>

<body>
    <?php
    $id = $_POST["id"];
    $c_username = $_POST["c_username"];
    $choosebutton = $_POST["chooseuser"];
    $savebutton = $_POST["edituser"];
    $inUsername = "";
    $inPass = "";

    $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
    if(!$conn){
        die("connection fail: ". mysqli_connect_error());
    }
    mysqli_select_db($conn, 'qiao6_comp3340');

    if ($choosebutton){
        if($_POST["c_username"]==""){
            echo '<script>alert("Please choose a user record to edit.")</script>';
        }
        else{
        

        $query = "SELECT * from users WHERE username='$c_username'";
        $result = mysqli_query($conn, $query);
        $row=$result->fetch_assoc();

        $inUsername=$row['username'];
        $inPass=$row['password'];

        $id = $c_username;
        }
    }

    if($savebutton){
        if($_POST["id"]==""){
            echo '<script>alert("Please choose a user record to edit.")</script>';
        }
        else{
            $inputName = $_POST["e_username"];
            $inputPass = $_POST["e_userpass"];

            $s = "select * from users where username='$inputName' ";
            $result = $conn->query($s);

            if($result->num_rows>0 && $inputName!=$_POST["id"]){
            echo '<script>alert("This username is not available.")</script>';
            }
            else{
                $prName=$_POST["id"];
                $r="UPDATE users SET username = '$inputName', password = '$inputPass' WHERE username='$prName' ";
                mysqli_query($conn, $r);
            }
  
        }
        $id="";
    }
    $conn->close();
    ?>

    <br><br>
    <section>
        <br>
        <h4> CHOOSE USER </h4>
        <form method="post" action="edituser.php">
            <label>Username:</label>
            <select name="c_username">
                <option value="">Select</option>
                <?php
                $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
                if(!$conn){
                    die("connection fail: ". mysqli_connect_error());
                }
                mysqli_select_db($conn, 'qiao6_comp3340');
        
                $s = "select * from users";
                $result = $conn->query($s);
                while($row=$result->fetch_assoc()){
                    echo "<option value='".$row["username"]."'";
                    if($id==$row["username"]){
                        echo " selected ";
                    }
                    echo ">".$row["username"]."</option>";
                }
                $conn->close();
                ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="chooseuser" class="button" value="EDIT">
        </form>
        <br>
    </section>
    <br>
    <section>
        <br>
        <h4> EDIT USER </h4>
        <form method="post" action="edituser.php">
            <label>Username:</label>
            <input type="text" name="e_username" value=<?php echo $inUsername;?>>&nbsp;&nbsp;&nbsp;&nbsp;
            <label>User password:</label>
            <input type="text" name="e_userpass" value=<?php echo $inPass;?>><br><br>
            <input type="submit" name="edituser" class="button" value="SAVE">
            <input type="hidden" name="id" value="<?php echo (empty($id))?"":$id; ?>">
        </form>
        <br>
    </section>
    <br>
    <br>

    <p>Choose Scheme</p>
    <form method="post" action="edituser.php"><input type="submit" name="blue" class="button" value="BLUE">
    <input type="submit" name="yellow" class="button" value="YELLOW">
    <input type="submit" name="pink" class="button" value="PINK"></form>

    <a href='adminlogout.php'>Log Out</a>

    
  
</body>
</html>