<?php
header('Content-Type: application/json;charset=utf-8');
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$headers=$_SERVER;
$origin=isset($headers['HTTP_ORIGIN']) ? $headers['HTTP_ORIGIN'] : '';
$referer=$headers["HTTP_REFERER"];
$api=EUData::QueryData("cms_api_set","","","","1")["querydata"][0];
$white=explode(",",$api["white"]);
$opentable=explode(",",$api["opentable"]);
$authtable=$api["authtable"];
$authquery=EUInc::DeSqlCheck($api["authquery"]);
if(EUInc::Contain(parse_url($origin,PHP_URL_HOST),$white)):
    header('Access-Control-Allow-Origin: '.$origin);
endif;
if(!EUInc::Contain($config["APPURL"],$referer) && !EUInc::Contain(parse_url($referer,PHP_URL_HOST),$white)):
    EUInc::GoUrl('','[{"error":"Origin Error"}]');
endif;
if(!isset($headers["HTTP_TOKEN"])):
    EUInc::GoUrl('','[{"error":"Token Empty"}]');
endif;
if(!isset($headers["HTTP_TIME"])):
    EUInc::GoUrl('','[{"error":"Time Empty"}]');
endif;
$token=$headers["HTTP_TOKEN"];
$time=$headers["HTTP_TIME"];
$vtoken=md5(md5($config["EUCODE"]).strtotime($time));
if($token!=$vtoken):
    EUInc::GoUrl('','[{"error":"Token Error"}]');
endif;
if($_POST["action"]=="add" || $_POST["action"]=="mon" || $_POST["action"]=="del"):
    if(!isset($headers["HTTP_SECRET"])):
        EUInc::GoUrl('','[{"error":"Secret Empty"}]');
    endif;
    $secret=explode(",",EUInc::SqlCheck($headers["HTTP_SECRET"]));
    for($i=0;$i<count($secret);$i++):
        $authquery=str_replace("[".$i."]","'".$secret[$i]."'",$authquery);
    endfor;
    $data=EUData::QueryData($authtable,"",$authquery);
    if($data["querynum"]<=0):
        EUInc::GoUrl('','[{"error":"Secret Error"}]');
    endif;
endif;
if(!empty($_POST["table"]) || !empty($_GET["table"])):
    $table=empty($_GET["table"]) ? EUInc::SqlCheck($_POST["table"]) : EUInc::SqlCheck($_GET["table"]);
    if(!in_array($table,$opentable)):
        EUInc::GoUrl('','[{"error":"Not Open Table"}]');
    endif;
endif;