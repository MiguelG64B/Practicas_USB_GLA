<?php
session_start();
include "./php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
  header("Location: ./index.php");
}

$arregloUsuario = $_SESSION['datos_login'];
if($arregloUsuario['nivel']!= '1'){ 
  header("Location: ./index.php");
}  

$arregloUsuario = $_SESSION['datos_login'];

$sql = "SELECT * FROM categorias";
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
              <div class="content-header">
                <div class="container-fluid">
                        <div class="col-sm-6 text-right">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Agregar categoria
                      </button>
                    </div>
                  </div>
                </div>
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
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th></th>
                      </tr>

                    </thead>
                    <tbody>

                      <?php
                      while ($f = mysqli_fetch_array($resultado)) {
                      ?>
                        <tr>
                          <td><?php echo $f['id']; ?></td>
                          <td>
                            <?php echo $f['nombre']; ?>
                          </td>
                          <td><?php echo $f['descripcion']; ?></td>
                          <td>
                            <button class="btn btn-primary btn-small btnEditar" data-id="<?php echo $f['id']; ?>" data-nombre="<?php echo $f['nombre']; ?>" data-descripcion="<?php echo $f['descripcion']; ?>" data-toggle="modal" data-target="#modalEditar">
                              <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-small btnEliminar" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                              <i class="fa fa-trash"></i>
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


          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form action="./php/insertarcategorias.php" method="POST" enctype="multipart/form-data">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Insertar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" name="nombre" placeholder="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="descripcion">Descripcion</label>
                      <input type="text" name="descripcion" placeholder="descripcion" id="descripcion" class="form-control" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="modalEliminarLabel">Eliminar categoria</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ¿Desea eliminar esta categoria?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">Eliminar</button>
                </div>

              </div>
            </div>
          </div>

          <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form action="./php/editarcategoria.php" method="POST" enctype="multipart/form-data">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditar">Editar categoria</h5>
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