<?php
$idioma = "es";
if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] === "es") {
    $idioma = "en";
}
setcookie("lang", $idioma, time()+60);

header('Location: ' . $_SERVER["HTTP_REFERER"]);
exit();
?>