<?php
// Check if LectureUrl is provided in the query string
if(isset($_GET['LectureUrl'])){
    // Get the LectureUrl from the query string
    $lecture_url = $_GET['LectureUrl'];

    // Extract lectureCode from the LectureUrl
    $url_parts = parse_url($lecture_url);
    $path_parts = explode('/', $url_parts['path']);
    $lecture_code = $path_parts[count($path_parts) - 2]; // Extracting the second last part of the path

    // Construct the URL to fetch the MPD file
    $remote_url = $lecture_url;

    // Fetch remote MPD content
    $remote_content = file_get_contents($remote_url);

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
    // If LectureUrl is not provided in the query string, return an error message
    echo "LectureUrl parameter is missing in the query string.";
}
?>