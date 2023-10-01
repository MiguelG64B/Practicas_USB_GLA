<?php
session_start();
include "./php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
  header("Location: ./login.php");
}
$arregloUsuario = $_SESSION['datos_login'];
if ($arregloUsuario['nivel'] != '1') {
  header("Location: ./login.php");
}
$arregloUsuario = $_SESSION['datos_login'];
$idUsuario = $arregloUsuario['id_usuario'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Panel Tickets
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
      // Obtén los valores de los filtros si se han enviado
      $filtroEstado = isset($_GET['estado']) ? $_GET['estado'] : '';
      $filtroPrioridad = isset($_GET['prioridad']) ? $_GET['prioridad'] : '';

      // Modifica tu consulta SQL para incluir los filtros de estado y prioridad, además de la condición de usuario o encargado
      $sql = "SELECT tickets.*, categorias.nombre AS catego FROM tickets ";
      $sql .= "INNER JOIN categorias ON tickets.id_categoria = categorias.id ";
      $sql .= "WHERE tickets.id_usuario = $idUsuario OR tickets.id_encargado = $idUsuario";
      // Agrega las condiciones de los filtros de estado y prioridad si se han seleccionado
      if (!empty($filtroEstado)) {
        if (strpos($sql, "WHERE") !== false) {
          // Si ya hay una condición WHERE en la consulta, agrega AND para unir las condiciones
          $sql .= " AND ";
        } else {
          // Si no hay una condición WHERE, agrégala
          $sql .= " WHERE ";
        }

        $sql .= "tickets.id_estado = " . $filtroEstado;
      }

      if (!empty($filtroPrioridad)) {
        if (strpos($sql, "WHERE") !== false) {
          // Si ya hay una condición WHERE en la consulta, agrega AND para unir las condiciones
          $sql .= " AND ";
        } else {
          // Si no hay una condición WHERE, agrégala
          $sql .= " WHERE ";
        }

        $sql .= "tickets.id_prioridad = " . $filtroPrioridad;
      }

      // Agrega la condición de usuario o encargado
      $sql .= " AND (tickets.id_usuario = $idUsuario OR tickets.id_encargado = $idUsuario)";

      $resultado = $conexion->query($sql) or die($conexion->error);
      ?>



      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Solicitudes</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6 text-right">
                      <button type="button" title="Crear solicitud" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Crear solicitud
                      </button>
                      <form action="" method="GET" class="form-inline">
                        <div class="form-group">
                          <label for="estado">Filtrar por Estado:</label>
                          <select class="form-control" name="estado" id="estado">
                            <option value="">Todos los estados</option>
                            <option value="1">Activo</option>
                            <option value="2">Denegado</option>
                            <option value="3">Finalizado</option>
                            <option value="4">Asignado</option>
                            <!-- Agrega más opciones según tus estados reales -->
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="prioridad">Filtrar por Prioridad:</label>
                          <select class="form-control" name="prioridad" id="prioridad">
                            <option value="">Todas las prioridades</option>
                            <option value="1">Baja</option>
                            <option value="2">Media</option>
                            <option value="3">Alta</option>
                            <!-- Agrega más opciones según tus prioridades reales -->
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                      </form>



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
                        <th>Categoria</th>
                        <th>Titulo</th>
                        <th>Fecha</th>
                        <th>Priorirad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>

                    </thead>
                    <tbody>

                      <?php while ($f = mysqli_fetch_array($resultado)) { ?>
                        <tr>
                          <td><?php echo $f['id_ticket']; ?></td>
                          <td> <?php
                                $res = $conexion->query("SELECT nombre FROM categorias WHERE id = " . $f['id_categoria']);
                                if ($categoria = mysqli_fetch_array($res)) {
                                  echo $categoria['nombre'];
                                }
                                ?>
                          </td>
                          <td>
                            <?php echo $f['titulo']; ?>
                          </td>

                          <td><?php echo $f['fecha']; ?></td>

                          <td> <?php
                                $res = $conexion->query("SELECT nombre FROM prioridad WHERE id = " . $f['id_prioridad']);
                                if ($categoria = mysqli_fetch_array($res)) {
                                  echo $categoria['nombre'];
                                }
                                ?>
                          </td>

                          <td>
                            <?php
                            $res = $conexion->query("SELECT nombre FROM estadoticket WHERE id = " . $f['id_estado']);
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
                          </td>

                          <td>
                            <?php
                            $botonDetalles = '<button class="btn btn-primary btn-small btndetalles" title="Ver detalles" data-id="' . $f['id_ticket'] . '" data-categoria="' . $f['id_categoria'] . '"data-id_usuario="' . $f['id_usuario'] . '" data-prioridad="' . $f['id_prioridad'] . '" data-encargado="' . $f['id_encargado'] . '" data-titulo="' . $f['titulo'] . '" data-editor="' . htmlspecialchars($f['resumen']) . '" data-toggle="modal" data-target="#modalDetalles"><i class="fa fa-eye"></i></button>';

                            if ($f['id_estado'] == 3 || $f['id_estado'] == 4) {
                              // Mostrar el botón "detalles2" si el estado es 3 o 4
                              $botonDetalles = '<button class="btn btn-primary btn-small btndetalles2" title="Ver detalles" data-imagen="' . $f['imagen'] . '" data-id="' . $f['id_ticket'] . '" data-categoria="' . $f['id_categoria'] . '" data-prioridad="' . $f['id_prioridad'] . '" data-encargado="' . $f['id_encargado'] . '" data-titulo="' . $f['titulo'] . '" data-editor="' . htmlspecialchars($f['resumen']) . '" data-toggle="modal" data-target="#modalDetalles2" data-coment_encargado="' . $f['coment_encargado'] . '" data-coment_usuario="' . $f['coment_usuario'] . '" data-estado="' . $f['id_estado'] . '"><i class="fa fa-eye"></i></button>';
                            }
                            echo $botonDetalles;

                            if ($f['id_usuario'] == $idUsuario && ($f['id_estado'] != '3' && $f['id_estado'] != '4')) {
                              // Mostrar el botón de editar solo si el id_usuario coincide con $idUsuario coment_usuario
                            ?>
                              <button class="btn btn-info btn-small btnEditar" title="Editar ticket" data-id="<?php echo $f['id_ticket']; ?>" data-categoria="<?php echo $f['id_categoria']; ?>" data-prioridad="<?php echo $f['id_prioridad']; ?>" data-titulo="<?php echo $f['titulo']; ?>" data-editor="<?php echo htmlspecialchars($f['resumen']); ?>" data-encargado="<?php echo $f['id_encargado']; ?>" data-toggle="modal" data-target="#modalEditar">
                                <i class="fa fa-edit"></i>
                              </button>
                            <?php
                            }
                            ?>
                            <?php
                            if ($f['id_encargado'] == $idUsuario && ($f['id_estado'] != '3' && $f['id_estado'] != '4')) {
                              // Tu código aquí si ambas condiciones son verdaderas
                            ?>
                              <button class="btn btn-danger btn-small btncerrar" title="Cerrar ticket" data-id="<?php echo $f['id_ticket']; ?>" data-id_usuario="<?php echo $f['id_usuario']; ?>" data-estado="<?php echo $f['id_estado']; ?>" data-toggle="modal" data-target="#modalcerrar">
                                <i class="fa fa-clipboard-check"></i>
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
                </div>
              </section>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- agregar tickets -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/insertarticket.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Crear solicitid</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="Titulo">Titulo</label>
                <input type="text" name="titulo" placeholder="Titulo" id="titulo" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="categoria">Categoria(Area encargada)</label>
                <select name="categoria" id="categoria" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from categorias");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="editor">Resumen</label>
                <textarea name="editor" id="editor" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select name="prioridad" id="prioridad" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from prioridad");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <input type="hidden" id="id_usuario" name="id_usuario" value=" <?php echo $arregloUsuario['id_usuario']; ?> " class="form-control" required>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- agregar tickets -->

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/editarticket.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Editar ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idEdit" name="id">
              <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="tituloEdit" name="titulo" placeholder="titulo" id="tituloEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="editor">Contenido</label>
                <textarea name="editor" id="editorEdit" class="form-control editorEdit2" required></textarea>
              </div>
              <div class="form-group">
                <label for="categoriaEdit">Categoria</label>
                <select name="categoria" id="categoriaEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from categorias");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="prioridadEdit">Prioridad</label>
                <select name="prioridad" id="prioridadEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from prioridad");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
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
    <!-- Modal Editar -->
    <!-- Modal ver y asignar -->
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalDetalles" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/encargado.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalDetalles">Detalle ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idDetalles" name="id">
              <input type="hidden" id="id_usuarioDetalles" name="id_usuario">
              <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" placeholder="titulo" id="tituloDetalles" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="editor">Contenido</label>
                <textarea name="editor" id="editorDetalles" class="form-control editorEdit2" readonly></textarea>
              </div>
              <div class="form-group">
                <label for="categoriaDetalles">Categoria</label>
                <select name="categoria" id="categoriaDetalles" class="form-control" required disabled>
                  <?php
                  $res = $conexion->query("select * from categorias");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="prioridadDetalles">Prioridad</label>
                <select name="prioridad" id="prioridadDetalles" class="form-control" required disabled>
                  <?php
                  $res = $conexion->query("select * from prioridad");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="encargadoDetalles">Encargado</label>
                <select name="encargado" id="encargadoDetalles" class="form-control" required>
                  <?php
                  $res = $conexion->query("SELECT u.id, u.nom_persona, t.descrip 
              FROM usuarios u
              LEFT JOIN tipo_usuario t ON u.tipo_usuario = t.id");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '">' . $f['nom_persona'] . ' - ' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary editar">Asignar encargado</button>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- Modal ver y asignar -->

    <!-- Modal ver sin editar-->
    <div class="modal fade" id="modalDetalles2" tabindex="-1" role="dialog" aria-labelledby="modalDetalles2" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/encargado.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalDetalles2">Detalle ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idDetalles2" name="id">
              <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" placeholder="titulo" id="tituloDetalles2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="editor">Contenido</label>
                <textarea name="editor" id="editorDetalles2" class="form-control editorEdit2" readonly></textarea>
              </div>
              <div class="form-group">
                <label for="categoriaDetalles2">Categoria</label>
                <select name="categoria" id="categoriaDetalles2" class="form-control" required disabled>
                  <?php
                  $res = $conexion->query("select * from categorias");
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
                  $res = $conexion->query("select * from prioridad");
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
                  $res = $conexion->query("SELECT u.id, u.nom_persona, t.descrip 
              FROM usuarios u
              LEFT JOIN tipo_usuario t ON u.tipo_usuario = t.id");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '">' . $f['nom_persona'] . ' - ' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="editor">Comentarios encargado</label>
                <textarea name="coment_encargado" id="coment_encargadoDetalles2" class="form-control editorEdit2" readonly></textarea>
              </div>
              <div class="form-group">
                <label for="editor">Comentarios creador</label>
                <textarea name="coment_usuario" id="coment_usuarioDetalles2" class="form-control editorEdit2" readonly></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- Modal ver sin editar-->

    <!-- Modal cerrar -->
    <div class="modal cerrar" id="modalcerrar" tabindex="-1" role="dialog" aria-labelledby="modalcerrar" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/cerrarticket.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalcerrar">Cerrar ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idcerrar" name="id">
              <input type="hidden" id="id_usuariocerrar" name="id_usuario">
              <div class="form-group">
                <label for="editorcerrar">Comentario</label>
                <textarea name="editor" id="editorcerrar" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="estadocerrar">Estado</label>
                <select name="estado" id="estadoEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("SELECT * FROM estadoticket
                  WHERE nombre NOT IN ('Activo', 'Asignado');
                  ");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="imagen">Prueba</label>
                <input type="file" name="imagen" id="imagen" class="form-control" required>
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
    <!-- Modal Editar -->
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
        idEliminar = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: './php/eliminarblog.php',
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
        var titulo = $(this).data('titulo');
        var editor = $(this).data('editor');
        var categoria = $(this).data('categoria');
        var prioridad = $(this).data('prioridad');
        $("#tituloEdit").val(titulo);
        $("#editorEdit").val(editor);
        $("#categoriaEdit").val(categoria);
        $("#prioridadEdit").val(prioridad);
        $("#idEdit").val(idEditar);
      });
      $(".btndetalles").click(function() {
        idDetalles = $(this).data('id');
        id_usuarioDetalles = $(this).data('id_usuario');
        var titulo = $(this).data('titulo');
        var editor = $(this).data('editor');
        var categoria = $(this).data('categoria');
        var prioridad = $(this).data('prioridad');
        var encargado = $(this).data('encargado');
        $("#tituloDetalles").val(titulo);
        $("#editorDetalles").val(editor);
        $("#categoriaDetalles").val(categoria);
        $("#prioridadDetalles").val(prioridad);
        $("#encargadoDetalles").val(encargado);
        $("#id_usuarioDetalles").val(id_usuarioDetalles);
        $("#idDetalles").val(idDetalles);
      });
      $(".btndetalles2").click(function() {
        idDetalles2 = $(this).data('id');
        var titulo = $(this).data('titulo');
        var editor = $(this).data('editor');
        var categoria = $(this).data('categoria');
        var prioridad = $(this).data('prioridad');
        var encargado = $(this).data('encargado');
        var estado = $(this).data('id_estado');
        var imagen = $(this).data('imagen');
        var coment_usuario = $(this).data('coment_usuario');
        var coment_encargado = $(this).data('coment_encargado');
        $("#tituloDetalles2").val(titulo);
        $("#editorDetalles2").val(editor);
        $("#categoriaDetalles2").val(categoria);
        $("#prioridadDetalles2").val(prioridad);
        $("#encargadoDetalles2").val(encargado);
        $("#id_estadoDetalles2").val(estado);
        $("#imagenDetalles2").val(imagen);
        $("#coment_usuarioDetalles2").val(coment_usuario);
        $("#coment_encargadoDetalles2").val(coment_encargado);
        $("#idDetalles2").val(idDetalles2);
      });
      $(".btncerrar").click(function() {
        idcerrar = $(this).data('id');
        id_usuariocerrar = $(this).data('id_usuario');
        var estado = $(this).data('estado');
        var imagen = $(this).data('imagen');
        $("#estadoEdit").val(estado);
        $("#imagen").val(imagen);
        $("#id_usuariocerrar").val(id_usuariocerrar);
        $("#idcerrar").val(idcerrar);
      });
    });
  </script>
  <!-- Code injected by live-server -->



</body>

</html>