<?php
require("./conn.php");
    session_start();
    if(!(isset($_SESSION['student_id']))) {
        header("location: login.php");
    } else {
        $profileID = $_SESSION['student_id'];
    }
    $student_sql = "SELECT * FROM student WHERE student_id = '$profileID'";
    $studentResult = $conn->query($student_sql);


    $college_sql = "SELECT * FROM available_college";
    $collegenames = $conn->query($college_sql);


    $eventname = $eventdescription = $collegecode = $eventdate = $agreeterms = "";
	$error = array('eventname' => '', 'eventdescription' => '', 'collegecode' => '', 'eventdate' => '', 'agreeterms' => '');

    if(isset($_POST['submit'])) {
        if(empty($_POST['agreeterms'])) {
            $error['agreeterms'] = "You need to accept our terms";
        }

        if(empty($_POST['eventname'])) {
			$error['eventname'] = "Write Event Name";
		} else {
			$eventname = $_POST['eventname'];
			if(!preg_match('/^[a-z\d\-_\s]+$/i', $eventname)) {
				$error['eventname'] = "Event name should be letters only ";
			}
		}

        if(empty($_POST['eventdescription'])) {
			$error['eventdescription'] = "Please write Event Description";
		} else {
			$eventdescription = $_POST['eventdescription'];
			if(!preg_match('/^[a-z\d\-_\s]+$/i', $eventdescription)) {
				$error['eventdescription'] = "Event Description should be letters only ";
			}
		}

        if(empty($_POST['collegecode'])) {
			$error['collegecode'] = "Please select the event college";
		} else {
			$collegecode = $_POST['collegecode'];
		}

        if(empty($_POST['eventdate'])) {
			$error['eventdate'] = "Please mention the event date";
		} else {
			$eventdate = $_POST['eventdate'];
		}




        if(!array_filter($error)) {
			$sql = "INSERT INTO event_details(event_name, event_description, organizer, college, event_date, isEventApproved)
                    VALUES ('$eventname','$eventdescription','$profileID', '$collegecode','$eventdate', 0)";
			$result = mysqli_query($conn, $sql);

			if(!$result) {
				echo "query error" . mysqli_error($conn);
			} else {
                $lastid = $conn->insert_id;
                // echo $lastid;
                if(isset($_POST['eventphoto'])) {
                    $filepath = $_FILES['eventphoto']['tmp_name'];
                    $_FILES['eventphoto']['name'] = $lastid.".jpg";
                    $filename = $_FILES['eventphoto']['name'];
                    move_uploaded_file($filepath, "./images/uploads/".$filename);
                    $imgSQL = "UPDATE event_details SET isImageSet = 1 WHERE event_id = $lastid";
                    $imgresult = mysqli_query($conn, $imgSQL);
                    if(!$imgresult) {
                        echo "Oops, we encountered an error in the process";
                    }
                }
                echo "<script type=\"text/javascript\">
                    alert(\"We have received your request for a event. You will receive a mail in short time.\");
                    window.location.href= \"./profile.php\";
                </script>";
            }
		}
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event | Event Mania</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/index.css">
</head>

<body>
    <header class="navbar">
        <h1 class="title">Event Mania</h1>
    </header>
    <ul class="nav-links">
        <li class="nav-link active"><a href="./index.php">Home</a></li>
        <li class="nav-link"><a href="./aboutus.html">About</a></li>
        <li class="nav-link"><a href="./logout.php">Logout</a></li>
    </ul>
    <div class="main_area">
        <main class="events_container">
            <form method="POST" class="eventform" action="./create-event.php" enctype="multipart/form-data" autocomplete="off">
                <h2 class="evetitle">Create Event</h2>
                <div class="formblock">
                    <label for="inptext">Event Name</label>
                    <input type="text" id="inptext" class="inptext" name="eventname" value="<?php echo htmlspecialchars($eventname); ?>" />
                    <p class="warning">
                        <?php echo htmlspecialchars($error['eventname']); ?>
                    </p>
                </div>
                <div class="formblock">
                    <label for="inpdesc">Event Description</label>
                    <textarea class="inpdesc" id="inpdesc" name="eventdescription"><?php echo htmlspecialchars($eventdescription); ?></textarea>
                    <p class="warning">
                        <?php echo htmlspecialchars($error['eventdescription']); ?>
                    </p>
                </div>
                <div class="formblock">
                    <label for="inpselect">Choose the college</label>
                    <select id="inpselect" class="inpselect" name="collegecode" value="<?php echo htmlspecialchars($collegecode); ?>">
                        <option selected disabled>- -</option>
                        <?php
                            if(mysqli_num_rows($collegenames) > 0) {
                                while($row = mysqli_fetch_assoc($collegenames)) {
                                    echo '<option value="'.$row['college_code'].'">'.$row['college_code'].' - '.$row['college_name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                    <p class="warning">
                        <?php echo htmlspecialchars($error['collegecode']); ?>
                    </p>
                </div>
                <div class="formblock">
                    <label for="inpdate">Event Date</label>
                    <input type="date" class="inpdate" name="eventdate" value="<?php echo htmlspecialchars($eventdate) ?>" />
                    <p class="warning">
                        <?php echo htmlspecialchars($error['eventdate']); ?>
                    </p>
                </div>
                
                
                <div class="inpposterblock">
                    <label for="eventphoto">Choose image: </label>
                    <input type="file" id="eventphoto" class="eventphoto" name="eventphoto" accept=".jpg, .jpeg, .png, .bmp" />
                </div>
                <div class="agreeterm">
                    <input type="checkbox" id="agreeterms" name="agreeterms" /> <label for="agreeterms">I/We agree to <a href="#">Terms & Conditions</a></label>
                    <p class="warning">
                        <?php echo htmlspecialchars($error['agreeterms']); ?>
                    </p>
                </div>
                
                <div class="btn-group">
                    <input type="reset" class="formbtn reset" name="reset" value="Reset ✖" />
                    <input type="submit" class="formbtn" name="submit" value="Submit info ✔" />
                </div>
                <div id="notes">
                    <div class="infonote"><strong>Note:</strong> Wait for the Admins to approve the event. You will receive a mail regarding the approval detail in a day.</div>
                </div>
            </form>
            
        </main>
        <div class="sidebar">
            <ul class="side-links">
                <?php
                    if(mysqli_num_rows($studentResult) > 0) {
                        while($row = mysqli_fetch_assoc($studentResult)) {
                            echo '
                                <li class="side-link">Name: <strong>'.$row['firstname'].' '.$row['lastname'].'</strong></li>
                                <li class="side-link">Enrollment no: <strong>'.$row['enrollment_no'].'</strong></li>
                                <li class="side-link">Email ID: <strong>'.$row['email_id'].'</strong></li>
                            ';
                        }
                    }
                ?>
                <br/><br/>
                <li class="side-link"><i class="fas fa-sign-out-alt"></i> <a href="./logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <?php require('./includes/footer.php'); ?>
</body>
</html>