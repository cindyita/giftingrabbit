
    <footer>
        <div class="footer">
            <span class="text-center mt-2"><i class="fa-solid fa-heart"></i> Hecho con amor por <a href="https://virtualblux.com">Virtual Blux</a></span>
            <span class="mt-1 d-flex flex-column flex-md-row">
                <a href="home">Home</a>
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
<!----------------------------------->
<?php 
    if(isset($_GET)){
        echo '<script async src="./assets/js/app.js?version=<?php echo VERSION; ?>"></script>';
    }

    if($scripts){
        foreach ($scripts as $value) {
            echo '<script async src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>