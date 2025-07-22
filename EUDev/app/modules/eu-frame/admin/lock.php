<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$u=$_GET["u"];
$app->Open("lock.cms");
if($_GET["do"]=="login"){
    $password=EUInc::SqlCheck($_POST["password"]);
    $data=EUData::QueryData("cms_admin","","id='".$_SESSION['admin_id']."'","","");
    if($data["querynum"]==1){
        $rows=$data["querydata"][0];
        $passwords=sha1($rows['salts'].$password);
        if($passwords==$rows['password']){
            setcookie("Lock",0);
            $param=str_replace("____","?",$u);
            $param=str_replace("---","/",$param);
            $param=str_replace("___","&",$param);
            $param=str_replace("__","=",$param);
            EUInc::GoUrl($config["APPURL"]."/app/dev/".$param,"解锁成功!");
        }else{
            EUInc::GoUrl("?p=lock&u=".$u,"解锁失败!");
        }
    }
}