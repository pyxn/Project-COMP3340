<?php

session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

?>

<html>

<head>
    <title>Change Username|Password</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
</head>

<body>
    <?php
    $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
    if (!$conn) {
        die("connection fail: " . mysqli_connect_error());
    }

    mysqli_select_db($conn, 'qiao6_comp3340');
    $name = $_SESSION['username'];

    $query = "SELECT * from users WHERE username='$name'";
    $data = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($data);
    $pass = $row["password"];

    if (isset($_POST["edit"])) {
        $inputName = $_POST["name"];
        $inputPass = $_POST["pass"];

        $s = "select * from users where username='$inputName' ";
        $result = $conn->query($s);

        if ($result->num_rows > 0 && $inputName != $_SESSION['username']) {
            echo '<script>alert("This username is not available.")</script>';
        } else if ($inputName == "") {
            echo '<script>alert("Please fill in username.")</script>';
        } else if ($inputPass == "") {
            echo '<script>alert("Please fill in password.")</script>';
        } else {
            $prName = $_SESSION['username'];
            $r = "UPDATE users SET username = '$inputName', password = '$inputPass' WHERE username='$prName' ";
            mysqli_query($conn, $r);
            $r = "UPDATE favorites SET username = '$inputName' WHERE username='$prName' ";
            mysqli_query($conn, $r);
            header('location:login.php');
        }
    }
    ?>
    <nav id='theme-control-dark' class="navbar navbar-inverse">
        <div class="container-fluid">
            <h3 style="color: #fff;">Change Username|Password
                <a class="btn btn-primary" href="index.php" role="button" style="float: right; color: black; background-color: white;">Home</a>
                <a class="btn btn-primary" href="profile.php" role="button" style="float: right; color: black; background-color: white;">Back</a>
            </h3>
        </div>
    </nav>

    <div class="container">
        <h3 style="text-align: center; font-weight: bold;">Edit Here</h3>
        <div class="row">
            <form class="form-horizontal" action="userchange.php" method="POST">
                <div class="form-group">
                    <label class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-4">
                        <input type="text" name="name" class="form-control" placeholder=<?php echo $name; ?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-4">
                        <input type="text" name="pass" class="form-control" placeholder=<?php echo $pass; ?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-4">
                        <input type="submit" class="btn btn-primary" name="edit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>