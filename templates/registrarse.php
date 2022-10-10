<?php

require(__DIR__ . "/../vendor/autoload.php");

?>

<div>

    <form method="post" action="/src/form/registerForm.php">
    
        <input placeholder="Nombre de usuario" type="text" id="NombreRegistro" />

        <input placeholder="Correo electronico" type="text" id="emailRegistro" name="email" />
    
        <input placeholder="Contraseña" type="password" id="passwordRegistro" />
        <input placeholder="Repite la contraseña" type="password" id="password2Registro" />
    
        <input placeholder="fecha de nacimiento" type="date" id="fechaNacimientoRegistro" />
    
        <label for="formFile">
            Foto de perfil
        </label>
        <input type="file" id="fotoPerfilRegistro">
    
        <input type="checkbox" value="" id="politicasAceptadaRegistro" />
        <label class="form-check-label" for="politicasAceptadaRegistro">
            Acepto los <a href="/terminos-y-condiciones">términos y condiciones</a>
        </label>
    
        <input id="envio" type="submit">
    
        <p>
            ¿Ya tienes una cuenta? Haz clíck <a href="/inicio-sesion">aquí</a>
        </p>

    </form>
                                    
</div>
