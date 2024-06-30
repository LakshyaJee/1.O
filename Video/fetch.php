Python 3.12.3 (tags/v3.12.3:f6650f9, Apr  9 2024, 14:05:25) [MSC v.1938 64 bit (AMD64)] on win32
Type "help", "copyright", "credits" or "license()" for more information.
<?php
// Enable CORS if you are accessing this PHP script from a different domain
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

function fetchDRMData($key) {
    $url = "https://devjisu.com/drm/fetch.php?key=${key}&type=lecture&slug=null";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return json_encode(["error" => $error_msg]);
    }

    curl_close($ch);
    return $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['key'])) {
        $key = $_GET['key'];
        $drmData = fetchDRMData($key);
        echo $drmData;
    } else {
        echo json_encode(["error" => "Key parameter is missing"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
