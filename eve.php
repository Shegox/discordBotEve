<?php

session_start();
session_unset();
include_once __DIR__ ."./php/userInfo.php";
include_once __DIR__ ."./php/crest.php";
include_once __DIR__ ."./php/sql.php";
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.07.2016
 * Time: 14:01
 */


$_SESSION["token"] = $_GET["code"];
$_SESSION["eve"]["access_token"] = getTokensFromCode($_GET ["code"],"authorization_code")->access_token;
$_SESSION["eve"]["char"] = [];

$char = getUserInfo($_SESSION["eve"]["access_token"]);
$corp = getCorpData($char["corporationID"]);

$char["characterName"] = addslashes ("[".$corp->ticker."] ".$char["characterName"]);
$char["corporationName"] = addslashes ($char["corporationName"]);
$char["allianceName"] = addslashes ($char["allianceName"]);
$_SESSION["eve"]["char"]["characterName"] = (String) $char["characterName"];
$_SESSION["eve"]["char"]["corporationName"] = (String) $char["corporationName"];
$_SESSION["eve"]["char"]["allianceName"] = (String) $char["allianceName"];
$_SESSION["eve"]["char"]["characterID"] = (String) $char["characterID"];
$_SESSION["eve"]["char"]["corporationID"] = (String) $char["corporationID"];
$_SESSION["eve"]["char"]["allianceID"] = (String) $char["allianceID"];
$sql = "INSERT INTO auth (characterID,characterName,corporationID,corporation,allianceID,alliance,token) VALUES ('{$char["characterID"]}','{$char["characterName"]}','{$char["corporationID"]}','{$char["corporationName"]}','{$char["allianceID"]}','{$char["allianceName"]}','{$_GET ["code"]}')";
//echo $sql;
sql_write($sql);
//var_dump($corp);

//print_r($_SESSION);
//echo $GLOBALS["DISCORD_LOGINURL"];

header("Location: {$GLOBALS["DISCORD_LOGINURL"]}");
session_write_close();
