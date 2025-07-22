<?php
use library\EssentialUnifiedData\EUData;
/**
 * 写入数据
 */
$app->Runin("datalist",EUData::QueryData("cms_admin_role","","","id desc","")["querydata"]);
/**
 * 载入模板
 */
$app->Open("role.cms");