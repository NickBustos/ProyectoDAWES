<?php include 'templates/cabecera.php'?>
<div class="contact1">
    <div class="container-contact1">
        <div class="contact1-pic js-tilt" data-tilt>
            <img src="https://cdn-icons-png.flaticon.com/512/1910/1910972.png" alt="IMG">
        </div>
        <form class="contact1-form validate-form">
            <span class="contact1-form-title">
                ¡Ponte en contacto!
            </span>

            <div class="wrap-input1 validate-input" data-validate="Name is required">
                <input class="input1" type="text" name="name" placeholder="Nombre">
                <span class="shadow-input1"></span>
            </div>

            <div class="wrap-input1 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                <input class="input1" type="text" name="email" placeholder="Email">
                <span class="shadow-input1"></span>
            </div>

            <div class="wrap-input1 validate-input" data-validate="Subject is required">
                <input class="input1" type="text" name="subject" placeholder="CC">
                <span class="shadow-input1"></span>
            </div>

            <div class="wrap-input1 validate-input" data-validate="Message is required">
                <textarea class="input1" name="message" placeholder="Escribenos tu mensaje"></textarea>
                <span class="shadow-input1"></span>
            </div>

            <div class="container-contact1-form-btn">
                <button class="contact1-form-btn">
                    <span>
                        ¡Enviar!
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'templates/pie.php' ?>