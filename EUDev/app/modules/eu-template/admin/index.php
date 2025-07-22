<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=EUInc::SqlCheck($_GET["do"]);
$data=EUData::QueryData("cms_template","","","","")["querydata"];
/**
 * 载入模板文件管理器
 */
$temp=$app->GetTempFile();
$front_temp=$temp["front"];
$admin_temp=$temp["admin"];
$app->Runin(array("do","tempdata","front","admin"),array($do,$data,$front_temp,$admin_temp));
/**
 * 载入模板
 */
$app->Open("index.cms");
if($do=="front" || $do=="admin"){
    $tempid=EUInc::SqlCheck($_GET["tempid"]);
    $info = file_get_contents(EUF_ROOT."/.eu.config");
    if($do=="front"){
        if(EUData::UpdateData("cms_template",array("makefront"=>0),"id>0")){
            EUData::UpdateData("cms_template",array("makefront"=>1),"tid='$tempid'");
            $info = preg_replace("/TEMPFRONT=(.*)/","TEMPFRONT={$tempid}",$info);
            file_put_contents(EUF_ROOT."/.eu.config",$info);
            EUInc::MoveDir(APP_ROOT."/template/".$tempid."/move",EUF_ROOT);
            EUInc::GoUrl("?m=eu-template&p=index&do=template","变更成功!");
        }else{
            EUInc::GoUrl("-1","变更失败!");
        }
    }else{
        if(EUData::UpdateData("cms_template",array("makeadmin"=>0),"id>0")){
            EUData::UpdateData("cms_template",array("makeadmin"=>1),"tid='$tempid'");
            $info = preg_replace("/TEMPADMIN=(.*)/","TEMPADMIN={$tempid}",$info);
            file_put_contents(EUF_ROOT."/.eu.config",$info);
            EUInc::MoveDir(APP_ROOT."/template/".$tempid."/move",EUF_ROOT);
            EUInc::GoUrl("?m=eu-template&p=index&do=template","设置成功!");
        }else{
            EUInc::GoUrl("-1","设置失败!");
        }
    }
}
if($do=="unfront" || $do=="unadmin"){
    $tempid=EUInc::SqlCheck($_GET["tempid"]);
    $info = file_get_contents(EUF_ROOT."/.eu.config");
    if($do=="unfront"){
        if(EUData::UpdateData("cms_template",array("makefront"=>0),"tid='$tempid'")){
            $info = preg_replace("/TEMPFRONT=(.*)/","TEMPFRONT=0",$info);
            file_put_contents(EUF_ROOT."/.eu.config",$info);
            EUInc::GoUrl("?m=eu-template&p=index&do=template","取消成功!");
        }else{
            EUInc::GoUrl("-1","取消失败!");
        }
    }else{
        if(EUData::UpdateData("cms_template",array("makeadmin"=>0),"tid='$tempid'")){
            $info = preg_replace("/TEMPADMIN=(.*)/","TEMPADMIN=0",$info);
            file_put_contents(EUF_ROOT."/.eu.config",$info);
            EUInc::GoUrl("?m=eu-template&p=index&do=template","取消成功!");
        }else{
            EUInc::GoUrl("-1","取消失败!");
        }
    }
}