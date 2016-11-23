<?php

include_once __DIR__ ."../config.php";

function getTokensFromCode($code, $grant_type)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://discordapp.com/api/oauth2/token");
    // Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Does not verify peer
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POST, 1);

    // $BASICAUTH = global $BASICAUTH;
    $headers = array(
        "Authorization: Basic {$GLOBALS["DISCORD_BASICAUTH"]}",
        "Content-type: application/x-www-form-urlencoded"
    );
    // headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $post ["grant_type"] = "authorization_code";
    $post ["code"] = $code;
    // grant_type = authorization_code ; initial request
    // grant_type = refresh_token; for request with refresh_token
    if ($grant_type == "refresh_token") {
        $parameter = "refresh_token";
    } elseif ($grant_type == "authorization_code") {
        $parameter = "code";
    }
    /** @noinspection PhpUndefinedVariableInspection */
    $redirect_uri = $GLOBALS["DISCORD_CALLBACKURL"];
    $post = "grant_type=$grant_type&$parameter=$code&redirect_uri=$redirect_uri";
    // echo $post;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response);
    //print_r($response);
    return $response;
}

function curl_get($url, $auth_code = NULL)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    // Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Does not verify peer
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Get the response and close the channel.
    if (isset($auth_code))
    {
        $headers = array(
            "Authorization: Bearer " . $auth_code
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $response = curl_exec($ch);
    if (curl_getinfo($ch) ["http_code"] != 200) {
        http_response_code(curl_getinfo($ch) ["http_code"]);
        echo "Error";
        echo " HTTP_CODE:" . curl_getinfo($ch) ["http_code"];
        print_r(curl_getinfo($ch));
        print_r($response);
    }
    curl_close($ch);
    $response = json_decode($response);
    return $response;
}

function joinServer($invite,$access_token)
{


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://discordapp.com/api/invites/$invite",
    CURLOPT_RETURNTRANSFER => true,
   CURLOPT_POST=> true,

    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer $access_token",
    ),
));
    $post = "";
    // echo $post;
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    return json_decode($response);
}
}
