<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedData\EUData;
$do=$_GET["do"];
if($do=="out"){
    unset($_SESSION['admin']);
    unset($_SESSION['adminid']);
    setcookie("Nav","eu-frame");
    echo"<script>alert('登出EU Develop成功!');window.location.href='?p=login'</script>";
}
if($do=="login"){
    $username=EUInc::SqlCheck($_POST["username"]);
    $password=EUInc::SqlCheck($_POST["password"]);
    $code=EUInc::SqlCheck(strtolower($_POST["code"]));
    $ip=EUInc::SqlCheck(EUInc::GetIp());
    if($_SESSION['authcode']==$code){
        if(!empty($username)&&!empty($password)){
            $data=EUData::QueryData("cms_admin","","username='$username'","","");
            if($data["querynum"]==1){
                $rows=$data["querydata"][0];
                $shaupass=sha1($rows['salts'].$password);
                if($shaupass==$rows['password']){
                    EUData::InsertData("cms_admin_log",array("username"=>$username,"ip"=>$ip,"logintime"=>date('Y-m-d H:i:s',time())));
                    $_SESSION['admin']=$rows['username'];
                    $_SESSION['admin_id']=$rows['id'];
                    $_SESSION['admin_roleid']=$rows['roleid'];
                    $_SESSION['admin_avatar']=$rows['avatar'];
                    session_regenerate_id(TRUE);
                    setcookie("Nav","eu-frame");
                    setcookie("Lock",0);
                    echo"<script>alert('登陆EU Develop成功!');window.location.href='?p=index'</script>";
                }else{
                    echo"<script>alert('账户或密码不匹配!');window.history.go(-1);</script>";
                }
            }else{
                echo"<script>alert('账户不存在!');window.history.go(-1);</script>";
            }
        }else{
        echo"<script>alert('账户或密码不能为空!');window.history.go(-1);</script>";
        }
    }else{
    echo"<script>alert('验证码不正确!');window.history.go(-1);</script>";
    }    
}
$app->Open("login.cms");