<?php
define("PATRON_USER", "/([A-ZÁ-Ú]{1}[-a-zá-ú]+\s?)+/A");
define("PATRON_PASS", "/(^[A-Za-z\d$@$!%*?&_]{8,15}$)/A");//Culquiera de esos caracteres minimo 8 maximo 15
define("PATH_TO_IMAGENES", 'multimedia/imagenes/');
define("PATH_TO_BD", "multimedia/bbdd.txt");

define("DATE_TODAY", date("Y-m-d"));
define("DATE_FIRST", date("1900-01-01"));

//FORMATO ERRORES
define("ERROR_IN", "<span style='color:red'>");
define("ERROR_OUT", "</span>");

//VACIO
define("ERROR_VACIO", ERROR_IN . "El campo no puede estar vacio" . ERROR_OUT);
//PASSWORD
define("PATRON_PASS_MINUS", '@[a-z]@');
define("PATRON_PASS_MAYUS", '@[A-Z]@');
define("PATRON_PASS_NUMBER", '@[0-9]@');
define("MIN_PASS_LENGTH", 8);
define("MAX_PASS_LENGTH", 16);
define("ERROR_PASS_FORMAT", 
ERROR_IN . "La contraseña debe tener mínimo:
<ul>
    <li>" . MIN_PASS_LENGTH . " carácteres (Max " . MAX_PASS_LENGTH . ")</li>
    <li>1 minúscula</li>
    <li>1 mayúscula</li>
    <li>1 número</li>
</ul>" . 
ERROR_OUT);
define("ERROR_PASS_MATCH",  ERROR_IN . "Las contraseñas no coinciden" . ERROR_OUT);
//USER
define("ERROR_USER_PATRON",  ERROR_IN . "Por favor, ingrese un nombre válido" . ERROR_OUT);
//DATE
define("ERROR_DATE_YEAR", ERROR_IN . "Solo se pueden registrar mayores de edad" . ERROR_OUT);
//MAIL
define("ERROR_MAIL", ERROR_IN . "Introduce un mail válido" . ERROR_OUT);
//FILE
define("ERROR_FILE_SIZE", ERROR_IN . "El archivo no puede ocupar más de un mega" . ERROR_OUT);
define("ERROR_FILE_TYPE", ERROR_IN . "El archivo debe ser .png" . ERROR_OUT);
//LOGIN
define("ERROR_LOGIN_USER", ERROR_IN . "El nombre no existe" . ERROR_OUT);
define("ERROR_LOGIN_PASS", ERROR_IN . "La contraseña no es correcta" . ERROR_OUT);





//NO SUBIR 13/10/2022
define("CONFIRMACION_CORREO", '<body style="background-color: #f8f8f9; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tbody>
        <tr>
            <td>
                <div style="font-family: Arial, sans-serif">
                    <div class="" style="font-size: 12px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;">
                        <p style="margin: 0; font-size: 16px; text-align: center;"><span style="font-size:30px;color:#2b303a;"><strong>Confirma tu e-mail</strong></span></p>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="text_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
    <tbody>
        <tr>
            <td class="pad" style="padding-bottom:10px;padding-left:40px;padding-right:40px;padding-top:10px;">
                <div style="font-family: sans-serif">
                    <div class="" style="font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 18px; color: #555555; line-height: 1.5;">
                        <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 22.5px;"><span style="color:#808389;font-size:15px;">Gracias por registrarte. A continuación te pedimos que ingrese al siguiente enlace para confirmar tu cuenta. Saludos.</span></p>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="button_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
    <tbody>
        <tr>
            <td class="pad" style="padding-left:10px;padding-right:10px;padding-top:15px;text-align:center;">
                <div align="center" class="alignment">
                    <a href="www.example.com" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#f7a50c;border-radius:35px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:15px;padding-bottom:15px;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="margin: 0; word-break: break-word; line-height: 32px;"><strong>Confirmar dirección de e-mail</strong></span></span></a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</body>')

?>