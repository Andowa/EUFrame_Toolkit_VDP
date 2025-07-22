<?php
use library\EssentialUnifiedInc\EUInc;
use library\EssentialUnifiedLang\EULang;
require'data-verify.php';
$words=EUInc::SqlCheck($_GET["word"]);
$module=EUInc::SqlCheck($_GET["module"]);
$lg=empty($_GET["lang"]) ? 1 : EUInc::SqlCheck($_GET["lang"]);
$word=explode(",",$words);
for($i=0;$i<count($word);$i++):
    if(!empty($module)):
        setcookie("Language",$lg);
        $thisword[]=array("word"=>EULang::ModLangData($word[$i],$module));
    else:
        $thisword[]=array("word"=>EULang::LangData($word[$i],$lg));
    endif;
endfor;
echo json_encode($thisword,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);