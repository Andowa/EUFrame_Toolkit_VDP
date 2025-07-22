<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
/**
 * 在建项目
 */
$app->Runin("task",array(EUInc::Auth($config["EUCODE"],$config["EUFURL"],"task")));
/**
 * AD
 */
$app->Runin("ad",explode("^",explode("|",EUInc::Auth($config["EUCODE"],$config["EUFURL"],"upapi"))[1]));
/**
 * 载入模板
 */
$app->Open("task.cms");