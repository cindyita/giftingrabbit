<div class="main">

    <div class="white-box">
    
        <div id="view-mode">

            <div class="d-flex justify-content-between">
                <h5 class="page-title">Configuración de cuenta <span id="loading"><div class='spinner-border'></div></span></h5>
                <button class="button-secondary btn-save" onclick="changeMode('edit')">Editar <i class="fa-solid fa-pen-to-square"></i></button>
            </div>

            <div class="main-profile">

                <div class="main-profile-info">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <h6>Email:</h6>
                             <div id="view-email" class="d-flex gap-2 align-items-center"><span><?php echo $user['email']; ?></span> <!--<span class="yellow-card-min">Sin confirmar</span>--></div> 
                        </div>
                        <div>
                            <h6>Contraseña:</h6>
                             <div>[Oculta]</div> 
                        </div>
                        <div>
                            <span class="text-secondary">[Da click en editar para cambiar el email y/o la contraseña]</span>
                        </div>
                        <div>
                            <button class="btn btn-danger btn-sm rounded" data-bs-toggle="modal" data-bs-target="#deleteAccount">Eliminar cuenta</button>
                        </div>
                    </div>
                    
                </div>

                

            </div>

        </div>

        <div id="edit-mode">
            <form method="post" id="saveSettings">

                <div class="d-flex justify-content-between">
                    <h5 class="page-title">Editar mi configuración</h5>
                    <div>
                        <a class="button-secondary" onclick="changeMode('view')"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
                        <button class="button-primary btn-save" type="submit">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                </div>

                <div class="main-profile">

                    <div class="main-profile-info">
                        <div>
                            <div>
                                <strong>Email</strong>
                                <p><input class="form-control" type="email" name="email" id="email" value="<?php echo $user['email']; ?>" onblur="checkExist('email','email','<?php echo $user['email']; ?>')" required></p>
                                <input type="hidden" name="actual_email" id="actual_email" value="<?php echo $user['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" id="pass" placeholder="Ingresa la nueva contraseña" name="pass" onblur="checkpass()">
                            </div>
                            <div class="mb-3">
                                <label for="cpass" class="form-label">Confirma tu contraseña</label>
                                <input type="password" class="form-control" id="cpass" placeholder="Confirma la nueva contraseña" name="cpass" onblur="confirmpass()">
                            </div>
                        </div>
                    </div>

                </div>
                
            </form>
        </div>
        
    </div>
    
</div>

<!--------------------------------------->
<!------------- Delete Account -------------->
<div class="modal" id="deleteAccount">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Estás segur@ que quieres borrar tu cuenta?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <div>
                <p>Piensalo bien. Esta acción es permanente y no se puede deshacer. Se borrarán todos los datos asociados. Si tienes intercambios activos dónde seas administrador, no podrás borrar tu cuenta, ve a tu panel de control y cede la administración de tus intercambios. Una vez que no administres ningún intercambio podrás borrar tu cuenta.</p>
            </div>
            <form method="post" id="deleteAccountForm">
                <div class="mb-3"><div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div></div>
                <button type="submit" class="btn btn-danger" id="deleteAccountbtn">Eliminar mi cuenta</button>
            </form>
      </div>

    </div>
  </div>
</div>
