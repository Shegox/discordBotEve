<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.07.2016
 * Time: 20:16
 */
include_once __DIR__ ."/php/discord/discordBotAuth.php";
include_once __DIR__ ."/php/config.php";
include_once __DIR__ . "/php/userInfo.php";
include_once __DIR__ ."/php/sql.php";

$server = 164779865315344386;

$response = sql_read("SELECT DISTINCT `characterID`,`corporationID`,`allianceID`,`DiscordID` FROM `auth` WHERE 1");#

foreach ($response as $user) {
    var_dump($user);

    $userinfo = getCharGroup($user["characterID"]);


    if (!empty($userinfo)) {
        $corp = getCorpData($userinfo["corporationID"]);
        $userinfo["characterName"] = (String) addslashes ("[".$corp->ticker."] ".$userinfo["characterName"]);

        var_dump($userinfo);
        $userinfo["corporation"] = addslashes($userinfo["corporationName"]);
        $userinfo["alliance"] = addslashes($userinfo["allianceName"]);
        var_dump($userinfo);


        if ($userinfo["corporationID"] != $user["corporationID"] || $userinfo["allianceID"] != $user["allianceID"]) {
            $sql = "UPDATE auth SET  characterName = '{$userinfo["characterName"]}',corporationID = '{$userinfo["corporationID"]}',corporation = '{$userinfo["corporation"]}', allianceID = '{$userinfo["allianceID"]}',alliance = '{$userinfo["alliance"]}' WHERE characterID = '{$userinfo["characterID"]}'";

            echo $sql;
            sql_write($sql);
            var_dump($userinfo["characterName"]);
           setNickname( (String) $userinfo["characterName"],$user["DiscordID"]);

        }


        $sql = "SELECT * FROM `groupRoles` WHERE {$userinfo["characterID"]} = groupID or {$userinfo["corporationID"]} = groupID or {$userinfo["allianceID"]} = groupID";
        $res = sql_read($sql);
        var_dump($res);
        if ($user["DiscordID"] != 0) {
            $roles = [];
            foreach ($res as $role) {
                $roles[] = $role["roleID"];
            }
            var_dump($roles);
            patchUser($roles, $user["DiscordID"]);
        }
    }
}

clearMemberlist($server);
