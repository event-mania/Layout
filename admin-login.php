<?php
	require("./conn.php");
	session_start();
	$email = $password = "";
	$admin_id = "";
	$error = array('email' => '', 'password' => '', 'default' => '');

	if(isset($_POST['submit'])) {
		if(empty($_POST['email'])) {
			$error['email'] = "Write email";
		} else {
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error['email'] = "Invalid form of email";
			}
		}

		if(empty($_POST['password'])) {
			$error['password'] = "Password cannot be blank";
		} else {
			$password = $_POST['password'];
			if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/', $password)){
				$error['password'] = "Password is invalid";
			}
		}
        if(!array_filter($error)) {
            $sql = "SELECT * FROM admin_user WHERE binary email = '$email' AND binary password = '$password'";
            $result = mysqli_query($conn, $sql);
            $validuser = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if($validuser) {
                $admin_id = $validuser[0]['admin_id'];
                $_SESSION['admin_id'] = $admin_id;

                header("location: admin.php");
            } else {
                $error['email'] = "Invalid email or password";
            }
        }
	}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Event Mania</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/login-signup.css">
</head>

<body>
    <header class="navbar">
        <h1 class="title">Event Mania</h1>
    </header>
    <ul class="nav-links">
        <li class="nav-link"><a href="./index.php">Home</a></li>
        <li class="nav-link"><a href="./aboutus.html">About</a></li>
        <li class="nav-link active"><a href="./login.php">Login</a></li>
        <li class="nav-link"><a href="./register.php">Signup</a></li>
    </ul>
    <div class="container">
        <h2 class="title">Admin login to Event Mania</h2>
        <form class="cred_form" action="admin-login.php" method="POST" autocomplete="off">
            <label for="email">Email ID</label>
            <input type="text" name="email" class="textinput" id="email" placeholder="Your Email" />
            <p class="warning">
                <?php echo htmlspecialchars($error['email']); ?>
            </p>
            <label for="password">Password</label>
            <input type="password" name="password" class="textinput" id="password" placeholder="Enter Password" />
            <p class="warning">
                <?php echo htmlspecialchars($error['password']); ?>
            </p>
            <div class="form-options">
                <div class="rememberme_cont">
                    <input type="checkbox" id="rememberme" class="rememberme">
                    <label for="rememberme">
                        Remember Me?
                    </label>
                </div>
                <a href="#" class="forgot_pass">Forgot password?</a>
            </div>
            <button type="submit" class="submitbtn" name="submit"><i class="fas fa-lock"></i> Login</button>
            <p class="warning">
                <?php echo htmlspecialchars($error['default']); ?>
            </p>
            <p class="form_ex_link">Not a user? <a href="./register.php">Register</a></p>
        </form>
    </div>
    <?php require('./includes/footer.php'); ?>
</body>
</html>