<?php

// Get the lecture code or dppsSolutionCode from the URL
$lectureCodeId = $_GET['key'];
$dppsSolutionCodeId = $_GET['dppsSolutionCode'];

// Use lectureCodeId if present, otherwise use dppsSolutionCodeId
$codeId = $lectureCodeId ? $lectureCodeId : $dppsSolutionCodeId;

// If codeId is null, it means neither lectureCode nor dppsSolutionCode is present in the URL
if (!$codeId) {
    http_response_code(400);
    echo json_encode(array("error" => "Lecture code or dppsSolutionCode not found in URL"));
    exit;
}

// Construct the URL of the video player page based on the video ID
$url = 'https://d1d34p8vz63oiq.cloudfront.net/' . $codeId . '/master.mpd';

// Fetch HTML content from the URL
$htmlContent = file_get_contents($url);

if (!$htmlContent) {
    http_response_code(500);
    echo json_encode(array("error" => "Failed to fetch HTML content"));
    exit;
}

// Find the script tag containing protData
$scriptPattern = '/<script.*?>(.*?)<\/script>/s';
preg_match_all($scriptPattern, $htmlContent, $matches);

$protData = null;
$encryptionKey = null;

foreach ($matches[1] as $script) {
    if (strpos($script, 'const protData') !== false) {
        $startIndex = strpos($script, 'const protData = ') + strlen('const protData = ');
        $endIndex = strpos($script, ';', $startIndex);
        $protData = json_decode(substr($script, $startIndex, $endIndex - $startIndex), true);
    }
    if (strpos($script, 'const encryptionKey') !== false) {
        $startIndex = strpos($script, 'const encryptionKey = "') + strlen('const encryptionKey = "');
        $endIndex = strpos($script, '";', $startIndex);
        $encryptionKey = substr($script, $startIndex, $endIndex - $startIndex);
    }
}

if (!$protData) {
    http_response_code(500);
    echo json_encode(array("error" => "Script tag containing protData not found"));
    exit;
}

// Response data containing prototype data and encryption key
$responseData = array(
    "protData" => $protData,
    "encryptionKey" => $encryptionKey
);

// Set response headers
header("Content-Type: application/json");

// Return the response as JSON
echo json_encode($responseData);
?>
