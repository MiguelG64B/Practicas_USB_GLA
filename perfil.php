<?php
session_start();
include "./php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
  header("Location: ./index.php");
}

$arregloUsuario = $_SESSION['datos_login'];
if ($arregloUsuario['nivel'] != '1') {
  header("Location: ./index.php");
}

$arregloUsuario = $_SESSION['datos_login'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Panel Categorias
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include("./layouts/admin/header.php"); ?>
  <main class="main-content position-relative border-radius-lg ps">
    <!-- Navbar -->
    <?php include("./layouts/header.php"); ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Categorias</h6>
            </div>
            <div class="content-wrapper">

            </div>

            <section class="content">
              <div class="container-fluid">

                <?php
                if (isset($_GET['error'])) {
                ?>
                  <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error']; ?>
                  </div>

                <?php  } ?>
                <?php
                if (isset($_GET['success'])) {
                ?>
                  <div class="alert alert-success" role="alert">
                    Se ha insertado correctamente.
                  </div>

                <?php  } ?>

              </div>
              <form class="needs-validation" action="./php/editarperfil.php" method="post" novalidate>
                <div class="form-group container">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="nombre">Nombre</label>
                      <input type="text" name="nombre" value="<?php echo $arregloUsuario['nombre']; ?>" id="nombreEdit" class="form-control" required>
                      <div class="valid-feedback">Ya es válido</div>
                      <div class="invalid-feedback">Complete los campos</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="telefono">Telefono</label>
                      <input type="text" name="telefono" value="" id="telefonoEdit" class="form-control" required>
                      <div class="valid-feedback">Ya es válido</div>
                      <div class="invalid-feedback">Complete los campos</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="pass1">Contraseña</label>
                      <input type="password" name="pass1" value="" id="pass1" class="form-control" required>
                      <div class="valid-feedback">Ya es válido</div>
                      <div class="invalid-feedback">Complete los campos</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="pass2">Validar Contraseña</label>
                      <input type="password" name="pass2" value="" id="pass2" class="form-control" required>
                      <div class="valid-feedback">Ya es válido</div>
                      <div class="invalid-feedback">Complete los campos</div>
                    </div>
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $arregloUsuario['id_usuario']; ?>" class="form-control" required>
                  </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>

            </section>
          </div>
        </div>
      </div>
    </div>
    </div>

    <?php include("./layouts/footer.php"); ?>
  </main>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Github buttons -->
  <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script src="./dashboard/plugins/jquery/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var idEliminar = -1;
      var idEditar = -1;
      var fila;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: './php/eliminarcategoria.php',
          method: 'POST',
          data: {
            id: idEliminar
          }
        }).done(function(res) {

          $(fila).fadeOut(1000);
        });

      });
      $(".btnEditar").click(function() {
        idEditar = $(this).data('id');
        var nombre = $(this).data('nombre');
        var descripcion = $(this).data('descripcion');
        $("#nombreEdit").val(nombre);
        $("#descripcionEdit").val(descripcion);
        $("#idEdit").val(idEditar);
      });
    });
  </script>

  <!-- Code injected by live-server -->



</body>

</html>