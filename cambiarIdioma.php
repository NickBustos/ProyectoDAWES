<?php 
/**
 * Primero: Comprueba que la cookie "lang" existe.
 * Si existe cambia el idioma de la cookie a español o inglés.
 * Sino existe, establece la cookie en español.
 * Tiempo de duración de cookie = 1hora.
 * Luego te muestra la página previa.
 */

if (isset($_COOKIE["lang"])) {
    if($_COOKIE["lang"] === "es"){
        setCookie("lang","en",time()+60*60);
    }else{
        setCookie("lang","es",time()+60*60);
    }
}else{
    setCookie("lang","es",time()+60*60);
}
header('Location: ' . $_SERVER["HTTP_REFERER"]);
exit();
?>