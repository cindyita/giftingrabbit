<?php $page = isset($_GET['page']) ? $_GET['page'] : ""; ?>

<header>
    <div class="menu d-flex justify-content-between align-items-center">
        <a href="home">
            <div class="logo">
                <img src="./assets/img/system/logov2.webp" alt="logo" id="imglogo">
            </div>
        </a>
        <div class="menu-right d-flex gap-3 align-items-center">
            <?php if (isset($_SESSION['status_login'])) { ?>
                <div class="mt-3">
                    <h5><?php echo $_SESSION['userdata']['username']; ?></h5>
                </div>
                <div class="menu-user">
                    <div class="dropdown dropdown-menu-end">
                        <div class="menu-img-user" data-bs-toggle="dropdown">
                            <img src="./assets/img/<?php echo $_SESSION['userdata']['img_profile'] ? 'user/img-profile/'.$_SESSION['userdata']['img_profile'].'?upd='.time() : "system/defaultimgsq.webp"; ?>" alt="profile" onerror="this.src = './assets/img/system/defaultimgsq.webp'">
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="myprofile">
                                <i class="fa-solid fa-user"></i>
                                <span>Mi perfil</span>
                            </a></li>
                            <li><a class="dropdown-item" href="settings">
                                <i class="fa-solid fa-gear"></i>
                                <span>Configuración</span>
                            </a></li>
                            <li><hr class="dropdown-divider"></hr></li>
                            <li><a class="dropdown-item" href="logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Cerrar sesión</span>
                            </a></li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div>
                    <a href="login"><button class="button-display"><span>Login</span></button></a>
                </div>
            <?php } ?>
        </div>
    </div>
</header>