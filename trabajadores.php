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

$id_estado = $arregloUsuario['id_estado'];

if ($id_estado != 5 || $arregloUsuario['permisos']['per_niveles'] != '1') {
  header("Location: ./perfil.php");
  exit(); // Asegúrate de que el script se detenga después de redirigir
}

$registrosPorPagina = 10;

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
if ($nivel == 1) {
  $sql = "SELECT * FROM usuarios WHERE id != $idUsuario AND tipo_usuario NOT IN (1,7, 8, 9) AND nom_persona LIKE '%$searchTerm%' LIMIT $offset, $registrosPorPagina;";
} else {
  $sql = "SELECT * FROM usuarios WHERE id_superior = $idUsuario AND nom_persona LIKE '%$searchTerm%' LIMIT $offset, $registrosPorPagina";
}

$estudiantes = mysqli_query($conexion, $sql);

// Consulta SQL con limit, offset y búsqueda
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$sql = "SELECT * FROM usuarios WHERE nombre LIKE '%$searchTerm%' LIMIT $offset, $registrosPorPagina";
$resultado = mysqli_query($conexion, $sql);
$sql2 = "SELECT COUNT(*) AS totalCategorias FROM usuarios WHERE tipo_usuario NOT IN (1,7, 8, 9) ";
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
    Panel Trabajadores
  </title>
  <!-- Fonts and icons -->
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
        <!-- estudiantes -->
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Trabajadores</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="col-sm-3 text-right">
                    <form method="GET" action="">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Buscar por nombre" name="search" value="<?php echo $searchTerm; ?>">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary mb-0" type="submit">Buscar</button>
                        </div>
                      </div>
                    </form>
                    <button type="button" title="Agregar Trabajador" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      <i class="fa fa-plus"></i> Agregar Trabajador
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
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Rol</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Documento</th>
                        <th>Correo</th>
                        <th>Seccion</th>
                        <th>Estado</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($f = mysqli_fetch_array($estudiantes)) {
                      ?>
                        <tr>
                          <td>
                            <?php
                            $res2 = $conexion->query("SELECT descrip FROM tipo_usuario WHERE id = " . $f['tipo_usuario']);
                            if ($seccion = mysqli_fetch_array($res2)) {
                              echo $seccion['descrip'];
                            }
                            ?>
                          </td>
                          <td><?php echo $f['nom_persona']; ?></td>
                          <td><?php echo $f['telefono']; ?></td>
                          <td><?php echo $f['usuario']; ?></td>
                          <td><?php echo $f['email']; ?></td>
                          <td>
                            <?php
                            $res2 = $conexion->query("SELECT descrip FROM seccion WHERE id = " . $f['id_seccion']);
                            if ($seccion = mysqli_fetch_array($res2)) {
                              echo $seccion['descrip'];
                            }
                            ?>
                          </td>
                          <td>
                            <?php
                            $res2 = $conexion->query("SELECT descrip FROM estado WHERE id = " . $f['id_estado']);
                            if ($seccion = mysqli_fetch_array($res2)) {
                              echo $seccion['descrip'];
                            }
                            ?>
                          </td>
                          <td>
                            <button class="btn btn-primary btn-small btnEditar" title="Editar permisos de usuario" data-id="<?php echo $f['id']; ?>" data-per_tickets="<?php echo $f['per_tickets']; ?>" data-per_categoria="<?php echo $f['per_categoria']; ?>" data-per_niveles="<?php echo $f['per_niveles']; ?>" data-per_seccion="<?php echo $f['per_seccion']; ?>" data-per_mistickets="<?php echo $f['per_mistickets']; ?>" data-per_con="<?php echo $f['per_con']; ?>" data-id_superior="<?php echo $f['id_superior']; ?>" data-id_seccion="<?php echo $f['id_seccion']; ?>" data-per_reserva="<?php echo $f['per_reserva']; ?>" data-toggle="modal" data-target="#modalEditar">
                              <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-small btnEliminar" title="Inactivar Trabajador" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                              <i class="fa fa-low-vision"></i>
                            </button>
                            <button class="btn btn-info btn-small btnactivar" title="Activar Trabajador" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalactivar">
                              <i class="fa fa-eye"></i>
                            </button>
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
            <!-- Agregar botones de paginación -->
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/insertartrabajador.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Agregar trabajador</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="usuario">Documento</label>
                <input type="number" name="usuario" placeholder="Documento" id="usuario" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="nombre" id="nombre" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" name="email" placeholder="Correo" id="correo" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" placeholder="Telefono" id="telefono" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="pass" aria-label="Password" required>
              </div>
              <div class="form-group">
                <label for="password">Confirmar Password</label>
                <input type="password" class="form-control" placeholder="Confirmar Password" name="pass2" aria-label="Password" required>
              </div>
              <div class="form-group">
                <label for="id_seccion">Seccion que pertenece</label>
                <select name="id_seccion" id="id_seccion" class="form-control" required>
                  <option value="0"></option>
                  <?php
                  $res = $conexion->query("select * from seccion where tipo = '2' ");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="rol">Rol</label>
                <select name="rol" id="rol" class="form-control" required>
                  <option value="0"></option>
                  <?php
                  $res = $conexion->query("select * from tipo_usuario WHERE id NOT IN (1, 7, 8, 9);");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="superior">superior</label>
                <select name="superior" id="superior" class="form-control" required>
                  <option value="0"></option>
                  <?php
                  $consulta = "SELECT usuarios.id, usuarios.nom_persona, tipo_usuario.descrip 
             FROM usuarios
             INNER JOIN tipo_usuario ON usuarios.tipo_usuario = tipo_usuario.id
             WHERE usuarios.id NOT IN (1, 5, 6, 7, 8, 9)";

                  $res = $conexion->query($consulta);

                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '">' . $f['nom_persona'] . ' (' . $f['descrip'] . ')</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="per_niveles">Modificar y insertar usuarios</label>
                <select class="form-control" name="per_niveles" id="per_niveles">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Crear, atender y asignar tickets</label>
                <select class="form-control" name="per_tickets" id="per_tickets">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Crear solo tickets</label>
                <select class="form-control" name="per_mistickets" id="per_mistickets">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Insertar categorias</label>
                <select class="form-control" name="per_categoria" id="per_categoria">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Insertar secciones</label>
                <select class="form-control" name="per_seccion" id="per_seccion">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Insertar contenido a la biblioteca</label>
                <select class="form-control" name="per_con" id="per_con">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Puede reservar en la biblioteca</label>
                <select class="form-control" name="per_reserva" id="per_reserva">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
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
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/modpermisos.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Editar permisos y superior de trabajador</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idEdit" name="id">
              <div class="form-group">
                <label for="id_seccion">Seccion que pertenece</label>
                <select name="id_seccion" id="id_seccionEdit" class="form-control" required>
                  <option value="0"></option>
                  <?php
                  $res = $conexion->query("select * from seccion where tipo = '2' ");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_superiorEdit">superior</label>
                <select name="id_superior" id="id_superiorEdit" class="form-control" required>
                  <?php
                  $consulta = "SELECT usuarios.id, usuarios.nom_persona, tipo_usuario.descrip 
             FROM usuarios
             INNER JOIN tipo_usuario ON usuarios.tipo_usuario = tipo_usuario.id
             WHERE usuarios.id NOT IN ( 5, 6, 7, 8, 9)";

                  $res = $conexion->query($consulta);

                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '">' . $f['nom_persona'] . ' (' . $f['descrip'] . ')</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="per_nivelesEdit">Modificar y insertar usuarios</label>
                <select class="form-control" name="per_niveles" id="per_nivelesEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="per_ticketsEdit">Crear, atender y asignar tickets</label>
                <select class="form-control" name="per_tickets" id="per_ticketsEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Crear solo tickets</label>
                <select class="form-control" name="per_mistickets" id="per_misticketsEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="per_categoriaEdit">Insertar categorias</label>
                <select class="form-control" name="per_categoria" id="per_categoriaEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Insertar secciones</label>
                <select class="form-control" name="per_seccion" id="per_seccionEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Insertar contenido a la biblioteca</label>
                <select class="form-control" name="per_con" id="per_conEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcionEdit">Puede reservar en la biblioteca</label>
                <select class="form-control" name="per_reserva" id="per_reservaEdit">
                  <option value="0">no</option>
                  <option value="1">Si</option>
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
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Inactivar usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ¿Desea Inactivar este usuario?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">Inactivar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalactivar" tabindex="-1" role="dialog" aria-labelledby="modalactivarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="modalactivarLabel">Activar usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ¿Desea activar este usuario?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-info activar" data-dismiss="modal">Activar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- estudiantes -->
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
      var idactivar = -1;
      var idactivar = -1;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: './php/desactivar.php',
          method: 'POST',
          data: {
            id: idEliminar
          }
        }).done(function(res) {

          $(fila).fadeOut(1000);
        });

      });
      $(".btnactivar").click(function() {
        idactivar = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".activar").click(function() {
        $.ajax({
          url: './php/activar.php',
          method: 'POST',
          data: {
            id: idactivar
          }
        }).done(function(res) {

          $(fila).fadeOut(1000);
        });

      });

      $(".btnEditar").click(function() {
        idEditar = $(this).data('id');
        var rol = $(this).data('rol');
        var id_seccion = $(this).data('id_seccion');
        var id_superior = $(this).data('id_superior');
        var per_niveles = $(this).data('per_niveles');
        var per_tickets = $(this).data('per_tickets');
        var per_reserva = $(this).data('per_reserva');
        var per_categoria = $(this).data('per_categoria');
        var per_con = $(this).data('per_con');
        var per_seccion = $(this).data('per_seccion');
        var per_mistickets = $(this).data('per_mistickets');
        $("#idEdit").val(idEditar);
        $("#rolEdit").val(rol);
        $("#id_seccionEdit").val(id_seccion);
        $("#id_superiorEdit").val(id_superior);
        $("#per_nivelesEdit").val(per_niveles);
        $("#per_ticketsEdit").val(per_tickets);
        $("#per_reservaEdit").val(per_reserva);
        $("#per_categoriaEdit").val(per_categoria);
        $("#per_seccionEdit").val(per_seccion);
        $("#per_misticketsEdit").val(per_mistickets);
        $("#per_conEdit").val(per_con);
      });
    });
  </script>

  <!-- Code injected by live-server -->



</body>

</html>