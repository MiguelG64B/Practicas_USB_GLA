<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class=" m-0 d-flex justify-content-center align-items-center" target="_blank">
      <img src="./images/logo.png" width="100" height="80" alt="Gimnasio Los Almendros" id="logo" data-height-percentage="100">
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto ps" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      
      <?php if ($arregloUsuario['permisos']['per_tickets'] == '1'|| $arregloUsuario['permisos']['per_mistickets'] == '1'|| $arregloUsuario['permisos']['per_crear'] == '1') { ?>
        <li class="list-group mt-2">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning opacity-10"></i>
            </div>
            <span class="nav-link-text">Solicitudes</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if ($arregloUsuario['permisos']['per_tickets'] == '1') { ?>
              <a class="dropdown-item" href="index.php">Todas las Solicitudes</a>
            <?php } ?>
            <?php if ($arregloUsuario['permisos']['per_mistickets'] == '1' || $arregloUsuario['permisos']['per_crear'] == '1') { ?>
              <a class="dropdown-item" href="mistickets.php">Mis solicitudes</a>
            <?php } ?>
          </div>
        </li>
      <?php } ?>
      <?php if ($arregloUsuario['permisos']['per_niveles'] == '1') { ?>
        <li class="list-group mt-2">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning opacity-10"></i>
            </div>
            <span class="nav-link-text">Gestion de Permisos</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if ($arregloUsuario['permisos']['per_niveles'] == '1') { ?>
              <a class="dropdown-item" href="trabajadores.php">Trabajadores</a>
              <a class="dropdown-item" href="estudiantes.php">Estudiantes</a>
              <a class="dropdown-item" href="egresadosfamilia.php">Egresados/Familiares</a>
            <?php } ?>
          </div>
        </li>
      <?php } ?>

      <?php if ($arregloUsuario['permisos']['per_categoria'] == '1' || $arregloUsuario['permisos']['per_seccion'] == '1' || $arregloUsuario['permisos']['per_con'] == '1') { ?>
        <li class="list-group mt-2">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning opacity-10"></i>
            </div>
            <span class="nav-link-text">Mantenimiento</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if ($arregloUsuario['permisos']['per_categoria'] == '1') { ?>
              <a class="dropdown-item" href="panelcategorias.php">Categorias</a>
            <?php } ?>
            <?php if ($arregloUsuario['permisos']['per_seccion'] == '1') { ?>
              <a class="dropdown-item" href="panelseccion.php">Secciones</a>
            <?php } ?>
            <?php if ($arregloUsuario['permisos']['per_con'] == '1') { ?>
              <a class="dropdown-item" href="panelarea.php">Areas</a>
              <a class="dropdown-item" href="panelautor.php">Autor</a>
              <a class="dropdown-item" href="panelciudad.php">Ciudad</a>
              <a class="dropdown-item" href="panelclase.php">Clase</a>
              <a class="dropdown-item" href="paneleditorial.php">Editorial</a>
            <?php } ?>
          </div>
        </li>
      <?php } ?>
      <?php if ($arregloUsuario['permisos']['per_con'] == '1') { ?>
      <li class="nav-item">
        <a class="nav-link" title="Libreria" href="panellibros.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Libreria</span>
        </a>
      </li>
      <?php } ?>
      <!-- Otros elementos de la lista si es necesario -->
    </ul>
  </div>
</aside>

