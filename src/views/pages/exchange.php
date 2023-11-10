<div class="main">

    <div class="my-3 d-flex justify-content-between">
        <div>
            <a class="button-secondary" href="home"><i class="fa-solid fa-arrow-left"></i> Regresar a la lista</a>
        </div>
        <div>
            <?php if ($exchange['id_admin'] == $id_user) { ?>
            <button class="button-secondary" data-bs-toggle="modal" data-bs-target="#editExchange">Editar <i class="fa-solid fa-pen-to-square"></i></button>
            <?php } ?>
        </div>
    </div>

    <div class="content-3-boxes">

        <div class="w25-1 d-flex flex-column gap-4">
            <div class="white-box">
                <div class="d-flex justify-content-between mb-2">
                    <h4 class="page-title"><?php echo $exchange['name']; ?></h4>
                </div>
                <div class="mb-3">
                    <div class="img">
                        <img src="./assets/img/exchanges/<?php echo $exchange['img']; ?>" onerror="this.src = './assets/img/system/defaultimg.jpg'">
                    </div>
                </div>

                <div>
                    <h6>Fecha del evento:</h6>
                    <p class="dateFormat"><?php echo $exchange['event_date']; ?></p>
                </div>

                <div class="d-flex gap-3 mt-3">
                    <?php if ($exchange['min_price']) { ?>
                    <div>
                        <h6>Precio mínimo:</h6>
                        <p>$<?php echo $exchange['min_price']; ?></p>
                    </div>
                    <?php } if ($exchange['max_price']) { ?>
                    <div>
                        <h6>Precio máximo:</h6>
                        <p>$<?php echo $exchange['max_price']; ?></p>
                    </div>
                    <?php } ?>
                </div>
                <?php if ($exchange['type_gift']) { ?>
                    <div>
                        <h6>Tipo de regalo:</h6>
                        <p><?php echo $exchange['type_gift']; ?></p>
                    </div>
                <?php } ?>
                <?php if ($exchange['rules']) { ?>
                    <div>
                        <h6>Reglas:</h6>
                        <p><?php echo $exchange['rules']; ?></p>
                    </div>
                <?php } ?>

                <div>
                    <h6>Características:</h6>
                    <p><?php if ($exchange['admin_participates']) {
                        echo "[El admin participa en la dinámica]";
                    }else{
                        echo "[El admin no participa en la dinámica]";
                    } ?></p>
                    <p><?php if ($exchange['admin_view_raffle']) {
                        echo "[El admin Puede ver los resultados]";
                    }else{
                        echo "[El admin no puede ver los resultados]";
                    } ?></p>
                </div>

                <div>
                    <h6>Creado por:</h6>
                    <p><a href="user?id=<?php echo $exchange['id_user']; ?>"><?php echo $exchange['username_create']; ?></a></p>
                </div>

                <div>
                    <h6>Administrado por:</h6>
                    <p><a href="user?id=<?php echo $exchange['id_admin']; ?>"><?php echo $exchange['username_admin']; ?></a></p>
                </div>
            </div>
            <?php if ($exchange['about']) { ?>
            <div class="white-box">
                <div>
                    <h6>Descripción:</h6>
                    <p><?php echo $exchange['about']; ?></p>
                </div>
            </div>
            <?php } ?>
            <?php if ($exchange['id_admin'] == $id_user) { ?>
            <div class="white-box">
                <div>
                    <button class="button-display"><span>Hacer sorteo <i class="fa-solid fa-dice"></i></span></button>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="w75 d-flex flex-column gap-4">

            <div class="white-box d-flex flex-column gap-3">
                <div>
                    <h6>Respuesta de quien te tocó:</h6>
                    <p>Aún no se sortea</p>
                </div>
                <hr>
                <div>
                    <h6>Tu respuesta:</h6>
                    <p>Aún no has agregado ninguna respuesta</p>
                </div>
                <hr>

                <div>
                    <h6>¿Qué te gustaría de regalo?</h6>
                    <div>
                        <form method="post" id="wantGiftForm">
                            <input type="hidden" name="id_exchange" value="<?php echo $id; ?>">
                            <textarea class="form-control" name="comment" id="wantGift_comment" rows="3" placeholder="Esta respuesta solo la verá la persona que te va a regalar"></textarea>
                            <div class="d-flex justify-content-end">
                                <button class="button-primary mt-2">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="white-box d-flex flex-column gap-3">
                <div>
                    <div>
                        <div class="comments w-100">
                            <h6 class="mb-5">Comentarios:</h6>
                            <div>
                                
                                <div class="d-flex flex-column gap-4 w-100" id="comments-post">
                                    <?php foreach ($comments as $key => $value) { ?>
                                    <div class="w-100">

                                        <div class="d-flex gap-2">
                                            <div>
                                                <div class="img-user">
                                                    <a href="user?id=<?php echo $value['id_user']; ?>"><img src="./assets/img/<?php echo $value['img_profile'] ? 'user/img-profile/'.$value['img_profile'] : 'system/defaultimgsq.jpg'; ?>" alt="image profile" onerror="this.src = './assets/img/system/defaultimgsq.jpg'"></a>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column w-100">
                                                <div class="d-flex justify-content-between">
                                                    <span class="user-name d-flex gap-1 flex-column flex-md-row">
                                                        <a href="user?id=1"><?php echo $value['username']; ?> <?php if($value['id_user'] == $exchange['id_admin']){echo '<span class="text-warning"><i class="fa-solid fa-crown"></i></span>';} ?></a> <span class="ms-0 ms-md-2 text-secondary relativedate"><?php echo $value['timestamp_create']; ?></span>
                                                    </span>
                                                    <span>
                                                        <?php if (isset($_SESSION['status_login'])) {
                                                                if ($id_user == $value['id_user'] || $_SESSION['userdata']['id_rol'] <= 2 || $id_user == $exchange['id_admin']) { ?>
                                                                <a class="text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#confirmDeleteComment" onclick="deleteComment(<?php echo $value['id_user'] . ',' . $value['id']; ?>)"><i class="fa-solid fa-trash"></i></a>
                                                            <?php }
                                                            } ?>
                                                    </span>
                                                </div>
                                                <span class="py-2 p-md-2"><?php echo $value['comment']; ?></span>
                                            </div>
                                        </div>

                                    </div>
                                    <?php } ?>
                                </div>

                                <hr>

                                <div>
                                <?php if(isset($_SESSION['status_login'])){ ?>
                                    <form method="post" id="comment">
                                        <div class="mb-3 mt-3">
                                            <input type="hidden" id="id_exchange" name="id_exchange" value="<?php echo $id; ?>">
                                            <label for="comment">Deja un comentario:</label>
                                            <textarea class="form-control" rows="3" id="comment" name="comment" required></textarea>
                                        </div>
                                        <div class="d-flex justify-content-end"><button type="submit" class="button-primary">Enviar</button></div>
                                    </form>
                                    <?php }else{ ?>
                                        <i><a href="login">Inicia sesión</a> o <a href="signup">Registrate</a> para dejar un comentario</i>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="w25 d-flex flex-column gap-4">
            <div class="white-box">
                <h6>Le vas a regalar a:</h6>
                <div>
                    <p>Aún no se sortea</p>
                </div>
            </div>
            
            <div class="white-box">

                <h6 class="mb-3">Usuarios que participan:</h6>
                <div class="d-flex flex-column gap-2">
                <?php foreach ($users as $key => $value) { ?>
                    <div class="green-card-min">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="img-user">
                                <a href="user?id=<?php echo $value['id_user']; ?>"><img src="./assets/img/<?php echo $value['img_profile'] ? 'user/img-profile/'.$value['img_profile'] : 'system/defaultimgsq.jpg'; ?>" alt="image profile" onerror="this.src = './assets/img/system/defaultimgsq.jpg'"></a>
                            </div>
                            <div>
                                <strong><?php echo $value['username']; ?> <?php if($value['id_user'] == $exchange['id_admin']){echo '<span class="text-warning"><i class="fa-solid fa-crown"></i></span>';} ?></strong>
                            </div>
                        </div>
                        <div class="options">
                            <div class="dropdown">
                                <a class="btn button-options" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="user?id=<?php echo $value['id_user']; ?>">Ver usuario <i class="fa-solid fa-eye"></i></a></li>
                                    <?php if ($exchange['id_admin'] == $id_user) { ?>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kickUserExchange" onclick="kickUserExchange(<?php echo $id . ',' . $value['id_user'] . ',\'' . $value['username'] . '\''; ?>)">Sacar del intercambio <i class="fa-solid fa-right-from-bracket"></i></a></li>
                                        <li><a class="dropdown-item text-danger"   onclick="giveAdmin(<?php echo $value['id_user'].',\'' . $value['username'] . '\''; ?>)">delegar administración <i class="fa-solid fa-handshake"></i></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>

            </div>
        </div>

    </div>

    

</div>

<!--------------------------------------->
<!------------- Kick user -------------->
<div class="modal" id="kickUserExchange">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Estás segur@ que quieres expulsar a este miembro del intercambio?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="kickUserExchangeForm">
            <div class="mb-3 mt-3">
                <label class="form-label" id="kickUserExchange_text"></label>
                <input type="hidden" name="id_user" id="kickUserExchange_id_user">
                <input type="hidden" name="id_exchange" id="kickUserExchange_id_exchange">
            </div>
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Aceptar</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!--------------------------------------->
<!------------- Give admin -------------->
<div class="modal" id="giveAdmin">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Estás segur@ que quieres delegar la administración del intrcambio a este usuario?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="giveAdminForm">
            <div class="mb-3 mt-3">
                <label class="form-label" id="giveAdmin_text"></label>
                <input type="hidden" name="id_user" id="giveAdmin_id_user">
                <input type="hidden" name="id_exchange" value="<?php echo $id; ?>">
            </div>
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Aceptar</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!--------------------------------------->
<!------------- Confirm delete -------------->
<div class="modal" id="confirmDeleteComment">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Segur@ que quieres borrar este comentario?</h4>
        <a type="button" class="button-close" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
        </a>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="deleteComment" method="post">
            <input type="hidden" name="id_user" id="delete-iduser">
            <input type="hidden" name="id_comm" id="delete-idcomm">
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Confirm</button>
        </form>
      </div>

    </div>
  </div>
</div>


<!--------------------------------------->
<!------------- edit exchange ------------>
<div class="modal" id="editExchange">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Editar el intercambio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="editExchangeForm">
            <div class="mb-3 mt-3">
                <div class="content-img">
                    <img src="./assets/img/<?php echo $exchange['img'] ? 'exchanges/'.$exchange['img'] : 'system/defaultimgsq.jpg'; ?>" id="img-exchange-preview" onerror="this.src = './assets/img/system/defaultimg.jpg'" class="img">
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Nombre del intercambio*:</label>
                <input type="text" class="form-control" id="name" placeholder="Ejemplo: Navidad Familia Ayala" name="name" value="<?php echo $exchange['name']; ?>" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="about" class="form-label">Descripción del intercambio:</label>
                <textarea class="form-control" id="about" placeholder="Opcional, si necesitas dar detalles de la dinámica" name="about"><?php echo $exchange['about']; ?></textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="rules" class="form-label">Reglas del intercambio:</label>
                <textarea class="form-control" id="rules" placeholder="Opcional, si hay reglas para la dinámica" name="rules"><?php echo $exchange['rules']; ?></textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="type_gift" class="form-label">Tipo de regalo:</label>
                <input type="text" class="form-control" id="type_gift" placeholder="Ejemplo: Físico, digital, de broma, suéteres, etc." name="type_gift" value="<?php echo $exchange['type_gift']; ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="min_price" class="form-label">Precio mínimo:</label>
                <input type="number" class="form-control" id="min_price" placeholder="Opcional, Precio mínimo de regalo" name="min_price" value="<?php echo $exchange['min_price'] ? $exchange['min_price'] : ""; ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="max_price" class="form-label">Precio máximo:</label>
                <input type="number" class="form-control" id="max_price" placeholder="Opcional, Precio máximo de regalo" name="max_price" value="<?php echo $exchange['max_price'] ? $exchange['max_price'] : ""; ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="event_date" class="form-label">Día del evento*:</label>
                <input type="date" class="form-control" id="event_date" placeholder="Día en que se realizará la dinámica" name="event_date" value="<?php echo $exchange['event_date']; ?>" required>
            </div>
            <div class="mb-3 mt-3">
              <label for="admin_participates" class="form-label">¿El admin participa en la dinámica?:</label>
              <select class="form-select" id="admin_participates" name="admin_participates"> 
                  <option value="1" <?php if ($exchange['admin_participates']) {
                      echo "selected";}; ?>>Si</option>
                  <option value="0" <?php if (!$exchange['admin_participates']) {
                      echo "selected";}; ?>>No</option>
              </select>
            </div>
            <div class="mb-3 mt-3">
              <label for="admin_view_raffle" class="form-label">¿El admin podrá ver los resultados?:</label>
              <select class="form-select" id="admin_view_raffle" name="admin_view_raffle">
                  <option value="1" <?php if ($exchange['admin_view_raffle']) {
                      echo "selected";}; ?>>Si</option>
                  <option value="0" <?php if (!$exchange['admin_view_raffle']) {
                      echo "selected";}; ?>>No</option>
              </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="img" class="form-label">Imagen del intercambio:</label>
                <input type="file" class="form-control" id="img" name="img" onchange="handleFileImage(this.files, 'img-exchange-preview')">
            </div>
            <input type="hidden" name="id_exchange" value="<?php echo $exchange['id']; ?>">
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Editar</button>
        </form>
      </div>

    </div>
  </div>
</div>