<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
require'data-verify.php';
$keyword=EUInc::SqlCheck($_GET["keyword"]);
if(EUData::ModTable("cms_search")):
    $searchdata=EUData::SearchData($keyword);
    echo json_encode($searchdata,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);        
else:
    echo'[{"error":1}]';
endif;