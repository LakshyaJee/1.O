<?php
// Check if lectureCode is provided in the query string
if(isset($_GET['lectureCode'])){
    // Get the lectureCode from the query string
    $lecture_code = $_GET['lectureCode'];

    // Construct the LectureUrl using the provided lectureCode
    $lecture_url = "https://d1d34p8vz63oiq.cloudfront.net/${lecture_code}/master.mpd";

    // Redirect to the 1dm application with the link to the lecture
    $redirect_url = "intent://$lecture_url#Intent;package=idm.internet.download.manager;end";

    // Redirect the user to the 1dm application
    header("Location: $redirect_url");
    exit;
} else {
    // If lectureCode is not provided in the query string, return an error message
    echo "lectureCode parameter is missing in the query string.";
}
?>
