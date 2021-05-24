<?php
	require("./conn.php");
	session_start();

    if(isset($_SESSION['student_id'])) {
        header("location: profile.php");
    }


	$email = $password = "";
	$student_id = "";
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
            $sql = "SELECT * FROM student WHERE binary email_id = '$email' AND binary password = '$password' AND isUserDeleted = 0";
            $result = mysqli_query($conn, $sql);
            $validuser = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if($validuser) {
                $student_id = $validuser[0]['student_id'];
                $_SESSION['student_id'] = $student_id;

                header("location: profile.php");
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
    <title>Login | Event Mania</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/login-signup.css">
</head>

<body>
    <?php require('./includes/navbar.php'); ?>
    <div class="container">
        <h2 class="title">Login to Event Mania</h2>
        <form class="cred_form" action="login.php" method="POST" autocomplete="off">
            <label for="email">Email ID</label>
            <input type="text" name="email" class="textinput" id="email" placeholder="Your Email" value="<?php echo htmlspecialchars($email)?>" />
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