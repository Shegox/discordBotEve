<?php
include_once "./php/config.php";
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.07.2016
 * Time: 14:07bb
 */

echo $GLOBALS["LOGINURLwoSCOPE"];

header("Location: {$GLOBALS["LOGINURLwoSCOPE"]}");
