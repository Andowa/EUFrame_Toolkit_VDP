<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
/**
 * 官方更新
 */
$app->Runin("updatelog",explode("|",EUInc::Auth($config["EUCODE"],$config["EUFURL"],"update")));
/**
 * AD
 */
$app->Runin("ad",explode("^",explode("|",EUInc::Auth($config["EUCODE"],$config["EUFURL"],"upapi"))[1]));
/**
 * 在线更新
 */
$t=EUInc::sqlcheck($_GET["t"]);
$i=EUInc::sqlcheck(str_replace("..","",$_GET["i"]));
if($t=="update"):
    $url=$config["UPDATEURL"]."/".$i.".zip";
    $save_dir=EUF_ROOT."/update";  
    $filename=basename($url); 
    $res=EUInc::SaveFile($url,$save_dir,$filename,1);
    if(!empty($res)):
        $zip=new ZipArchive;
        if($zip->open(EUF_ROOT."/update/".$i.".zip")===TRUE): 
            $zip->extractTo(EUF_ROOT."/update/");
            $zip->close();
            if(file_exists(EUF_ROOT."/update/".$i."/essentialunified.config")):
                $up=file_get_contents(EUF_ROOT."/update/".$i."/essentialunified.config");
                $thesql=EUInc::StrSubstr("<sql><![CDATA[","]]></sql>",$up);
                $resx=EUData::RunSql($thesql); 
            else:
                $resx=1;
            endif;
            if($resx):
                $olddir=EUF_ROOT."/update/".$i."/";
                EUInc::movedir($olddir,EUF_ROOT);
                EUData::insertData("cms_update",array("updateid"=>$i,"updatetime"=>date('Y-m-d H:i:s',time())));    
                EUInc::deldir(EUF_ROOT."/update/".$i."/");
                unlink(EUF_ROOT."/update/".$i.".zip");
                echo "<script>alert('Online update complete!');window.location.href='?p=update'</script>";
            endif;
        else:
            echo "<script>alert('Decompression failed!');window.location.href='?p=update'</script>";
        endif;
    else:
        echo "<script>alert('Download failed!');window.location.href='?p=update'</script>";
    endif;
endif;
/**
 * 载入模板
 */
$app->Open("update.cms");