<?php
use library\EssentialUnifiedCode\EUCode;
$captcha = new EUCode();
$captcha->CreateImage();
$_SESSION['authcode']=$captcha->GetCode();