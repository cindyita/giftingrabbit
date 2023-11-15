<div class="main">

    <div class="white-box">
    
        <div id="view-mode">

            <div class="d-flex justify-content-between">
                <h5 class="page-title">Perfil de usuario <span id="loading"><div class='spinner-border'></div></span></h5>
                <!-- <button class="button-secondary btn-save">Agregar amigo</button> -->
            </div>

            <div class="main-profile">

                <div>
                    <div class="img-profile">
                        <img src="./assets/img/<?php echo isset($user['img_profile']) ? 'user/img-profile/'.$user['img_profile'].'?upd='.time() : "system/defaultimgsq.webp"; ?>" alt="profileimg" onerror="this.src = './assets/img/system/defaultimgsq.webp'" loading="lazy">
                    </div>
                    <br>
                    <div class="ribon" id="view-name">
                        <?php echo $user['name']; ?>
                    </div>
                </div>

                <div class="main-profile-info">
                    <div class="info d-flex flex-column gap-3">
                        <div>
                            <strong>Cumpleaños</strong>
                            <p id="view-birthday"><?php echo $user['birthday']; ?></p>
                        </div>
                        <div>
                            <strong>Me gusta</strong>
                            <p id="view-likes"><?php echo $user['likes']; ?></p>
                        </div>
                        <div>
                            <strong>No me gusta</strong>
                            <p id="view-dislikes"><?php echo $user['dislikes']; ?></p>
                        </div>
                    </div>
                    <div class="biography">
                        <div>
                            <strong>Nombre de usuario</strong>
                            <p id="view-username"><?php echo $user['username']; ?></p>
                        </div>
                        <div>
                            <strong>Biografía</strong>
                            <p id="view-biography"><?php echo $user['biography']; ?></p>
                        </div>
                        <div>
                            <strong>Usuario desde:</strong>
                            <p id="view-registration"><span class="relativedate"><?php echo $user['timestamp_create']; ?></span></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
</div>