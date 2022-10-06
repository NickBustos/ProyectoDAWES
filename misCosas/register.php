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
    require "functions.php";
    if (empty($_FILES) == false) {
        var_dump($_FILES);
        $image = getImage($_FILES["avatar"]);
        saveImage($_FILES["avatar"]);
    }
    ?>
    <?php
    if (empty($image) == false) {
        echo "<img src=" . $image . " width='100px'/>";
    }
    ?>

    <form action='register.php' method="post" enctype="multipart/form-data">
        avatar:<input type="file" name="avatar" multiple accept="image/png" />
        <br />
        mail:<input type="email" name="mail" value="" />
        <br />
        user:<input type="text" name="user" value="" />
        <br />
        birth:<input type="date" name="birth" value="" />
        <br />
        password:<input type="password" name="password" value="" />
        <br />
        <input type="submit" value="enviar" />
    </form>
</body>

</html>