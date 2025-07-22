<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$app->Runin("apikey",md5($config["EUCODE"]));
$app->Runin("data",EUData::QueryData("cms_api_set","","","","1")["querydata"]);
$app->Open("index.cms");
if($_GET["do"]=="config"):
    $id=EUInc::SqlCheck($_POST["id"]);
    $white=EUInc::SqlCheck($_POST["white"]);
    $opentable=EUInc::SqlCheck($_POST["opentable"]);
    $authtable=EUInc::SqlCheck($_POST["authtable"]);
    $authquery=EUInc::SqlCheck($_POST["authquery"]);
    if(EUData::UpdateData("cms_api_set",array(
        "white"=>$white,
        "opentable"=>$opentable,
        "authtable"=>$authtable,
        "authquery"=>$authquery,
    ),"id='$id'")):
        EUInc::GoUrl("?m=eu-api","保存配置成功!");
    else:
        EUInc::GoUrl("-1","保存配置失败!");
    endif;
endif;