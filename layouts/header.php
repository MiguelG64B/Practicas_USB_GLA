<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="./index.php">Principal</a></li>
      </ol>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group">


        </div>
      </div>
      <ul class="navbar-nav  justify-content-end">
        <li class="nav-item d-flex align-items-center">
          </span>
          </a>
        </li>
        <?php
        if (isset($_SESSION['datos_login'])) {
          $arregloUsuario = $_SESSION['datos_login'];
        ?>
          <div class="nav-link text-white font-weight-bold px-0 d-sm-inline d-none">
            <i class="fa fa-user me-sm-1"></i>
            <a href="index.php" title="Panel" class="mnav-link text-white font-weight-bold px-0"><?php echo $arregloUsuario['nombre']; ?></a>
            <span class="mx-2">|</span> <!-- Clase mx-2 para agregar margen horizontal -->
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            <a href="./php/cerrar_sesion.php" title="Cerrar sesion" class="mnav-link text-white font-weight-bold px-0">Salir</a>
          </div>
        <?php } else { ?>
          <li><a href="login.php" title="Login"><input type="submit" class="btn btn-sm btn-primary" value="Inicar"></a></li>
          <li><a href="registro.php" title="Registro"><input type="submit"  class="btn btn-sm btn-primary" value="Registrarse"></a></li>
        <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>