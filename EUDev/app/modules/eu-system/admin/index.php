<?php
$do=$_GET["do"];
/**
 * 加载全局配置信息
 */
$app->Runin("config",$config);
/**
 * 载入模板
 */
$app->Open("index.cms");
if($do=="setup"){
    $info = file_get_contents(EUF_ROOT."/.eu.config"); 
    foreach($_POST as $k=>$v){ 
        $info = preg_replace("/{$k}=(.*)/","{$k}={$v}",$info); 
    }
    file_put_contents(EUF_ROOT."/.eu.config",$info);
    echo'<script>swal("", "保存配置成功!");setTimeout(function(){window.location.href="?m=eu-system";},2000)</script>';
}