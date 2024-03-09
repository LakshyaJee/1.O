<?php
// Check if lectureCode is provided in the query string
if(isset($_GET['lectureCode'])){
    // Get the lectureCode from the query string
    $lecture_code = $_GET['lectureCode'];

    // Construct the lectureURL using the provided lectureCode
    $lecture_url = "https://d1d34p8vz63oiq.cloudfront.net/${lecture_code}/master.mpd";

    // Set appropriate headers to allow CORS
    header('Access-Control-Allow-Origin: *');

    // Fetch remote MPD content
    $remote_content = file_get_contents($lecture_url);

    // Check if content is fetched successfully
    if ($remote_content !== false) {
        // Redirect to the accessed lecture_url in the 1dm browser
        $redirect_url = "intent:${lecture_url}#Intent;package=idm.internet.download.manager;end";
        header("Location: $redirect_url");
        exit;
    } else {
        // Handle error if content cannot be fetched
        echo "Error fetching remote content.";
    }
} else {
    // If lectureCode is not provided in the query string, return an error message
    echo "lectureCode parameter is missing in the query string.";
}
?>
