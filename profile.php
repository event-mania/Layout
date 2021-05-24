<?php
    require("./conn.php");
    session_start();
    if(!(isset($_SESSION['student_id']))) {
        header("location: login.php");
    } else {
        $profileID = $_SESSION['student_id'];
    }
    // echo $profileID;

    $events_sql = "SELECT * FROM event_details INNER JOIN available_college ON event_details.isEventDeleted = 0 AND event_details.college = available_college.college_code WHERE isEventApproved = 1";
    $result = $conn->query($events_sql);
    // $validevents = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $student_sql = "SELECT * FROM student WHERE student_id = '$profileID'";
    $studentResult = $conn->query($student_sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="./styles/index.css">
    <title>Event Mania</title>
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
            <h2 class="evetitle">List of available events</i>
</h2>
            <?php
                if(mysqli_num_rows($result) > 0) {

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <article class="event">
                        ';
                        ?>
                        <?php
                            if($row['isImageSet'] == 1) {
                                echo "<img src='./images/uploads/".$row['event_id'].".jpg' class='event_img' alt=".$row['event_name']." />";
                            } else {
                                echo '<img src="https://picsum.photos/200/200?" class="event_img" alt="'.$row["event_name"].'" />';
                            }
                            echo '
                            <div class="event_description">
                                <h2 class="title">'.htmlspecialchars($row["event_name"]).'</h2>
                                <p class="description">'.htmlspecialchars($row["event_description"]).'</p>
                                <p class="venue"><i class="fas fa-map-marker-alt marker"></i> '.htmlspecialchars($row['college_name']).', '.$row['city'].'</p>
                                <p class="time"><i class="far fa-clock clock"></i> '.htmlspecialchars($row['event_date']).'</p>
                                <button class="btn"><i class="fa fa-plus"></i> Participate now</button>
                            </div>
                        </article>';
                    }
                }
            ?>
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
                <li class="side-link"><i class="fa fa-plus"></i> <a href="./create-event.php">Create Event</a></li>
                <li class="side-link"><i class="fas fa-sign-out-alt"></i> <a href="./logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <?php require('./includes/footer.php'); ?>
    <script src=".//scripts/scroll_indicator.js"></script>
    <!-- <script src="./scripts/carousel.js"></script> -->
</body>

</html>