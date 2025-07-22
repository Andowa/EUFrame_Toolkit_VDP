<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
require'data-verify.php';
$table=EUInc::SqlCheck($_POST["table"]);
$where=$_POST["where"];
$action=EUInc::SqlCheck($_POST["action"]);
$data=array_diff_key($_POST,array("table"=>$table,"where"=>$where,"action"=>$action));
if(EUData::ModTable($table)):
	if(empty($action) || $action=="add"):
		if(EUData::InsertData($table,$data)):
			echo'[{"error":0}]';
		else:
			echo'[{"error":1}]';
		endif;
	elseif($action=="mon"):
		if(EUData::UpdateData($table,$data,$where)):
			echo'[{"error":0}]';
		else:
			echo'[{"error":1}]';
		endif;
	elseif($action=="del"):
		if(EUData::DelData($table,$where)):
			echo'[{"error":0}]';
		else:
			echo'[{"error":1}]';
		endif;
	endif;		
else:
	echo'[{"error":1}]';
endif;