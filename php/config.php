<?php
//Crest application
$CLIENTID = "7d1aaefd9e8d41b1b3c43c5ddd212990";
$SECRETKEY = "sec";
$CALLBACKURL = "https://www.warcontacts.tk/untitled/eve.php";

//Discord
$DISCORD_CALLBACKURL = "https://www.warcontacts.tk/untitled/discord.php";
$DISCORD_CLIENTID = "199531243900108801";
$DISCORD_SECRETKEY = "sec";

$DISCORD_INVITE = "sZQQ9Xv";

//Discord Bot
$BOT_TOKEN = "token";

//SQL server
$DATABASE = "eve_auth";
$USER = "bla";
$PASSWORD = "blub";

//Session
$SESSION_TIMEOUT = 100000000;

//EvE Login informations (do not change)
$BASICAUTH = base64_encode("$CLIENTID:$SECRETKEY");
$DISCORD_BASICAUTH = base64_encode("$DISCORD_CLIENTID:$DISCORD_SECRETKEY");


$DISCORD_LOGINURL = "https://discordapp.com/oauth2/authorize?client_id=$DISCORD_CLIENTID&scope=identify guilds.join&permissions=0&response_type=code";
$LOGINURL = "https://login.eveonline.com/oauth/authorize?response_type=code&redirect_uri=$CALLBACKURL&client_id=$CLIENTID&scope=characterContactsWrite+characterContactsRead";
$LOGINURLwoSCOPE = "https://login.eveonline.com/oauth/authorize?response_type=code&redirect_uri=$CALLBACKURL&client_id=$CLIENTID";
