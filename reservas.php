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
$id_seccion = $arregloUsuario['id_seccion'];

// Verifica si 'per_tickets' es igual a 'si'
if ($arregloUsuario['permisos']['per_con'] != '1' || $arregloUsuario['permisos']['per_reserva'] != '1') {
  // Si 'per_tickets' no es igual a 'si', puedes redirigir a otra página o mostrar un mensaje de error.
  header("Location: ./perfil.php");
  exit(); // Asegúrate de que el script se detenga después de redirigir
}
$registrosPorPagina = 50;

// Página actual
if (isset($_GET['page'])) {
  $paginaActual = $_GET['page'];
} else {
  $paginaActual = 1;
}

// Búsqueda por nombre
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Calcular el desplazamiento (offset) para la consulta SQL
$offset = ($paginaActual - 1) * $registrosPorPagina;
// Consulta SQL con limit y offset



// Consulta SQL con limit, offset y búsqueda
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$sql2 = "SELECT COUNT(*) AS totalCategorias FROM reservas";
$resultado2 = mysqli_query($conexion, $sql2);
$row = mysqli_fetch_assoc($resultado2);
$totalCategorias = $row['totalCategorias'];
$totalBotones = round($totalCategorias / $registrosPorPagina);

// Calcular el número total de páginas
$totalRegistros = mysqli_num_rows($resultado2); // Reemplaza con la cantidad total de registros en tu tabla
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Panel Reservas
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
  <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
  <link type="text/css" href="sample/css/sample.css" rel="stylesheet" media="screen" />
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });
  </script>
  <script>
    ClassicEditor
      .create(document.querySelector('#editorEdit'))
      .catch(error => {
        console.error(error);
      });
  </script>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include("./layouts/admin/header.php"); ?>
  <main class="main-content position-relative border-radius-lg ps">
    <!-- Navbar -->
    <?php include("./layouts/header.php"); ?>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
      <?php
      $sql = "SELECT reservas.*, libros.titulo, libros.coddew, libros.id_libro
          FROM reservas 
          INNER JOIN libros ON reservas.id_libro = libros.id_libro";

      if (!empty($searchTerm)) {
        $sql .= " WHERE libros.titulo LIKE '%$searchTerm%'";
      }

      if ($arregloUsuario['permisos']['per_reserva'] == '1') {
        $sql .= " AND reservas.id_usuario = '$idUsuario' AND reservas.entregado = 'no'";
      }

      $sql .= " ORDER BY reservas.fecha_reserva DESC ";
      $resultado = $conexion->query($sql) or die($conexion->error);
      ?>



      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Reservas</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6 text-right">
                      <td>
                        <div class="container">
                          <form action="" method="GET" class="form-inline">
                            <div class="row">
                              <div class="">
                                <form method="GET" action="">
                                  <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Buscar por titulo" name="search" value="<?php echo $searchTerm; ?>">

                                  </div>
                                  <div class="input-group-append">
                                    <button class="btn btn-outline-primary mb-0" type="submit">Buscar</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </form>
                        </div>
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
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Cod de libro</th>
                          <th>Titulo</th>
                          <th>Responsable</th>
                          <th>Fecha de reserva</th>
                          <th>Fecha limite de entrega</th>
                          <th>Tiempo restante</th>
                          <th>Estado</th>
                        </tr>

                      </thead>
                      <tbody>

                        <?php while ($f = mysqli_fetch_array($resultado)) { ?>
                          <tr>
                            <td><?php echo $f['coddew']; ?></td>
                            <td><?php echo $f['titulo']; ?></td>
                            <td><?php
                                $res = $conexion->query("SELECT nom_persona FROM usuarios WHERE id = " . $f['id_usuario']);
                                if ($categoria = mysqli_fetch_array($res)) {
                                  echo $categoria['nom_persona'];
                                }
                                ?>
                            </td>
                            <td><?php echo $f['fecha_reserva']; ?></td>
                            <td><?php echo $f['fecha_limite']; ?></td>
                            <td>
                              <?php
                              $fecha_limite_timestamp = strtotime($f['fecha_limite']);
                              $fecha_actual_timestamp = time(); // Current timestamp

                              if ($fecha_actual_timestamp <= $fecha_limite_timestamp) {
                                // The current date is before or equal to the deadline
                                $dias_restantes = ceil(($fecha_limite_timestamp - $fecha_actual_timestamp) / (60 * 60 * 24)); // Calcula los días restantes

                                echo '<span class="badge badge-sm bg-gradient-success">A tiempo</span>';
                                echo "<br>";
                                echo "Días restantes: " . $dias_restantes;
                              } else {
                                // The current date is after the deadline
                                echo '<span class="badge badge-sm bg-gradient-danger">Atrasado</span>';
                              }
                              ?>

                            </td>
                            <td> <?php
                                  switch ($f['entregado']) {
                                    case 'si':
                                      echo '<span class="badge badge-sm bg-gradient-success">Entregado</span>';
                                      break;
                                    case 'no':
                                      echo '<span class="badge badge-sm bg-gradient-danger">Pendiente</span>';
                                      break;
                                    default:
                                      echo $f['existe'];
                                      break;
                                  }
                                  ?></td>
                            <td>
                              <?php
                              if ($arregloUsuario['permisos']['per_con'] == '1') {
                                // Mostrar el botón de editar solo si el id_usuario coincide con $idUsuario coment_usuario
                              ?>
                                <button class="btn btn-default btn-small btnReservar" title="Notificar entrega de libro" data-id_libro="<?php echo $f['id_libro']; ?>" data-id_reserva="<?php echo $f['id_reserva']; ?>" data-id_usuario="<?php echo $f['id_usuario']; ?>" data-toggle="modal" data-target="#modalReserva">
                                  <i class="fa fa-calendar-check-o"></i>
                                </button>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                  <ul class="pagination pagination-success">
                    <?php if ($paginaActual > 1) : ?>
                      <li class="page-item">
                        <a href="?page=<?php echo $paginaActual - 1; ?>&search=" class="page-link" aria-label="Previous">
                          <i class="fa fa-angle-left"></i>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php
                    $maxButtons = 4; // Número máximo de botones a mostrar
                    $start = max(1, $paginaActual - floor($maxButtons / 2));
                    $end = min($start + $maxButtons - 1, $totalBotones);

                    for ($i = $start; $i <= $end; $i++) :
                    ?>
                      <li class="page-item <?php if ($i == $paginaActual) echo 'active'; ?>">
                        <a href="?page=<?php echo $i; ?>&search=" class="page-link"><?php echo $i; ?></a>
                      </li>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalCategorias) : ?>
                      <li class="page-item">
                        <a href="?page=<?php echo $paginaActual + 1; ?>&search=" class="page-link" aria-label="Next">
                          <i class="fa fa-angle-right"></i>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    <?php endif; ?>
                  </ul>
                </nav>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
      <!-- agregar libros -->

    </div>
    <!-- eliminar libros -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar libro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ¿Desea eliminar este libro?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- reserva -->
    <div class="modal fade" id="modalReserva" tabindex="-1" role="dialog" aria-labelledby="modalReserva" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/entregalibro.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalReserva">Notificar entrega Libro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_libroReserva" name="id_libro">
              <input type="hidden" id="id_Reserva" name="id_reserva">
              <input type="hidden" id="id_usuarioReserva" name="id_usuario" required>
              <div class="modal-body">
                <div class="form-group">
                  <label for="">Comentarios de biblioteca</label>
                  <textarea name="comentarios" id="comentarios" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary editar">Guardar</button>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- reserva -->


    <!-- Modal eliminar -->

    <!-- Modal eliminar -->

    <?php include("./layouts/footer.php"); ?>
  </main>


  <script src="ckeditor.js"></script>

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
  <!-- jQuery UI 1.11.4 -->
  <script src="./dashboard/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="./dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="./dashboard/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="./dashboard/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="./dashboard/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="./dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="./dashboard/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="./dashboard/plugins/moment/moment.min.js"></script>
  <script src="./dashboard/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="./dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="./dashboard/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="./dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dashboard/dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="./dashboard/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./dashboard/dist/js/demo.js"></script>
  <script>
    $(document).ready(function() {
      var idEliminar = -1;
      var idEditar = -1;
      var fila;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id_libro');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: './php/eliminalibro.php',
          method: 'POST',
          data: {
            id: idEliminar
          }
        }).done(function(res) {

          $(fila).fadeOut(1000);
        });

      });

      $(".btnReservar").click(function() {
        id_libroReserva = $(this).data('id_libro');
        id_reserva = $(this).data('id_reserva');
        id_usuario = $(this).data('id_usuario');
        $("#id_libroReserva").val(id_libroReserva);
        $("#id_usuarioReserva").val(id_usuario);
        $("#id_Reserva").val(id_reserva);
      });
    });
  </script>
  <!-- Code injected by live-server -->



</body>

</html>