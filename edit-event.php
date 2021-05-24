<?php
    require("./conn.php");
    session_start();
    if(!(isset($_SESSION['admin_id']))) {
        header("location: login.php");
    } else {
        $admin_id = $_SESSION['admin_id'];
    }
    
    $admin_sql = "SELECT * FROM admin_user WHERE admin_id = '$admin_id'";
    $adminResult = $conn->query($admin_sql);

    $college_sql = "SELECT * FROM available_college";
    $collegenames = $conn->query($college_sql);

    $eventid = $_GET['eventid'];

    $eventdetailsquery = "SELECT * FROM event_details WHERE event_id = $eventid";
    $eventdetails = $conn->query($eventdetailsquery);

    $eventname = $eventdescription = $collegecode = $eventdate = "";
	// $error = array('eventname' => '', 'eventdescription' => '', 'collegecode' => '', 'eventdate' => '');

    

    if(isset($_POST['submit'])) {
		$eventname = $_POST['eventname'];
		$eventdescription = $_POST['eventdescription'];
        $collegecode = $_POST['collegecode'];
        $eventdate = $_POST['eventdate'];
        
			$sql = "UPDATE event_details SET `event_name` = '$eventname', `event_description` = '$eventdescription', `college` = '$collegecode', `event_date`= '$eventdate', `isEventApproved` = '0' WHERE `event_id` = '$eventid'";
			$result = mysqli_query($conn, $sql);

			if(!$result) {
				echo "query error" . mysqli_error($conn);
			} else {
                echo '<script>alert("Information updated\nRedirecting to the Admin Page");</script>';
                header("location: ./admin.php");
            }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event | Event Mania</title>
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
            <form method="POST" class="eventform" action="./edit-event.php?eventid=<?php echo $eventid; ?>" autocomplete="off">
                <h2 class="evetitle">Edit Event ✏</h2>
                

                <?php
                if(mysqli_num_rows($eventdetails) > 0) {
                    while($row = mysqli_fetch_assoc($eventdetails)) {
                       echo ' 
                       <p class="text">Event ID - <strong>'.htmlspecialchars($row['event_id']).'</strong></p>
                        <div class="formblock">
                            <label for="inptext">Event Name</label>
                            <input type="text" id="inptext" class="inptext" name="eventname" value="' .htmlspecialchars($row['event_name']).'" />
                            <p class="warning">
                                <?php echo htmlspecialchars($error["eventname"]); ?>
                            </p>
                        </div>';

                        echo '
                        <div class="formblock">
                            <label for="inpdesc">Event Description</label>
                            <textarea class="inpdesc" id="inpdesc" name="eventdescription">'.htmlspecialchars($row['event_description']).'</textarea>
                            <p class="warning">
                                <?php echo htmlspecialchars($error["eventdescription"]); ?>
                            </p>
                        </div>';

                        echo '
                        <div class="formblock">
                            <label for="inpselect">Choose the college</label>
                            <select id="inpselect" class="inpselect" name="collegecode">
                                ';?>
                            <?php
                                    if(mysqli_num_rows($collegenames) > 0) {
                                        while($rows = mysqli_fetch_assoc($collegenames)) {
                                            if($row['college'] == $rows['college_code']) {
                                                echo "<option value=".$rows['college_code']." selected>".$rows['college_code'].' - '.$rows['college_name'].'</option>';
                                            } else {
                                                echo "<option value=".$rows['college_code'].">".$rows['college_code'].' - '.$rows['college_name'].'</option>';
                                            }
                                        }
                                    }
                            ?>
                            <?php echo'
                                </select>
                                <p class="warning">
                                    <?php echo htmlspecialchars($error["collegecode"]); ?>
                                </p>
                            </div>';

                        echo '
                        <div class="formblock">
                            <label for="inpdate">Event Date</label>
                            <input type="date" class="inpdate" name="eventdate" value="'.htmlspecialchars($row['event_date']).'" />
                            <p class="warning">
                                <?php echo htmlspecialchars($error["eventdate"]); ?>
                            </p>
                        </div>';


                        echo '
                        <div class="btn-group">
                            <input type="reset" class="formbtn reset" name="reset" value="Reset" />
                            <input type="submit" class="formbtn" name="submit" value="Submit info ✔" />
                        </div>';



                        }
                    } else {
                        echo '<p class="warning">Oops, We occured a error.</p>';
                    }
                ?>
            </form>
        </main>
        <div class="sidebar">
            <ul class="side-links">
                <?php
                    if(mysqli_num_rows($adminResult) > 0) {
                        while($row = mysqli_fetch_assoc($adminResult)) {
                            echo '
                                <li class="side-link">Name: <strong>'.$row['firstname'].' '.$row['lastname'].'</strong> (Admin)</li>
                                <li class="side-link">Email ID: <strong>'.$row['email'].'</strong></li>
                            
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