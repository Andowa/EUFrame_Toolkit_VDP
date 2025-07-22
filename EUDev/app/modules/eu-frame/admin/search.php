<?php
header('content-type:application/json;charset=utf8');
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$key=EUInc::SqlCheck($_POST["key"]);
$data=EUData::QueryData("cms_module","mid,modname,modurl","mid<>'eu-frame' and (mid like '%$key%' or modname like '%$key%' or backitem like '%$key%')","","")["querydata"];
echo json_encode($data);