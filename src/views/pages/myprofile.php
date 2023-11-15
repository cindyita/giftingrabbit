<div class="main">

    <div class="white-box">
    
        <div id="view-mode">

            <div class="d-flex justify-content-between">
                <h5 class="page-title">Mi perfil <span id="loading"><div class='spinner-border'></div></span></h5>
                <button class="button-secondary btn-save" onclick="changeMode('edit')">Editar <i class="fa-solid fa-pen-to-square"></i></button>
            </div>

            <div class="main-profile">

                <div>
                    <div class="img-profile">
                        <img src="./assets/img/<?php echo isset($user['img_profile']) ? 'user/img-profile/'.$user['img_profile'].'?upd='.time() : "system/defaultimgsq.webp"; ?>" alt="profileimg" onerror="this.src = './assets/img/system/defaultimgsq.webp'" loading="lazy">
                    </div>
                    <br>
                    <div class="ribon" id="view-username">
                        <?php echo $user['username']; ?>
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
                    <div class="biography d-flex flex-column gap-3">
                        <div>
                            <strong>Nombre</strong>
                            <p id="view-name"><?php echo $user['name']; ?></p>
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

        <div id="edit-mode">
            <form method="post" id="saveProfile" enctype="multipart/form-data">

                <div class="d-flex justify-content-between">
                    <h5 class="page-title">Editar mi perfil</h5>
                    <div>
                        <a class="button-secondary" onclick="changeMode('view')"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
                        <button class="button-primary btn-save" type="submit" id="saveTop">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                </div>

                <div class="main-profile">

                    <div class="d-flex flex-column align-items-center">
                        <div class="img-profile">
                             <img src="./assets/img/<?php echo $user['img_profile'] ? 'user/img-profile/'.$user['img_profile'].'?upd='.time() : "system/defaultimgsq.webp"; ?>" alt="profileimg" id="img-preview" onerror="this.src = './assets/img/system/defaultimgsq.webp'" loading="lazy">
                        </div>
                        Imagen de perfil:
                        <input type="file" name="img-profile" id="img-profile" class="form-control" onchange="handleFileImage(this.files, 'img-preview')">
                        <br>
                        <div class="ribon"> 
                            <input type="hidden" name="actual_username" id="actual_username" value="<?php echo $user['username']; ?>">   
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $user['username']; ?>" onblur="checkExist('username','username','<?php echo $user['username']; ?>')">
                        </div>
                    </div>

                    <div class="main-profile-info">
                        <div class="info d-flex flex-column gap-3">
                            <div>
                                <strong>Cumpleaños</strong>
                                <p><input class="form-control" type="date" name="birthday" id="birthday" value="<?php echo $user['birthday']; ?>"></p>
                            </div>
                            <div>
                                <strong>Me gusta</strong>
                                <p><textarea class="form-control" type="input" name="likes" id="likes"><?php echo $user['likes']; ?></textarea></p>
                            </div>
                            <div>
                                <strong>No me gusta</strong>
                                <p><textarea class="form-control" type="input" name="dislikes" id="dislikes"><?php echo $user['dislikes']; ?></textarea></p>
                            </div>
                        </div>
                        <div class="biography d-flex flex-column gap-3">
                            <div>
                                <strong>Nombre</strong>
                                <p><input class="form-control" type="text" name="name" id="name" value="<?php echo $user['name']; ?>"></p>
                            </div>
                            <div>
                                <strong>Biografía</strong>
                                <p><textarea class="form-control" name="biography" id="biography" cols="30" rows="5"><?php echo $user['biography']; ?></textarea></p>
                            </div>
                        </div>
                    </div>

                </div>
                
            </form>
        </div>
        

    </div>
    
</div>

