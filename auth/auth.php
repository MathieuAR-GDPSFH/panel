<?php
if (isset($_GET["code"])) {
    $oauth_code = $_GET["code"];

    $url = "http://127.0.0.1:30458/discord/oauth/code?code=".$_GET["code"]."&ip=".$_SERVER["HTTP_CF_CONNECTING_IP"];
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

    $resp = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($resp, true);
    if ($response["success"]) {
        session_start();
        $_SESSION["user_id"] = $response["user_id"];
        $_SESSION["username"] = $response["username"];
        $_SESSION["avatar"] = $response["avatar"];
        $_SESSION["access_token"] = $response["access_token"];
        $_SESSION["staff_permissions"] = $response["staff_permissions"];
        header("Location: /index.php");
    } else {
        if (array_key_exists("banned", $response)) {
            exit("You are banned from GDPSFH for: ".$response["message"]);
        }

        exit($response["message"]);
    }
}
exit();
?>