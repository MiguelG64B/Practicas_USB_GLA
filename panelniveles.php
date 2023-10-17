<?php
session_start();
include "./php/conexion.php";

// Verifica si el usuario ha iniciado sesión y tiene permisos adecuados
if (!isset($_SESSION['datos_login'])) {
  header("Location: ./login.php");
  exit(); // Asegúrate de que el script se detenga después de redirigir
}

$arregloUsuario = $_SESSION['datos_login'];
$idUsuario = $arregloUsuario['id_usuario'];
$nivel = $arregloUsuario['nivel'];

if ($arregloUsuario['permisos']['per_niveles'] != 'si') {
  header("Location: ./missolicitudes.php");
  exit(); // Asegúrate de que el script se detenga después de redirigir
}

if ($nivel == 1) {
  $sql = "SELECT * FROM permisos";
} else {
  $sql = "SELECT * FROM permisos WHERE id_superior = $idUsuario";
}

$resultado = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Panel Permisos
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
              <h6>Permisos</h6>
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
                <table class="table">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Rol</th>
                      <th>Nombre</th>
                      <th>Superior</th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($resultado)) {
                    ?>
                      <tr>
                        <td><?php echo $f['id_permiso']; ?></td>
                        <td>
                          <?php
                          $res = $conexion->query("SELECT tu.descrip 
                           FROM usuarios AS u 
                           INNER JOIN tipo_usuario AS tu ON u.id_permiso = tu.id 
                           WHERE u.id = " . $f['id_usuario']);

                          if ($categoria = mysqli_fetch_array($res)) {
                            echo $categoria['descrip'];
                          }
                          ?>
                        </td>
                        <td> <?php
                              $res2 = $conexion->query("SELECT nom_persona FROM usuarios WHERE id = " . $f['id_usuario']);
                              if ($usuario = mysqli_fetch_array($res2)) {
                                echo $usuario['nom_persona'];
                              }
                              ?>
                        </td>
                        <td> <?php
                              $res3 = $conexion->query("SELECT nom_persona FROM usuarios WHERE id = " . $f['id_superior']);
                              if ($superior = mysqli_fetch_array($res3)) {
                                echo $superior['nom_persona'];
                              }
                              ?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-small btnEditar" data-id="<?php echo $f['id_permiso']; ?>" data-per_conlibro="<?php echo $f['per_conlibro']; ?>" data-per_libros="<?php echo $f['per_libros']; ?>" data-per_tickets="<?php echo $f['per_tickets']; ?>" data-per_categoria="<?php echo $f['per_categoria']; ?>" data-per_niveles="<?php echo $f['per_niveles']; ?>" data-id_usuario="<?php echo $f['id_usuario']; ?>" data-id_superior="<?php echo $f['id_superior']; ?>" data-toggle="modal" data-target="#modalEditar">
                            <i class="fa fa-edit"></i>
                          </button>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </section>
          </div>


        </div>

        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/modpermisos.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditar">Editar Permisos</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="idEdit" name="id">

                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="nombreEdit" name="nombre" placeholder="nombre" id="nombreEdit" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcionEdit">Descripcion</label>
                    <input type="text" name="descripcion" placeholder="descripcion" id="descripcionEdit" class="form-control" required>
                  </div>
                  <div class="form-group">
                  <label for="descripcionEdit">Insertar libros</label>
                  <select class="form-control" name="libroEdit" id="conlibroEdit">
                    <option value="conlibroEdit"></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                  </select>
                  </div>
                  <div class="form-group">
                  <label for="descripcionEdit">Modificar niveles</label>
                  <select class="form-control" name="nivelesEdit" id="nivelesEdit">
                    <option value="nivelesEdit"></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                  </select>
                  </div>
                  <div class="form-group">
                  <label for="descripcionEdit">Crear y atender tickets</label>
                  <select class="form-control" name="ticketsEdit" id="ticketsEdit">
                    <option value="ticketsEdit"></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                  </select>
                  </div>
                  <div class="form-group">
                  <label for="descripcionEdit">Insertar categorias</label>
                  <select class="form-control" name="categoriaEdit" id="categoriaEdit">
                    <option value="categoriaEdit"></option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                  </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary editar">Guardar</button>
                </div>
              </form>
            </div>
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
        var conlibro = $(this).data('conlibro');
        var libros = $(this).data('libros');
        var tickets = $(this).data('tickets');
        var categoria = $(this).data('categoria');
        var superior = $(this).data('superior');
        var niveles = $(this).data('niveles');
        var usuario = $(this).data('usuario');
        $("#conlibroEdit").val(conlibro);
        $("#superiorEdit").val(superior);
        $("#nivelesEdit").val(niveles);
        $("#usuarioEdit").val(usuario);
        $("#librosEdit").val(libros);
        $("#ticketsEdit").val(tickets);
        $("#categoriaEdit").val(categoria);
        $("#idEdit").val(idEditar);
      });
    });
  </script>

  <!-- Code injected by live-server -->



</body>

</html>