<div class="main">

    <div class="d-flex flex-column gap-3">

        <div class="p-3">
            <div class="d-flex justify-content-center align-items-center gap-3">
                <button class="button-primary" data-bs-toggle="modal" data-bs-target="#newExchange">Crear intercambio</button>
                <button class="button-secondary" data-bs-toggle="modal" data-bs-target="#joinExchange">Unirse a un intercambio</button>
            </div>
        </div>

        <div class="white-box">
            <div class="d-flex justify-content-center align-items-center gap-3">
                <div class="w-100 d-flex flex-column gap-3">
                    <h2>Mis intercambios</h2>
                    <div class="w-100 d-flex flex-column gap-3" id="feedExchanges">
                        <!-------------------->
                        <?php foreach ($exchanges_user as $key => $value) { ?>
                        <div class="green-card">
                            <div class="head">
                                <div class="img">
                                    <a href="exchange?id=<?php echo $value['id']; ?>">
                                        <img src="./assets/img/exchanges/<?php echo $value['img'] ?>" alt="img intercambio" onerror="this.src = './assets/img/system/defaultimg.webp'">
                                    </a>
                                </div>
                                <div class="info">
                                    <strong><a href="exchange?id=<?php echo $value['id']; ?>"><?php echo $value['name'];
                                    if ($value['role'] == 1) {
                                        echo " <span class='text-warning'><i class='fa-solid fa-crown'></i></span>";} ?></a></strong>
                                    <span>Código: <?php echo $value['code'] ?></span>
                                    <span>Miembros: <?php echo $value['num_members'] ?></span>
                                    <span>Fecha del evento: <span class="dateFormat"><?php echo $value['event_date'] ?></span></span>
                                </div>
                            </div>
                            <div class="options">
                                <div class="dropdown">
                                    <a class="btn button-options" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" onclick="copyToClipboard('<?php echo $value['code'] ?>')">Copiar código <i class="fa-solid fa-clipboard"></i></a></li>
                                        <li><a class="dropdown-item" href="exchange?id=<?php echo $value['id']; ?>">Ver intercambio <i class="fa-solid fa-eye"></i></a></li>
                                        <?php if ($value['role'] != 1) { ?>
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exitExchange" onclick="exitExchangeForm(<?php echo $value['id'] . ',\'' . $value['name'].'\''; ?>)">Salir del intercambio <i class="fa-solid fa-right-from-bracket"></i></a></li>
                                        <?php } ?>
                                        <?php if ($value['role'] == 1) { ?>
                                            <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteExchange" onclick="deleteExchangeForm(<?php echo $value['id'] . ',\'' . $value['name'].'\''; ?>)">Borrar intercambio <i class="fa-solid fa-trash"></i></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-------------------->
                        <?php if (!$exchanges_user){ echo "<i>Aún no participas en ningún intercambio</i>";} ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
    
</div>

<!--------------------------------------->
<!------------- Create exchange ------------>
<div class="modal" id="newExchange">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Crear nuevo intercambio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="newExchangeForm">
            <div class="mb-3 mt-3">
                <div class="content-img">
                    <img src="./assets/img/system/defaultimg.webp" id="img-exchange-preview" onerror="this.src = './assets/img/system/defaultimg.webp'" class="img" max-width="100%">
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="img" class="form-label">Imagen del intercambio:</label>
                <input type="file" class="form-control" id="img" name="img" onchange="handleFileImage(this.files, 'img-exchange-preview')">
            </div>
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Nombre del intercambio*:</label>
                <input type="text" class="form-control" id="name" placeholder="Ejemplo: Navidad Familia Ayala" name="name" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="about" class="form-label">Descripción del intercambio:</label>
                <textarea class="form-control" id="about" placeholder="Opcional, si necesitas dar detalles de la dinámica" name="about"></textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="rules" class="form-label">Reglas del intercambio:</label>
                <textarea class="form-control" id="rules" placeholder="Opcional, si hay reglas para la dinámica" name="rules"></textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="type_gift" class="form-label">Tipo de regalo:</label>
                <input type="text" class="form-control" id="type_gift" placeholder="Ejemplo: Físico, digital, de broma, suéteres, etc." name="type_gift">
            </div>
            <div class="mb-3 mt-3">
                <label for="main_question" class="form-label">Pregunta central:</label>
                <input type="text" class="form-control" id="main_question" placeholder="Lo verán las personas que van a regalar dependiendo de quien les tocó" name="main_question" value="¿Qué te gustaría de regalo?" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="min_price" class="form-label">Precio mínimo:</label>
                <input type="number" class="form-control" id="min_price" placeholder="Opcional, Precio mínimo de regalo" name="min_price">
            </div>
            <div class="mb-3 mt-3">
                <label for="max_price" class="form-label">Precio máximo:</label>
                <input type="number" class="form-control" id="max_price" placeholder="Opcional, Precio máximo de regalo" name="max_price">
            </div>
            <div class="mb-3 mt-3">
                <label for="event_date" class="form-label">Día del evento*:</label>
                <input type="date" class="form-control" id="event_date" placeholder="Día en que se realizará la dinámica" name="event_date" required>
            </div>
            <div class="mb-3 mt-3">
              <label for="admin_participates" class="form-label">¿El admin(tú) participa en la dinámica?:</label>
              <select class="form-select" id="admin_participates" name="admin_participates"> 
                  <option value="1" selected>Si</option>
                  <option value="0">No</option>
              </select>
            </div>
            <div class="mb-3 mt-3">
              <label for="admin_view_raffle" class="form-label">¿El admin(tú) podrá ver los resultados?:</label>
              <select class="form-select" id="admin_view_raffle" name="admin_view_raffle">
                  <option value="1">Si</option>
                  <option value="0" selected>No</option>
              </select>
            </div>
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Crear</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!--------------------------------------->
<!------------- Join exchange -------------->
<div class="modal" id="joinExchange">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Entrar a un intercambio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="joinExchangeForm">
            <div class="mb-3 mt-3">
                <label for="code" class="form-label">Código:</label>
                <input type="text" class="form-control" id="code" placeholder="Ingresa el código del intercambio" name="code">
            </div>
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Entrar</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!--------------------------------------->
<!------------- Exit exchange -------------->
<div class="modal" id="exitExchange">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Estás segur@ que ya no quieres participar en este intercambio?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="exitExchangeForm">
            <div class="mb-3 mt-3">
                <label class="form-label" id="exitExchange_text"></label>
                <input type="hidden" name="id" id="exitExchange_id">
            </div>
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Aceptar</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!--------------------------------------->
<!------------- Delete exchange -------------->
<div class="modal" id="deleteExchange">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Estás segur@ que quiere borrar este intercambio?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="deleteExchangeForm">
            <div class="mb-3 mt-3">
                <label for="code" class="form-label" id="deleteExchange_text"></label>
                <input type="hidden" name="id" id="deleteExchange_id">
            </div>
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Borrar</button>
        </form>
      </div>

    </div>
  </div>
</div>