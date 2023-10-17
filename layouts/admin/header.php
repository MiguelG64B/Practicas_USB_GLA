<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 ps" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" target="_blank">
      <span class="ms-1 font-weight-bold">Gimnasio Los Almendros</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto ps" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" title="Perfil" href="perfil.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Perfil</span>
        </a>
      </li>
      <ul class="navbar-nav">
      <!--<li class="nav-item">
        <a class="nav-link" title="Perfil" href="perfil.php">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">libros</span>
        </a>
      </li>-->
      <?php if ($arregloUsuario['permisos']['per_niveles'] == 'si') { ?>
        <li class="nav-item">
          <a class="nav-link" title="Gestion de Permisos" href="panelniveles.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1" >Gestion de Permisos</span>
          </a>
        </li>
      <?php } ?>
      <?php if ($arregloUsuario['permisos']['per_categoria'] == 'si') { ?>
        <li class="nav-item">
          <a class="nav-link" title="Categorias" href="panelcategorias.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1" >Categorias</span>
          </a>
        </li>
      <?php } ?>
      <?php if ($arregloUsuario['permisos']['per_tickets'] == 'si') { ?>
        <li class="nav-item">
          <a class="nav-link" title="Solicitudes" href="index.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1" >Solicitudes</span>
          </a>
        </li>
      <?php } ?>
      <?php if ($arregloUsuario['permisos']['per_mistickets'] == 'si') { ?>
        <li class="nav-item">
          <a class="nav-link" title="Mis solicitudes" href="missolicitudes.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-caret-right text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1" >Mis solicitudes</span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </div>
</aside>
