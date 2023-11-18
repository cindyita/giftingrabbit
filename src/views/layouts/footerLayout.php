
    <footer>
        <div class="footer">
            <span class="text-center mt-3"><i class="fa-solid fa-heart"></i> Hecho con amor por <a href="https://virtualblux.com">Virtual Blux</a></span>
            <span class="mt-1 d-flex flex-column flex-lg-row gap-3">
                <a href="/">Home</a>
                <a href="about">Acerca de</a>
                <a href="termsandconditions">Términos y condiciones</a>
                <a href="privacypolicy">Política de privacidad</a>
                <a href="cookies">Uso de cookies</a>
                <a href="contact">Contacto</a> - 
                <a href="#" onclick="toggleMode()" class="text-primary">
                    <i class="fa-solid fa-circle-half-stroke"></i> Tema Claro/Oscuro
                </a>
            </span>
            <span class="text-secondary mt-1">Beta v<?php echo VERSION; ?></span>
        </div>
    </footer>

</div>

<script async src="./assets/library/bootstrap5/bootstrap.bundle.min.js"></script>
<script src="./assets/js/app.js?version=<?php echo VERSION; ?>"></script>
<!----------------------------------->
<?php 

    if($scripts){
        foreach ($scripts as $value) {
            echo '<script src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>