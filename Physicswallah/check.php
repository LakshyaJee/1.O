<?php
// Check if LectureCode is provided in the query string
if(isset($_GET['lectureCode'])){
    // Get the lectureCode from the query string
    $lecture_code = $_GET['lectureCode'];

    // Construct the LectureUrl using the provided lectureCode
    $lecture_url = "https://d1d34p8vz63oiq.cloudfront.net/${lecture_code}/master.mpd";

    // Add query string to the LectureUrl
    $lecture_url_with_query = $lecture_url . "?param1=value1&param2=value2";

    // Fetch remote MPD content
    $remote_content = file_get_contents($lecture_url_with_query);

    // Check if content is fetched successfully
    if ($remote_content !== false) {
        // Set appropriate headers to allow CORS
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/dash+xml'); // MPD file type

        // Echo the remote content
        echo $remote_content;

        // Redirect to the 1dm application
        header("Location: intent:${remoteurl}#Intent;package=idm.internet.download.manager;end");
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
