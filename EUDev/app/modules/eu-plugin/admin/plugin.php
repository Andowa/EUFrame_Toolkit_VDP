<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=$_GET["do"];
/**
 * 载入私有插件
 */
$app->Runin("private_plugin",EUInc::GetPlugin());
/**
 * 载入第三方插件
 */
$app->Runin("pubilc_plugin",EUInc::GetPlugin(1));
/**
 * 载入订购插件
 */
$app->Runin("buy_plugin",EUInc::GetPlugin(2));
/**
 * 载入模板
 */
$app->Open("plugin.cms");
if($do=="install"){
    $t=$_GET["t"];
    $pid=str_replace(".","",EUInc::SqlCheck($_GET["pid"]));
    if($t!="s"):
        if($t=="g"):
            $down=EUInc::Auth($config["EUCODE"],$config["EUFURL"],"plugin-".$pid);
        elseif($t=="b"):  
            $down=EUInc::Auth($config["EUCODE"],$config["EUFURL"],"pluginorder-".$pid);
        endif;
        $downurl=EUInc::StrSubstr("<downurl>","</downurl>",$down);
        $filename=basename($downurl);
        $res=EUInc::SaveFile($downurl,APP_ROOT."/plugins",$filename,1);
        if(!empty($res)):
            EUInc::Auth($config["EUCODE"],$config["EUFURL"],"plugindel-".str_replace(".zip","",$filename)."");
            $zip=new ZipArchive;
            if($zip->open(APP_ROOT."/plugins/".$filename)===TRUE): 
                $zip->extractTo(APP_ROOT."/plugins/");
                $zip->close();
                unlink(APP_ROOT."/plugins/".$filename);
            else:
               echo "<script>alert('plugins目录775权限不足!');window.location.href='?m=eu-plugin&p=plugin'</script>";
               exit();
            endif;
        else:
            echo "<script>alert('安装权限不足!$downurl');window.location.href='?m=eu-plugin&p=plugin'</script>";
            exit();
        endif;
    endif;    
    $pconfig=APP_ROOT."/plugins/".$pid."/essentialunified.config";
    $plugins=file_get_contents($pconfig);
    $type=EUInc::StrSubstr("<type>","</type>",$plugins);
    $auther=EUInc::StrSubstr("<auther>","</auther>",$plugins);
    $title=EUInc::StrSubstr("<title>","</title>",$plugins);
    $ver=EUInc::StrSubstr("<ver>","</ver>",$plugins);
    $description=EUInc::StrSubstr("<description>","</description>",$plugins);
    $installsql=EUInc::StrSubstr("<installsql><![CDATA[","]]></installsql>",$plugins);
    if(EUData::QueryData("cms_plugin","","pid='$pid'","","1")["querynum"]>0):
        EUData::UpdateData("cms_plugin",array(
            "type"=>$type,
            "auther"=>$auther,
            "title"=>$title,
            "ver"=>$ver,
            "description"=>$description),"pid='$pid'");
    else:
        EUData::InsertData("cms_plugin",array(
            "pid"=>$pid,
            "type"=>$type,
            "auther"=>$auther,
            "title"=>$title,
            "ver"=>$ver,
            "description"=>$description));
    endif;
    if($installsql=='0'):
        echo"<script>alert('成功安装插件!');window.location.href='?m=eu-plugin&p=plugin'</script>";
    else:
        if(EUData::RunSql($installsql)):
            echo"<script>alert('成功安装插件!');window.location.href='?m=eu-plugin&p=plugin'</script>";
        else:
            echo"<script>alert('插件安装失败!');window.location.href='?m=eu-plugin&p=plugin'</script>";
        endif;   
    endif;
}