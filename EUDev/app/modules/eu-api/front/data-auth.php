<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
use library\EssentialUnifiedWechat\EUWechat;
use library\EssentialUnifiedAliopen\EUAliopen;
require'data-verify.php';
if(EUData::ModTable("cms_routine")):
    $set=EUData::QueryData("cms_routine","","","","1")["querydata"][0];
    $code=EUInc::SqlCheck($_GET["code"]);
    $action=EUInc::SqlCheck($_GET["action"]);
    if($action=="wechat"):
        $result=file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=".$set["wxrteid"]."&secret=".$set["wxrtesecret"]."&js_code=".$code."&grant_type=authorization_code");
    elseif($action=="wechat-crypt"):
        $encrypteddata=$_POST["encrypteddata"];
        $iv=$_POST["iv"];
        $openid=EUInc::SqlCheck($_POST["openid"]);
        $thirdkey=$_POST["thirdkey"];
        $wxin=new EUWechat($set["wxappline"],$set["wxrteid"],$set["wxrtesecret"]);
        $errcode=$wxin->DecryptData($thirdkey,$encrypteddata,$iv,$data);
        if($errcode==0):
            $result=$data;
        else:
            $result=$errcode;
        endif;
    elseif($action=="alipay"):
        $ali=new EUAliopen($set["alrteid"],$set["alapppubkey"],$set["alpaypubkey"]);
        $result=$ali->ApiRequest("alipay.system.oauth.token",array("grant_type"=>"authorization_code","code"=>$code));
    else:
        $appid="";
        $appkey="";
        $result="0";
    endif;
    echo$result;
else:
    echo'[{"error":1}]';
endif;