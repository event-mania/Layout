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
        $approveSQL = "UPDATE event_details SET isEventApproved = '1' WHERE event_id = $eventid";
        $result = mysqli_query($conn, $approveSQL);

		if(!$result) {
		    echo "Execpected error occured";
		} else {
            echo '<button class="btn ntapprv">Approved ✅</button>&nbsp;
                <script type="text/javascript">
                    swal("Yayy", "The Event is approved!", "success");
                </script>
            ';
        }
    } else {
        header("location: admin.php");
    }
?>