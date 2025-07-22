<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
/**
 * 传递参数过程
 */
$do=EUInc::SqlCheck($_GET["do"]);
/**
 * 载入模板
 */
$app->Open("sql.cms");
/**
 * SQL查询
 */
if($do=="sql"){
    $sql=$_POST['sql'];
    if(!empty($sql)){
        $res=EUData::RunSql($sql);
        if($res){
            echo "<script>alert('SQL执行成功!');window.location.href='?m=eu-data&p=sql'</script>";	
        }else{
            echo "<script>alert('SQL执行失败!');window.location.href='?m=eu-data&p=sql'</script>";
        }
    }else{
        echo "<script>alert('SQL执行失败!关键语句为空!');window.location.href='?m=eu-data&p=sql'</script>";
    }
}