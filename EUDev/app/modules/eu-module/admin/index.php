<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=$_GET["do"];
/**
 * 载入已安装模块
 */
$app->Runin("module",EUData::QueryData("cms_module","","bid>0","id asc","")["querydata"]);
/**
 * 载入模板
 */
$app->Open("index.cms");
if($do=="uninstall"){
    $mid=str_replace(".","",EUInc::SqlCheck($_GET["mid"]));
    $modconfig=APP_ROOT."/modules/".$mid."/essentialunified.config";
    $mods=file_get_contents($modconfig);
    $uninstallsql=EUInc::StrSubstr("<uninstallsql><![CDATA[","]]></uninstallsql>",$mods);
    EUData::DelData("cms_module","mid='$mid'");
    $role=EUData::QueryData("cms_admin_role","","","","")["querydata"];
    foreach($role as $rows):
        $role_range=EUData::QueryData("cms_admin_role","","id='".$rows["id"]."'","","")["querydata"][0]["module"];
        $new_range=rtrim(str_replace(",,",",",str_replace($mid,"",$role_range)),",");
        EUData::UpdateData("cms_admin_role",array("module"=>$new_range),"id='".$rows["id"]."'");
    endforeach;
    if($uninstallsql=='0'):
        EUInc::DelDir(APP_ROOT."/modules/".$mid);
        echo"<script>alert('成功卸载模块!');window.location.href='?m=eu-module'</script>";
    else:
        if(EUData::RunSql($uninstallsql)):
            EUInc::DelDir(APP_ROOT."/modules/".$mid);
            echo"<script>alert('成功卸载模块!');window.location.href='?m=eu-module'</script>";
        else:
            echo"<script>alert('模块卸载失败!');window.location.href='?m=eu-module'</script>";
        endif;   
    endif;
}