<?php
require dirname(dirname(dirname(dirname(__FILE__)))).'/'.'config.php';
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedSockets\EUSockets;
$config=EUInc::GetConfig();
$socket=new EUSockets($config["SOCKETS_HOST"],$config["SOCKETS_PORT"]);