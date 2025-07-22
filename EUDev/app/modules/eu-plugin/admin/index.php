<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=$_GET["do"];
/**
 * 载入已安装插件
 */
$app->Runin("plugin",EUData::QueryData("cms_plugin","","","id asc","")["querydata"]);
/**
 * 载入模板
 */
$app->Open("index.cms");
if($do=="uninstall"){
    $pid=str_replace(".","",EUInc::SqlCheck($_GET["pid"]));
    $pconfig=APP_ROOT."/plugins/".$pid."/essentialunified.config";
    $plugins=file_get_contents($pconfig);
    $uninstallsql=EUInc::StrSubstr("<uninstallsql><![CDATA[","]]></uninstallsql>",$plugins);
    EUData::DelData("cms_plugin","pid='$pid'");
    if($uninstallsql=='0'):
        EUInc::DelDir(APP_ROOT."/plugins/".$pid);
        echo"<script>alert('成功卸载插件!');window.location.href='?m=eu-plugin'</script>";
    else:
        if(EUData::RunSql($uninstallsql)):
            EUInc::DelDir(APP_ROOT."/plugins/".$pid);
            echo"<script>alert('成功卸载插件!');window.location.href='?m=eu-plugin'</script>";
        else:
            echo"<script>alert('插件卸载失败!');window.location.href='?m=eu-plugin'</script>";
        endif;   
    endif;
}