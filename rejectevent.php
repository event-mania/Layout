<?php
    session_start();
    require('./conn.php');
    if(!(isset($_SESSION['admin_id']))) {
        header("location: login.php");
    } else {
        $admin_id = $_SESSION['admin_id'];
    }

    if(isset($_POST['eventid'])) {
        $eventid = $_POST['eventid'];


        $approveSQL = "UPDATE event_details SET isEventDeleted = '1' WHERE event_id = $eventid";
        $result = mysqli_query($conn, $approveSQL);

        if($result) {
            echo '<script type="text/javascript">
            swal("Done", "The Event is rejected!", "info");
            el = document.querySelector("[data-event=\''.$eventid.'\']");
            el.style.display="none";
            </script>';
        } else {
            echo '<script type="text/javascript">
            swal("Oops", "We encountered a problem", "warning");
            </script>';
        }

    } else {
        header("location: admin.php");
    }
?>