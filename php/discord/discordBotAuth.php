<?php

include_once __DIR__ ."../config.php";

function bot_curl_get($url, $auth_code = NULL)
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
    if (isset($auth_code)) {
        $headers = array(
            "Authorization: " . $auth_code
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

function patchUser($roles, $userID)
{
    $post = [];
    $post["roles"] = $roles;
    $post = json_encode($post);
    var_dump($post);


    $curl = curl_init();


    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://discordapp.com/api/guilds/164779865315344386/members/$userID",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_POSTFIELDS => $post,
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $GLOBALS["BOT_TOKEN"],
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 63da2827-7f7c-4ceb-fd2c-7e5df8078dd2"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}

function setNickname($name, $userID)
{
    $post = [];
    $post["nick"] = $name;
    $post = json_encode($post);
    var_dump($post);


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://discordapp.com/api/guilds/164779865315344386/members/$userID",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_POSTFIELDS => $post,
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $GLOBALS["BOT_TOKEN"],
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 63da2827-7f7c-4ceb-fd2c-7e5df8078dd2"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }


}

function clearMemberlist($guild_id)
{
    $members = getMembers($guild_id);


    foreach ($members as $member) {
        if (empty($member->roles)) {
            kickUser($guild_id, $member->user->id);
        }


    }


}

function getMembers($guild_id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://discordapp.com/api/guilds/$guild_id/members?limit=1000",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $GLOBALS["BOT_TOKEN"],
            "cache-control: no-cache",
            "postman-token: 3b25f75c-3d0e-df42-89e5-00426c51b303"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return json_decode($response);
    }
}

function kickUser($guild_id, $user_id)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://discordapp.com/api/guilds/$guild_id/members/$user_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "authorization: " . $GLOBALS["BOT_TOKEN"],
            "cache-control: no-cache",
            "postman-token: f00f0c1f-1783-1a47-c789-9a5e0885c582"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}



