<?php
session_start();
include "./php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
  header("Location: ./index.php");
}

$arregloUsuario = $_SESSION['datos_login'];

include("./php/conexion.php");
if (isset($_GET['id']) && isset($_GET['comentarios'])) {
  $resultado = $conexion->query("select * from tickets where id_ticket=" . $_GET['id']) or die($conexion->error);
  if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_row($resultado);
  } else {
    header("Location: ./index.php");
  }
} else {
  //redireccionar
  header("Location: ./index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Panel Satisfaccion
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Agrega jQuery a tu página -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include("./layouts/admin/header.php"); ?>
  <main class="main-content position-relative border-radius-lg ps">
    <!-- Navbar -->
    <?php include("./layouts/header.php"); ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4 mx-auto">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Satisfaccion Ticket</h6>
            </div>
            <div class="content-wrapper">
              <section class="content">
                <div class="container-fluid">
                  <?php
                  if (isset($_GET['error'])) {
                  ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $_GET['error']; ?>
                    </div>
                  <?php } ?>

                  <?php
                  if (isset($_GET['success'])) {
                  ?>
                    <div class="alert alert-success" role="alert">
                      Se ha insertado correctamente.
                    </div>
                  <?php } ?>
                </div>
                <form class="needs-validation" action="./php/satisfaccion.php" method="post" novalidate onsubmit="return validarFormulario(this);">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-6">
                        <?php
                        $res = $conexion->query("SELECT nombre FROM estadoticket WHERE id = " . $fila['8']);
                        if ($estado = mysqli_fetch_array($res)) {
                          switch ($estado['nombre']) {
                            case 'Activo':
                              echo '<span class="badge badge-sm bg-gradient-success">'  . $estado['nombre'] . '</span>';
                              break;
                            case 'Denegado':
                              echo '<span class="badge badge-sm bg-gradient-danger">'  . $estado['nombre'] . '</span>';
                              break;
                            case 'Finalizado':
                              echo '<span class="badge badge-sm bg-gradient-secondary">'  . $estado['nombre'] . '</span>';
                              break;
                            case 'Asignado':
                              echo '<span class="badge badge-sm bg-gradient-info">'  . $estado['nombre'] . '</span>';
                              break;
                            default:
                              echo $estado['nombre'];
                              break;
                          }
                        }
                        ?>
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalDetalles2">Detalle ticket</h5>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" id="id" value="<?php echo $fila[0]; ?>" name="id">

                          <div class="form-group">
                            <label for="titulo">Titulo</label>
                            <input type="text" name="titulo" value="<?php echo $fila[3]; ?>" id="tituloDetalles2" class="form-control" required readonly>
                          </div>

                          <div class="form-group">
                            <label for="editor">Contenido</label>
                            <textarea name="editor" id="editorDetalles2" class="form-control editorEdit2" readonly><?php echo $fila[4]; ?></textarea>
                          </div>

                          <div class="form-group">
                            <label for="categoriaDetalles2">Categoria</label>
                            <select name="categoria" id="categoriaDetalles2" class="form-control" required disabled>
                              <?php
                              $id_categoria = $fila[2];
                              $query = "SELECT c.id, c.nombre
                          FROM categorias c
                          WHERE c.id = $id_categoria";
                              $res = $conexion->query($query);
                              while ($f = mysqli_fetch_array($res)) {
                                echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="prioridadDetalles2">Prioridad</label>
                            <select name="prioridad" id="prioridadDetalles2" class="form-control" required disabled>
                              <?php
                              $id_prioridad = $fila[5];
                              $query = "SELECT p.id, p.nombre
                          FROM prioridad p
                          WHERE p.id = $id_prioridad";
                              $res = $conexion->query($query);
                              while ($f = mysqli_fetch_array($res)) {
                                echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="encargadoDetalles2">Encargado</label>
                            <select name="encargado" id="encargadoDetalles2" class="form-control" required disabled>
                              <?php
                              $id_encargado = $fila[6];
                              $query = "SELECT u.id, u.nom_persona, t.descrip 
                          FROM usuarios u
                          LEFT JOIN tipo_usuario t ON u.tipo_usuario = t.id
                          WHERE u.id = $id_encargado";
                              $res = $conexion->query($query);
                              while ($f = mysqli_fetch_array($res)) {
                                echo '<option value="' . $f['id'] . '">' . $f['nom_persona'] . ' - ' . $f['descrip'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="editor">Comentarios encargado</label>
                            <textarea name="coment_encargado" id="coment_encargadoDetalles2" class="form-control editorEdit2" readonly><?php echo $fila[9]; ?></textarea>
                          </div>

                          <div class="col-md-6">
                            <label>Prueba</label>
                            <img src="images/<?php echo $fila[12]; ?>" alt="<?php echo $fila[1]; ?>" class="img-fluid">
                          </div>
                          <?php
                          $res = $conexion->query("SELECT coment_usuario FROM tickets WHERE id_ticket = " . $fila['0']);
                          if ($res) {
                            // La consulta se ejecutó correctamente, ahora puedes verificar si hay resultados
                            $coment = mysqli_fetch_array($res);
                            if ($coment && $coment['coment_usuario'] == 'N/A') { ?>
                              <div class="form-group">
                                <label for="editor">Comentarios creador</label>
                                <textarea name="coment_usuario" id="coment_usuarioDetalles2" class="form-control editorEdit2" required></textarea>
                              </div>

                              <div class="form-group">
                                <label for="encargadoDetalles2">Satisfacción</label>
                                <select name="satisfaccion" class="form-control" required>
                                  <?php
                                  $res = $conexion->query("SELECT * FROM satisfaccion");
                                  while ($f = mysqli_fetch_array($res)) {
                                    echo '<option value="' . $f['id_satisfaccion'] . '">' . $f['tipo'] . '</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="modal-footer d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                              </div>
                            <?php } else { ?>
                              <!-- Bloque para mostrar los mismos inputs pero deshabilitados -->
                              <div class="form-group">
                                <label for="editor">Comentarios creador (No editable)</label>
                                <textarea name="coment_usuario" id="coment_usuarioDetalles2" class="form-control" readonly disabled><?php echo $fila[10]; ?></textarea>
                              </div>

                              <div class="form-group">
                                <label for="encargadoDetalles2">Satisfacción (No editable)</label>
                                <select name="satisfaccion" class="form-control" disabled>
                                  <?php
                              $id_satisfaccion = $fila[11]; // Supongo que aquí tienes el valor de $fila[12]

                              $query = "SELECT s.id_satisfaccion, s.tipo
                                        FROM satisfaccion s
                                        WHERE s.id_satisfaccion = $id_satisfaccion";
                              
                              $res = $conexion->query($query);
                              
                              while ($f = mysqli_fetch_array($res)) {
                                  echo '<option value="' . $f['id_satisfaccion'] . '">' . $f['tipo'] . '</option>';
                              }
                                  ?>
                                </select>
                              </div>
                          <?php }
                          } else {
                            // La consulta falló, puedes manejar el error aquí
                            echo "Error en la consulta: " . mysqli_error($conexion);
                          }
                          ?>

                        </div>
                      </div>
                    </div>
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
</body>

</html>