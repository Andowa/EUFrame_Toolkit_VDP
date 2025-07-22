<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedLang\EULang;
$do=$_GET["do"];
/**
 * 语言数组
 */
$app->Runin("lang",EULang::GetLang());
/**
 * 默认语言
 */
$app->Runin("lang_default",$config["LANG"]);
/**
 * 语言选项
 */
$app->Runin("lang_option",explode(",",$config["LANG_OPTION"]));
/**
 * 载入模板
 */
$app->Open("lang.cms");
if($do=="setup"){
    $lang_default = EUInc::SqlCheck($_POST["lang_default"]);
    $lang_option = EUInc::SqlCheck(implode(",",$_POST["lang_option"]));
    $info = file_get_contents(EUF_ROOT."/.eu.config");
    $info = preg_replace("/LANG=(.*)/","LANG={$lang_default}",$info);
    $info = preg_replace("/LANG_OPTION=(.*)/","LANG_OPTION={$lang_option}",$info);
    file_put_contents(EUF_ROOT."/.eu.config",$info);
    echo'<script>swal("", "保存配置成功!");setTimeout(function(){window.location.href="?m=eu-system&p=lang";},2000)</script>';
}