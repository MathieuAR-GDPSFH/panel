<?php
session_start();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["access_token"])) {
    header("Location: /auth/login.php");
    die();
}

$gdps_name = "Error";
$gdps_curl = "Error";

function check_gdps_owner($user_id) {
    if (!isset($_GET["gdpsid"]) || $_GET["gdpsid"] == "") {
        exit("No gdps id specified.\n\n");
    }

    $check_url = "http://127.0.0.1:30458/gdpsmanagementperm?user_id=".$_SESSION["user_id"]."&gdps_id=".$_GET["gdpsid"];
    $check_curl = curl_init($check_url);
    curl_setopt($check_curl, CURLOPT_URL, $check_url);
    curl_setopt($check_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($check_curl, CURLOPT_FOLLOWLOCATION, true);

    $check_resp = curl_exec($check_curl);
    curl_close($check_curl);
    $check_response = json_decode($check_resp, true);

    if (!$check_response["success"]) {
        exit($check_response["message"]);
        die();
    }

    global $gdps_name;
    global $gdps_curl;
    $gdps_name = $check_response["gdps_name"];
    $gdps_curl = $check_response["gdps_custom_url"];
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$avatar = $_SESSION["avatar"];
$access_token = $_SESSION["access_token"];
$staff_permissions = $_SESSION["staff_permissions"];
$api_url = "http://127.0.0.1:30458";
$website_url = "http://localhost";
?>