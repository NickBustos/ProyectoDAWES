<?php
include "admin/templates/cabecera.php";

if (isset($_COOKIE["lang"])) {

    if($_COOKIE["lang"] == "es"){

        setCookie("lang","en",time()+60);

    }else{

        setCookie("lang","es",time()+60);

    }

    }else{
        setCookie("lang","es",time()+60);

}

header('Location: index.php');
exit();
?>