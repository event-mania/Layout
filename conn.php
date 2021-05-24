<?php
$conn = mysqli_connect('localhost', 'jd', 'jd123', 'event_mania');
if (!$conn) {
    echo "Connection failed" . mysqli_error($conn);
}
?>