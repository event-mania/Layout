<?php
    require("./conn.php");
    session_start();
    if(!(isset($_SESSION['admin_id']))) {
        header("location: login.php");
    } else {
        $admin_id = $_SESSION['admin_id'];
    }


    $events_sql = "SELECT * FROM event_details
                        INNER JOIN available_college ON event_details.isEventDeleted = 0 AND event_details.college = available_college.college_code
                        INNER JOIN student ON event_details.organizer = student.student_id";
    $result = $conn->query($events_sql);



    $admin_sql = "SELECT * FROM admin_user WHERE admin_id = '$admin_id'";
    $adminResult = $conn->query($admin_sql);


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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin Panel</title>
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
        <h2 class="evetitle">List of all available events</h2>
            <?php
                if(mysqli_num_rows($result) > 0) {

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <article class="event" data-event="'.$row['event_id'].'">
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
                                <p class="email"><i class="fas fa-envelope envelope"></i> '.htmlspecialchars($row['email_id']).' </p>
                                <p class="mobile"><i class="fas fa-mobile mobile"></i> (+91) '.htmlspecialchars($row['mobile_no']).'</p>
                                <div class="btn-group">
                                    <a class="btn edit" href="./edit-event.php?eventid='.$row['event_id'].'">Edit ✏</a>
                        ';
                    ?>
                    <?php
                        echo "<span class='apprvel' data-event=".$row['event_id'].">";
                            if($row['isEventApproved'] == 0) {
                                echo '<button class="btn apprv" data-event="'.$row['event_id'].'">Approve ✔</button>&nbsp;<button class="btn rej" data-event="'.$row['event_id'].'">Reject ✖</button>';
                            } else {
                                echo '<button class="btn ntapprv">Approved ✅</button>&nbsp;';
                            }
                            echo '</span></div>
                            </div>
                        </article>';
                    }
                }
            ?>
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

<!-- Approving the Event -->
<script type="text/javascript">
    $(".apprv").click(function(){
        $($(this).parent()).load("approve-event.php", {
            eventid : $(this).data('event')
        });
    });
</script>


<!-- Rejecting the event -->
<script type="text/javascript">
    $(".rej").click(function() {
        $($(this).parent().parent().parent().parent()).load("rejectevent.php", {
            eventid: $(this).data('event')
        });
    });
</script>