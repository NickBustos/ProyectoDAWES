<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        $user = "";
        if(empty($_POST) == false){
            $user = $_POST["user"];
        }
    ?>
    <form action='register.php' method="post">
        avatar:<input type="file" name="avatar" />
        <br />
        mail:<input type="email" name="mail" value="" />
        <br />
        user:<input type="text" name="user" value="<?php echo $user ?>" />
        <br />
        birth:<input type="date" name="birth" value="" />
        <br />
        password:<input type="password" name="password" value="" />
        <br />
        <input type="submit" value="enviar" />
    </form>
</body>

</html>