<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
require'data-verify.php';
$table=EUInc::SqlCheck($_POST["table"]);
$field=empty($_POST["field"]) ? "" : EUInc::SqlCheck($_POST["field"]);
$where=empty($_POST["where"]) ? "" : $_POST["where"];
$limit=empty($_POST["limit"]) ? "" : EUInc::SqlCheck($_POST["limit"]);
$order=empty($_POST["order"]) ? "" : EUInc::SqlCheck($_POST["order"]);
$lg=empty($_POST["lang"]) ? 0 : EUInc::SqlCheck($_POST["lang"]);
if(EUData::ModTable($table)):
    $data=EUData::QueryData(
        $table,
        $field,
        $where,
        $order,
        $limit,
        $lg
    );
    $querydata=$data["querydata"];
    echo json_encode($querydata,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);	
else:
	echo'[{"error":1}]';
endif;