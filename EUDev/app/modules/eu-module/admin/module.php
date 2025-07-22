<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=$_GET["do"];
/**
 * 载入私有模块
 */
$app->Runin("private_mod",EUInc::GetMod());
/**
 * 载入第三方模块
 */
$app->Runin("pubilc_mod",EUInc::GetMod(1));
/**
 * 载入订购模块
 */
$app->Runin("buy_mod",EUInc::GetMod(2));
/**
 * 载入模板
 */
$app->Open("module.cms");
if($do=="install"){
    $t=$_GET["t"];
    $mid=str_replace(".","",EUInc::SqlCheck($_GET["mid"]));
    if($t!="s"):
        if($t=="g"):
            $down=EUInc::Auth($config["EUCODE"],$config["EUFURL"],"module-".$mid);
        elseif($t=="b"):  
            $down=EUInc::Auth($config["EUCODE"],$config["EUFURL"],"moduleorder-".$mid);
        endif;
        $downurl=EUInc::StrSubstr("<downurl>","</downurl>",$down);
        $filename=basename($downurl);
        $res=EUInc::SaveFile($downurl,APP_ROOT."/modules",$filename,1);
        if(!empty($res)):
            EUInc::Auth($config["EUCODE"],$config["EUFURL"],"moduledel-".str_replace(".zip","",$filename)."");
            $zip=new ZipArchive;
            if($zip->open(APP_ROOT."/modules/".$filename)===TRUE): 
                $zip->extractTo(APP_ROOT."/modules/");
                $zip->close();
                unlink(APP_ROOT."/modules/".$filename);
            else:
                echo "<script>alert('modules目录775权限不足!');window.location.href='?m=eu-module&p=module'</script>";
               exit();
            endif;
        else:
            echo "<script>alert('安装权限不足!');window.location.href='?m=eu-module&p=module'</script>";
            exit();
        endif;
    endif;
    $modconfig=APP_ROOT."/modules/".$mid."/essentialunified.config";
    $mods=file_get_contents($modconfig);
    $modname=EUInc::StrSubstr("<modname>","</modname>",$mods);
    $ordernum=EUInc::StrSubstr("<ordernum>","</ordernum>",$mods);
    $modurl=EUInc::StrSubstr("<modurl>","</modurl>",$mods);
    $befoitem=EUInc::StrSubstr("<befoitem>","</befoitem>",$mods);
    $backitem=EUInc::StrSubstr("<backitem>","</backitem>",$mods);
    $itemid=EUInc::StrSubstr("<itemid>","</itemid>",$mods);
    $installsql=EUInc::StrSubstr("<installsql><![CDATA[","]]></installsql>",$mods);
    $role=EUData::QueryData("cms_admin_role","","","","")["querydata"];
    foreach($role as $rows):
        $role_range=EUData::QueryData("cms_admin_role","","id='".$rows["id"]."'","","")["querydata"][0]["module"];
        $new_range=$role_range.",".$mid;
        EUData::UpdateData("cms_admin_role",array("module"=>$new_range),"id='".$rows["id"]."'");
    endforeach;
    if(EUData::QueryData("cms_module","","mid='$mid'","","1")["querynum"]>0):
        EUData::UpdateData("cms_module",array(
            "bid"=>$itemid,
            "modname"=>$modname,
            "modurl"=>$modurl,
            "befoitem"=>$befoitem,
            "backitem"=>$backitem),"mid='$mid'");
    else:
        EUData::InsertData("cms_module",array(
            "bid"=>$itemid,
            "mid"=>$mid,
            "modname"=>$modname,
            "modurl"=>$modurl,
            "isopen"=>1,
            "look"=>1,
            "ordernum"=>$ordernum,
            "befoitem"=>$befoitem,
            "backitem"=>$backitem));
    endif;
    if($installsql=='0'):
        echo"<script>alert('成功安装模块!');window.location.href='?m=eu-module&p=module'</script>";
    else:
        if(EUData::RunSql($installsql)):
            echo"<script>alert('成功安装模块!');window.location.href='?m=eu-module&p=module'</script>";
        else:
            echo"<script>alert('模块安装失败!');window.location.href='?m=eu-module&p=module'</script>";
        endif;   
    endif;
}