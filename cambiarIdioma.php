<?php
if (isset($_COOKIE["lang"])) {
    if($_COOKIE["lang"] === "es"){
        setCookie("lang","en",time()+60);
    }else{
        setCookie("lang","es",time()+60);
    }
    }else{
        setCookie("lang","es",time()+60);
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
exit();
?>