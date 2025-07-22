<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
/**
 * 写入服务器信息
 */
$app->Runin("sysinfo",EUInc::GetSystemInfo());
/**
 * 写入更新日志
 */
$app->Runin("updatelog",EUData::QueryData("cms_update","","","updatetime desc","0,5")["querydata"]);
/**
 * 写入登录日志
 */
$app->Runin("loginlog",EUData::QueryData("cms_admin_log","","","logintime desc","0,6")["querydata"]);
/**
 * 载入模板
 */
$app->Open("index.cms");