
    <footer>
        <div class="footer">
            <span class="text-center mt-2"><i class="fa-solid fa-heart"></i> Made by Cindy ita with love</span>
            <span class="mt-1 d-flex flex-column flex-md-row">
                <a href="home">Home</a>
                <a href="termsandconditions">Terms and Conditions</a>
                <a href="privacypolicy">Privacy policy</a>
                <a href="cookies">Use of cookies</a>
                <a href="contact">Contact</a>
                <a href="#" onclick="toggleMode()">
                    <i class="fa-solid fa-circle-half-stroke"></i> Light/Dark
                </a>
            </span>
            <span class="text-secondary mt-1">Beta v<?php echo VERSION; ?></span>
        </div>
    </footer>

</div>

<script src="./assets/library/bootstrap5/bootstrap.bundle.min.js"></script>
<!----------------------------------->
<script src="./assets/js/app.js?version=<?php echo VERSION; ?>"></script>
<?php 
    if($scripts){
        foreach ($scripts as $value) {
            echo '<script src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>