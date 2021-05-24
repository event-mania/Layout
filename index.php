<!-- 
    TODO: Add Header for filter
    !TODO: Image Caraousel
    !TODO: Footer section
    !TODO: Share links
    !TODO: Navbar Mobile responsive
    !TODO: Mobile Responsiveness
    !TODO: Img size on responsive
    !TODO: Color Updates

    !TODO: Login & Signup
    !TODO: index header text
    !TODO: color update

    !TODO: A single navbar file for each page
    !TODO: A single footer file for each page
    !TODO: Profile Page
    !TODO: Admin Page
    
    
    !TODO: Home Page Events
    !TODO: Add Event Page
    !TODO: Contact Us page
    !TODO: Handling images
    !TODO: Admin event check list with AJAX(jQuery)
    TODO: Encryption of passwords
    TODO: Email service integration
    TODO: Registration of student in a event
    

 -->

<?php
    require("./conn.php");
    $events_sql = "SELECT * FROM event_details INNER JOIN available_college ON event_details.isEventApproved = 1 AND event_details.isEventDeleted = 0 AND event_details.college = available_college.college_code";
    $result = $conn->query($events_sql);


    session_start();
    if(isset($_SESSION['student_id'])) {
        header("location: profile.php");
    }

    if(isset($_SESSION['admin_id'])) {
        header("location: admin.php");
    }


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
    <?php require('./includes/navbar.php'); ?>
    <div class="carousel">
        <div class="slide fade">
            <div class="img img1"></div>
            <div class="text">Compete ⚡</div>
        </div>
        <div class="slide fade">
            <div class="img img2"></div>
            <div class="text">Learn 🤓</div>
        </div>
        <div class="slide fade">
            <div class="img img3"></div>
            <div class="text">Fun 🏅</div>
        </div>
        <a class="previous" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div class="main_area">
        <main class="events_container">
            <h2 class="evetitle">List of available events</h2>
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
                                <h2 class="title">'.$row["event_name"].'</h2>
                                <p class="description">'.$row["event_description"].'</p>
                                <p class="venue"><i class="fas fa-map-marker-alt marker"></i> '.$row['college_name'].', '.$row['city'].'</p>
                                <p class="time"><i class="far fa-clock clock"></i> '.$row['event_date'].'</p>
                                <button class="btn">More info</button>
                            </div>
                        </article>';
                    }
                } else {
                    echo "<h2>Sorry, there are no events available currently.</h2>";
                }
            ?>
        </main>
    </div>
    <?php require('./includes/footer.php'); ?>
    <script src=".//scripts/scroll_indicator.js"></script>
    <script src="./scripts/carousel.js"></script>
</body>

</html>