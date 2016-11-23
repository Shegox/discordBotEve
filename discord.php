<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.07.2016
 * Time: 16:19
 */

session_start();
include_once __DIR__ ."./php/discord/discordAuth.php";
include_once __DIR__ ."./php/discord/discordBotAuth.php";
include_once __DIR__ ."./php/sql.php";

$access_token = getTokensFromCode($_GET ["code"],"authorization_code")->access_token;
$user = curl_get("https://discordapp.com/api/users/@me",$access_token);
$user->username = addslashes($user->username);

$sql = "UPDATE auth SET DiscordID='{$user->id}',discriminator='{$user->discriminator}',username='{$user->username}' WHERE token='{$_SESSION["token"]}'";
sql_write($sql);

$join = joinServer($GLOBALS["DISCORD_INVITE"],$access_token);
print_r($join);

print_r($access_token);
print_r($_SESSION);


setNickname($_SESSION["eve"]["char"]["characterName"],$user->id);

$sql = "SELECT * FROM `groupRoles` WHERE {$_SESSION["eve"]["char"]["characterID"]} = groupID or {$_SESSION["eve"]["char"]["corporationID"]} = groupID or {$_SESSION["eve"]["char"]["allianceID"]} = groupID";
$res = sql_read($sql);
var_dump($res);

$roles = [];
foreach ($res as $role)
{
    $roles[] = $role["roleID"];
}
var_dump($roles);
patchUser($roles,$user->id);
header("Location: https://discordapp.com/channels/{$join->guild->id}");

session_write_close();

