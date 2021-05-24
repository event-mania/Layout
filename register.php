<?php
	require("./conn.php");
	$firstname = $lastname = $email = $password = $repeatpassword = $enrollment = $phonenumber = "";
	$error = array('firstname' => '', 'lastname' => '', 'enrollment' => '', 'email' => '', 'password' => '', 'repeatpassword' => '', 'phonenumber' => '');

	if(isset($_POST['submit'])) {
		if(empty($_POST['firstname'])) {
			$error['firstname'] = "Write your firstname";
		} else {
			$firstname = $_POST['firstname'];
			if(!preg_match('/^[a-zA-Z]*$/', $firstname)) {
				$error['firstname'] = "Firstname should be letters only ";
			}
		}

		if(empty($_POST['lastname'])) {
			$error['lastname'] = "Write your lastname";
		} else {
			$lastname = $_POST['lastname'];
			if(!preg_match('/^[a-zA-Z]*$/', $lastname)) {
				$error['lastname'] = "Lastname should be letters only ";
			}
		}

        if(empty($_POST['enrollment'])) {
            $error['enrollment'] = "Write your enrollment number";
        } else {
            $enrollment = $_POST['enrollment'];
            if(!is_numeric($enrollment) || !(strlen($enrollment) == 12)){
                $error['enrollment'] = "Enrollment number is Number only & 12 digits";
            } else {
                $enrollment_sql = mysqli_query($conn, "SELECT enrollment_no FROM student WHERE enrollment_no=$enrollment") or 0;
                if(!$enrollment_sql || !(mysqli_num_rows($enrollment_sql) == 0)) {
                    $error['enrollment'] = "Enrollment number is already in use";
                }

            }
        }

        if(empty($_POST['phonenumber'])) {
            $error['phonenumber'] = "Write Phone number";
        } else {
            $phonenumber = $_POST['phonenumber'];
            if(!(is_numeric($phonenumber)) || !(strlen($phonenumber) == 10)) {
                $error['phonenumber'] = "Phone number is 10 digits";
            } else {
                $mobile_sql = mysqli_query($conn, "SELECT mobile_no FROM student WHERE mobile_no=$phonenumber") or 0;
                if(!$mobile_sql || !(mysqli_num_rows($mobile_sql) == 0)) {
                    $error['phonenumber'] = "Mobile number is already in use";
                }
            }
        }


		if(empty($_POST['email'])){
			$error['email'] = "Write email";
		} else {
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error['email'] = "Write valid email";
			} else {
				$email_sql = mysqli_query($conn, "SELECT email_id FROM student WHERE email_id='$email'") or 0;
                if(!$email_sql || !(mysqli_num_rows($email_sql) == 0)) {
                    $error['email'] = "Email is already in use";
                }
			}
		}




		if(empty($_POST['password'])){
			$error['password'] = "Write password";
		} else {
			$password = $_POST['password'];
                if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/', $password)) {
				$error['password'] = "Password should be hexadecimnal and symbol";
			}
		}

		if(!array_filter($error)) {
			$sql = "INSERT INTO student(firstname, lastname, enrollment_no, mobile_no, email_id, password) VALUES ('$firstname','$lastname','$enrollment','$phonenumber','$email','$password')";
			$result = mysqli_query($conn, $sql);

			if(!$result) {
				echo "query error" . mysqli_error($conn);
			} else {
                header("location: ./login.php");
            }
		}
	}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Event Mania</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/login-signup.css">
</head>

<body>
    <?php require('./includes/navbar.php'); ?>
    <div class="container">
        <h2 class="title"><i class="fas fa-user-plus"></i> Register to Event Mania
        </h2>
        <form class="cred_form" action="./register.php" method="POST" autocomplete="off">
            <div class="form-options">
                <div class="form-part">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" class="textinput" placeholder="First name" id="firstname"
                        value="<?php echo htmlspecialchars($firstname)?>" />
                    <p class="warning">
                        <?php echo htmlspecialchars($error['firstname']); ?>
                    </p>
                </div>
                <div class="form-part">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" class="textinput" placeholder="Last name" id="lastname"
                        value="<?php echo htmlspecialchars($lastname)?>" />
                    <p class="warning">
                        <?php echo htmlspecialchars($error['lastname']); ?>
                    </p>
                </div>
            </div>
            <label for="enrollment">Enrollment No</label>
            <input type="text" name="enrollment" class="textinput" placeholder="18*********1" id="enrollment"
                value="<?php echo htmlspecialchars($enrollment)?>" />
            <p class="warning">
                <?php echo htmlspecialchars($error['enrollment']); ?>
            </p>
            <label for="email">Email</label>
            <input type="text" name="email" class="textinput" placeholder="abc@gmail.com" id="email"
                value="<?php echo htmlspecialchars($email)?>" />
            <p class="warning">
                <?php echo htmlspecialchars($error['email']); ?>
            </p>
            <label for="phonenumber">Phone Number</label>
            <input type="text" name="phonenumber" class="textinput" placeholder="123 456 7890" id="phonenumber"
                value="<?php echo htmlspecialchars($phonenumber)?>" />
            <p class="warning">
                <?php echo htmlspecialchars($error['phonenumber']); ?>
            </p>
            <label for="password">Password</label>
            <input type="password" name="password" class="textinput" id="password"
                        placeholder="Enter Password" />
            <p class="warning">
                <?php echo htmlspecialchars($error['password']); ?>
            </p>
            <button type="submit" class="submitbtn" name="submit"><i class="fas fa-user-plus"></i> Register</button>
            <p class="form_ex_link">Already a user? <a href="./login.php">Login</a></p>
        </form>
    </div>
    <?php require('./includes/footer.php'); ?>
</body>

</html>