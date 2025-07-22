<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=$_GET["do"];
/**
 * 获取已安装模块
 */
$app->Runin("modules",EUData::QueryData("cms_module","","bid>0","id asc","")["querydata"]);
/**
 * 载入模板
 */
$app->Open("template_creat.cms");
if($do=="save"){
    $module=EUInc::SqlCheck($_POST["module"]);
    $skin=EUInc::SqlCheck($_POST["skin"]);
    $page=EUInc::SqlCheck($_POST["page"]);
    $content=htmlspecialchars_decode($_POST["content"]);
    file_put_contents(APP_ROOT."/modules/".$module."/skin/".$skin."/".$page,$content);
    echo "<script>alert('创建模板成功!');window.location.href='?m=eu-template&p=template_creat'</script>";
}