<html>
<head>
    <!-- set title of the webpage as "Admin Login" -->
	<title>
		Admin Login
	</title>
    <!-- include external style sheet -->
    <link rel="stylesheet" href="styles/admin.css">
</head>

<body>

<br><br>
    <section>
        <br>
        <h4> Admin Login </h4>
        <form method="post" action="validation_edituser.php">
            <label>Username:</label>
            <input type="text" name="username"><br>
            <label>Password:</label>&nbsp;
            <input type="text" name="password"><br><br>
            <input type="submit" name="submit" class="button" value="SUBMIT">
        </form>
        <br>
    </section>
</body>
<html>
