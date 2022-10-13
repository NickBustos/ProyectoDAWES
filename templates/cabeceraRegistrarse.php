<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajo</title>
    <link rel="stylesheet" href="./css/archivo.css" />
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li>
        <a href="#" class="navbar-brand">
                <img src="multimedia/imagenes/logo2.png.png" alt="Logo">
            </a>
            </li>
            <li class="nav-item active" style="margin: auto;">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>

            <li class="nav-item" style="margin: auto;">
                <a class="nav-link" href="acercade.php">Acerca de</a>
            </li>

            <li class="nav-item" style="margin: auto;">
                <a class="nav-link" href="contacto.php">Contacto</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <br></br>

    </div>


    <?php
//ESTRUCTURA HTML DE UN MENSAJE DE CONFIRMACIÓN. *****************
$confirmacionCorreo = '<body style="background-color: #f8f8f9; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
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
</body>';
//ESTRUCTURA HTML DE UN MENSAJE DE CONFIRMACIÓN POR CORREO. *****************




$confirmacionCorreo = wordwrap($confirmacionCorreo, 70, "\r\n");

    include 'Configuraciones\funciones.php';

    $nombreUser = $avatar = $fechaNac = $mail = $pass = "";
    $_nombreDeUsuario = $_fechaNac = $_mail = $_pass1 = $_pass2 = "";
    $fechamax = date("Y-m-d");
    $fechamin = date("1900-01-01");

    $errorNombre = $errorFile = $errorFecha = $errorMail = $errorPass1 = $errorPass2 = "";

    $registrado = false;

    if (!empty($_POST)) {
        //---------------------------- USER --------------------------------
        $_nombreDeUsuario = htmlspecialchars($_POST["nombreDeUsuario"]);
        if (!empty($_nombreDeUsuario)) {
            if (!validar($_nombreDeUsuario, VALIDA_NOMBREUSUARIO)) {
                $errorNombre = "<span style='color:red'>Por favor, ingrese un nombre válido</span>";
            } else {
                if(strlen($_nombreDeUsuario) >= 3 && strlen($_nombreDeUsuario) <= 32){
                    $nombreUser = $_nombreDeUsuario;
                }else{
                    $errorNombre = "<span style='color:red'>Tiene que tener entre 3-32 caracteres</span>";
                }
            }
        } else {
            $errorNombre = ERROR_VACIO;
        }
        //---------------------------- PASS --------------------------------
        $_pass1 = htmlspecialchars($_POST["password1"]);
        $_pass2 = htmlspecialchars($_POST["password2"]);
        if(!empty($_pass1)) {
            if(validarPassword($_pass1, $errorPass1)){
                if(!empty($_pass2)) {
                    if($_pass1 == $_pass2){
                        $pass = $_pass1;
                    }else{
                        $errorPass2 = "<span style='color:red'>Las contraseñas no coinciden</span>";
                    }
                }else{
                    $errorPass2 = ERROR_VACIO;
                }
            }
        }else{
            $errorPass1 = ERROR_VACIO;
        }
        //---------------------------- DATE --------------------------------
        $_fechaNac = htmlspecialchars($_POST["fechaNac"]);
        if (!empty($_fechaNac)) {
            if (calculaedad($_fechaNac)) {
                $fechaNac = $_fechaNac;
            } else {
                $errorFecha = "<span style='color:red'>Solo se pueden registrar mayores de edad</span>";
            }
        } else {
            $errorFecha = ERROR_VACIO;
        }
        //---------------------------- MAIL --------------------------------
        $_mail = htmlspecialchars($_POST["correoUsuario"]);
        if(!empty($_mail)){
            if(validarMail($_mail)){
                $mail = $_mail;
            }else{
                $errorMail = "<span style='color:red'>Introduce un Mail válido</span>";
            }
        }else{
            $errorMail = ERROR_VACIO;
        }
        //---------------------------- FILE --------------------------------
        if (
            empty($_FILES) == false && empty($_FILES["avatar"]) == false
            && $_FILES["avatar"]["tmp_name"] != ""
        ) {
            if ($_FILES['avatar']['size'] < 1000000) {//1 mega
                $avatar = getImage($_FILES["avatar"]);
            //saveImage($_FILES["avatar"]);
            }else{
                $errorFile = "<span style='color:red'>El archivo no puede ocupar más de un mega</span>";
            }
            
        } else {
            $errorFile = ERROR_VACIO;
        }
        //---------------------------- RGST --------------------------------
        if (!empty($nombreUser) && !empty($fechaNac) && !empty($avatar) && !empty($mail)) {
            //REGISTRAR (GUARDAR DATOS)
            $registrado = true;
            mail('$mail',
            'Confirmar cuenta','$confirmacionCorreo');
        }
    }


    ?>