<?php
    require("./conn.php");
    session_start();
	$name = $email = $message = "";
	$error = array('name' => '', 'email' => '', 'message' => '');
    $result = "";

    if(isset($_POST['submit'])) {
		if(empty($_POST['name'])) {
			$error['name'] = "Write your firstname";
		} else {
			$name = $_POST['name'];
			if(!preg_match('/^[a-zA-Z]*$/', $name)) {
				$error['name'] = "Name should be letters only";
			}
		}

        if(empty($_POST['email'])){
			$error['email'] = "Write email";
		} else {
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error['email'] = "Write valid email";
			}
		}

        if(empty($_POST['message'])) {
			$error['message'] = "Please write the message";
		} else {
			$message = $_POST['message'];
			if(!preg_match('/^[a-z\d\-_\s]+$/i', $name)) {
				$error['message'] = "Message should only include Hexadecimal";
			}
		}

        if(!array_filter($error)) {
			$sql = "INSERT INTO contactus(name, email, message) 
                    VALUES ('$name', '$email', '$message')";
			$result = mysqli_query($conn, $sql);
            if($result) { textnote(); } else { errornote(); }
		}
    

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us | Event Mania</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./styles/contact.css">
    <link rel="stylesheet" href="./styles/index.css">
</head>

<body>
    <header class="navbar">
        <h1 class="title">Event Mania</h1>
    </header>
    <ul class="nav-links">
        <li class="nav-link"><a href="./index.php">Home</a></li>
        <li class="nav-link"><a href="./aboutus.html">About</a></li>
        <?php 
            if(!(isset($_SESSION['student_id']))) {
                echo '<li class="nav-link"><a href="./login.php">Login</a></li>
                <li class="nav-link"><a href="./register.pgp">Signup</a></li>';
            } else {
                echo '<li class="nav-link"><a href="./logout.php">Logout</a></li>';
            }
        ?>
    </ul>
    <div class="formarea">
        <div class="circle1"></div>
        <div class="circle2"></div>
        <form action="contactus.php" method="POST" autocomplete="off">
            <h2 class="title">Contact Us</h2>
            <div class="formoption">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" />
                <p class="warning">
                    <?php echo htmlspecialchars($error['name']); ?>
                </p>
            </div>
            <div class="formoption">
                <label for="email">Your Email ID</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" />
                <p class="warning">
                    <?php echo htmlspecialchars($error['email']); ?>
                </p>
            </div>
            <div class="formoption">
                <label for="yourquery">Your Query</label>
                <textarea id="yourquery" name="message"><?php echo htmlspecialchars($message); ?></textarea>
                <p class="warning">
                    <?php echo htmlspecialchars($error['message']); ?>
                </p>
            </div>
            <div class="btngroup">
                <button type="submit" name="submit" class="btn sub">Submit <i class="fas fa-arrow-right"></i></button>
                <input type="reset" class="btn" name="reset" />
            </div>
            <div class="note">Verify your information
            <?php
                function textnote() {
                    echo "<br/>We have received the message. We will get connected to you shortly.";
                }
                function errornote() {
                    echo "<br/>Oops, It seems we encountered a error, Please check back later.";
                }
            ?>
            </div>
        </form>

    </div>
    <?php require("./includes/footer.php"); ?>
</body>

</html>