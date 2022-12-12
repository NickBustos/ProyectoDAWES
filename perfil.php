<?php
include 'admin/templates/cabecera.php';

if ((isset($_SESSION[SESSION_ID]))) {
} else {
}

?>

<body>

    <section>
        <div>
            <div class="text-center main-text">
                <h4><?php
                    if ((isset($_SESSION[SESSION_ID]))) {
                        echo [SESSION_USER];
                    } else {
                        echo "ÚNETE A NUETRA COMUNIDAD";
                    }
                    ?></h4>
                <br>
                <div class="medallas">
                    <img src="https://cdn-icons-png.flaticon.com/512/3176/3176294.png" alt=""><img src="https://cdn-icons-png.flaticon.com/512/5551/5551284.png" alt="">
                </div><br>
            </div>
            <div class="row d-flex justify-content-center">
                <img class="rounded-circle" src="https://img.freepik.com/foto-gratis/chico-worldface-espanol-fondo-blanco_53876-137665.jpg?w=826&t=st=1670266674~exp=1670267274~hmac=b824ebe1dc9018545964e2d26bdfcb257268c46179db41d7d245af099b634ca8" alt="">
                <div class="text-center"><br>
                    <p> Hola, soy un usuario random XD</p>
                    <p>Imagen del usuario</p>
                </div>
            </div><br><br>
            <div class="filaBatallas">
                <div class="row-center">
                    <div class="card-group">
                        <div class="card">
                            <img class="card-img-top" data-src="#" alt="mario" style="height: 15px;">
                            <span class="btn-circle btn-or">OR</span>
                            <img class="card-img-top" data-src="#" alt="luigi" style="height: 15px;">
                            <div class="card-body">
                                <h4 class="card-title">Batalla #1</h4>
                                <p class="card-text">Mario vs Luigi</p>
                            </div>
                        </div>
                        <div class="card">
                            <img class="card-img-top" data-src="holder.js/100x180/" alt="Nesquick" style="height: 15px;">
                            <span class="btn-circle btn-or">OR</span>
                            <img class="card-img-top" data-src="holder.js/100x180/" alt="Colacao" style="height: 15px;">
                            <div class="card-body">
                                <h4 class="card-title">Batalla #2</h4>
                                <p class="card-text">Colacao vs Nesquick</p>
                            </div>
                        </div>
                        <div class="card">
                            <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto1" style="height: 15px;">
                            <span class="btn-circle btn-or">OR</span>
                            <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto2" style="height: 15px;">
                            <div class="card-body">
                                <h4 class="card-title">Batalla #3</h4>
                                <p class="card-text">Algo vs Cosa</p>
                            </div>
                        </div>
                        <div class="card">
                            <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto1" style="height: 15px;">
                            <span class="btn-circle btn-or">OR</span>
                            <img class="card-img-top" data-src="holder.js/100x180/" alt="Foto2" style="height: 15px;">
                            <div class="card-body">
                                <h4 class="card-title">Batalla #4</h4>
                                <p class="card-text">Pelado vs Hippie</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>













    <?php
    include "admin/templates/pie.php"
    ?>