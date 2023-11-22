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
if ($arregloUsuario['permisos']['per_reserva'] != '1') {
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
$sql2 = "SELECT COUNT(*) AS totalCategorias FROM libros";
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
    Panel Libros
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


      // Modifica tu consulta SQL para incluir los filtros de estado, prioridad, mes y búsqueda por nombre
      $sql = "SELECT * FROM libros ";

      // Agrega las condiciones de los filtros de estado, prioridad y mes si se han seleccionado
      if (!empty($searchTerm)) {
        $sql .= " WHERE ";
        // Agrega la condición para la búsqueda por nombre
        if (!empty($searchTerm)) {

          $sql .= "libros.titulo LIKE '%$searchTerm%'";
        }
      }
 

      $sql .= " ORDER BY libros.fecha DESC";
      $resultado = $conexion->query($sql) or die($conexion->error);
      ?>


      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Insertar libros</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6 text-right">
                      <button type="button" title="Insertar libro" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Insertar libro
                      </button>
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
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Cod</th>
                        <th>Titulo</th>
                        <th>Autor</th>
                        <th>Edicion</th>
                        <th>Estado</th>
                        <th>Editorial</th>
                        <th>Area</th>
                        <th>clase</th>
                        <th>Disponibilidad</th>
                        <th></th>
                      </tr>

                    </thead>
                    <tbody>

                      <?php while ($f = mysqli_fetch_array($resultado)) { ?>
                        <tr>
                          <td><?php echo $f['coddew']; ?></td>
                          <td><?php echo $f['titulo']; ?></td>
                          <td><?php
                              $res = $conexion->query("SELECT nom_persona FROM autor WHERE id = " . $f['id_autor']);
                              if ($categoria = mysqli_fetch_array($res)) {
                                echo $categoria['nom_persona'];
                              }
                              ?>
                          </td>
                          <td><?php echo $f['edicion']; ?></td>
                          <td><?php
                              $res = $conexion->query("SELECT descrip FROM estado WHERE id = " . $f['id_estado']);
                              if ($categoria = mysqli_fetch_array($res)) {
                                echo $categoria['descrip'];
                              }
                              ?>
                          </td>
                          <td><?php
                              $res = $conexion->query("SELECT descrip FROM editorial WHERE id = " . $f['id_editorial']);
                              if ($categoria = mysqli_fetch_array($res)) {
                                echo $categoria['descrip'];
                              }
                              ?>
                          </td>
                          <td><?php
                              $res = $conexion->query("SELECT descrip FROM areas WHERE id = " . $f['id_area']);
                              if ($categoria = mysqli_fetch_array($res)) {
                                echo $categoria['descrip'];
                              }
                              ?>
                          </td>
                          <td><?php
                              $res = $conexion->query("SELECT descrip FROM clase WHERE id = " . $f['id_clase']);
                              if ($categoria = mysqli_fetch_array($res)) {
                                echo $categoria['descrip'];
                              }
                              ?>
                          </td>
                          <td>
                            <?php
                              switch ($f['existe']) {
                                case 'si':
                                  echo '<span class="badge badge-sm bg-gradient-success">Disponible</span>';
                                  break;
                                case 'no':
                                  echo '<span class="badge badge-sm bg-gradient-danger">ocupado</span>';
                                  break;
                                default:
                                  echo $f['existe'];
                                  break;
                              }
                            ?>
                          </td>
                          <td>

                            <button class="btn btn-primary btn-small btndetalles" title="Ver detalles"  data-id_libro="<?php echo $f['id_libro']; ?>" data-coddew="<?php echo $f['coddew']; ?>" data-titulo="<?php echo $f['titulo']; ?>" data-id_autor="<?php echo $f['id_autor']; ?>" data-edicion="<?php echo $f['edicion']; ?>" data-costo="<?php echo $f['costo']; ?>" data-fecha="<?php echo $f['fecha']; ?>" data-id_estado="<?php echo $f['id_estado']; ?>" data-id_origen="<?php echo $f['id_origen']; ?>" data-id_editorial="<?php echo $f['id_editorial']; ?>" data-id_area="<?php echo $f['id_area']; ?>" data-id_clase="<?php echo $f['id_clase']; ?>" data-observaciones="<?php echo $f['observaciones']; ?>" data-id_seccion="<?php echo $f['id_seccion']; ?>" data-temas="<?php echo $f['temas']; ?>" data-id_ciudad="<?php echo $f['id_ciudad']; ?>" data-codinv="<?php echo $f['codinv']; ?>" data-npag="<?php echo $f['npag']; ?>" data-fimpresion="<?php echo $f['fimpresion']; ?>" data-temas2="<?php echo $f['temas2']; ?>" data-entrainv="<?php echo $f['entrainv']; ?>" data-toggle="modal" data-target="#modalDetalles"><i class="fa fa-eye"></i></button>


                            <?php
                            if ( $arregloUsuario['permisos']['per_reserva'] == '1') {
                              // Mostrar el botón de editar solo si el id_usuario coincide con $idUsuario coment_usuario
                            ?>
                              <button class="btn btn-info btn-small btnEditar" title="Editar libro" data-id_libro="<?php echo $f['id_libro']; ?>" data-coddew="<?php echo $f['coddew']; ?>" data-titulo="<?php echo $f['titulo']; ?>" data-id_autor="<?php echo $f['id_autor']; ?>" data-edicion="<?php echo $f['edicion']; ?>" data-costo="<?php echo $f['costo']; ?>" data-fecha="<?php echo $f['fecha']; ?>" data-id_estado="<?php echo $f['id_estado']; ?>" data-id_origen="<?php echo $f['id_origen']; ?>" data-id_editorial="<?php echo $f['id_editorial']; ?>" data-id_area="<?php echo $f['id_area']; ?>" data-id_clase="<?php echo $f['id_clase']; ?>" data-observaciones="<?php echo $f['observaciones']; ?>" data-id_seccion="<?php echo $f['id_seccion']; ?>" data-temas="<?php echo $f['temas']; ?>" data-id_ciudad="<?php echo $f['id_ciudad']; ?>" data-codinv="<?php echo $f['codinv']; ?>" data-npag="<?php echo $f['npag']; ?>" data-fimpresion="<?php echo $f['fimpresion']; ?>" data-temas2="<?php echo $f['temas2']; ?>" data-entrainv="<?php echo $f['entrainv']; ?>" data-toggle="modal" data-target="#modalEditar">
                                <i class="fa fa-edit"></i>
                              </button>
                            <?php
                            }
                            ?>
                            <?php
                            if ($arregloUsuario['permisos']['per_con'] == '1') {
                              // Tu código aquí si ambas condiciones son verdaderas
                            ?>
                            <!-- <button class="btn btn-danger btn-small btncerrar" title="Eliminar libro" data-id_autor="<?php echo $f['id_autor']; ?>" data-edicion="<?php echo $f['edicion']; ?>" data-costo="<?php echo $f['costo']; ?>" data-id_libro="<?php echo $f['id_libro']; ?>" data-fecha="<?php echo $f['fecha']; ?>" data-id_estado="<?php echo $f['id_estado']; ?>" data-id_origen="<?php echo $f['id_origen']; ?>" data-id_editorial="<?php echo $f['id_editorial']; ?>" data-id_area="<?php echo $f['id_area']; ?>" data-id_clase="<?php echo $f['id_clase']; ?>" data-observaciones="<?php echo $f['observaciones']; ?>" data-id_seccion="<?php echo $f['id_seccion']; ?>" data-temas="<?php echo $f['temas']; ?>" data-id_ciudad="<?php echo $f['id_ciudad']; ?>" data-codinv="<?php echo $f['codinv']; ?>" data-npag="<?php echo $f['npag']; ?>" data-fimpresion="<?php echo $f['fimpresion']; ?>" data-temas2="<?php echo $f['temas2']; ?>" data-temas2="<?php echo $f['entrainv']; ?>" data-toggle="modal" data-target="#modalcerrar">
                                <i class="fa fa-clipboard-check"></i>
                              </button>-->
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
                  <div class="pagination">
                    <?php if ($paginaActual > 1) : ?>
                      <a href="?page=<?php echo $paginaActual - 1; ?>&search=" class="btn btn-primary">Anterior</a>
                    <?php endif; ?>

                    <?php
                    for ($i = 1; $i <= $totalBotones; $i++) :
                    ?>
                      <a href="?page=<?php echo $i; ?>&search=" class="btn btn-primary <?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($paginaActual < $totalCategorias) : ?>
                      <a href="?page=<?php echo $paginaActual + 1; ?>&search=" class="btn btn-primary">Siguiente</a>
                    <?php endif; ?>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    <!-- agregar libros -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/insertarlibro.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Insertar libro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="coddew">codigo</label>
                <input type="text" name="coddew" placeholder="Codigo" id="coddew" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" placeholder="Titulo" id="titulo" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="id_autor">Autor</label>
                <select name="id_autor" id="id_autor" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from autor");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nom_persona'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="edicion">Edicion</label>
                <input type="text" name="edicion" placeholder="Edicion" id="edicion" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="costo">Costo</label>
                <input type="number" name="costo" placeholder="Costo" id="costo" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" placeholder="Fecha" id="fecha" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="id_estado">Estado</label>
                <select name="id_estado" id="id_estado" class="form-control" required>
                  <option value="1">NUEVO</option>
                  <option value="2">BUENO</option>
                  <option value="3">REGULAR</option>
                  <option value="4">MALO</option>
                </select>
              </div>
              <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="id_origen">Origen</label>
                <select name="id_origen" id="id_origen" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from origen");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_editorial">Editorial</label>
                <select name="id_editorial" id="id_editorial" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from editorial");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_area">Area</label>
                <select name="id_area" id="id_area" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from areas");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_clase">Clase</label>
                <select name="id_clase" id="id_clase" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from clase");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="temas">Temas</label>
                <input type="text" name="temas" placeholder="Temas" id="temas" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="id_ciudad">Ciudad</label>
                <select name="id_ciudad" id="id_ciudad" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from ciudad");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_seccion">Seccion</label>
                <select name="id_seccion" id="id_seccion" class="form-control" required>
                  <?php
               $res = $conexion->query("select * from seccion where tipo = '1' ");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="codinv">Codigo invitado</label>
                <input type="text" name="codinv" placeholder="Codigo invitado" id="codinv" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="npag">Numero de paginas</label>
                <input type="number" name="npag" placeholder="Numero de paginas" id="npag" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="fimpresion">Fecha de impresion</label>
                <input type="date" name="fimpresion" placeholder="Fecha de impresion" id="fimpresion" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="temas2">Temas 2</label>
                <input type="text" name="temas2" placeholder="Temas 2" id="temas2" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="entrainv">entrainv</label>
                <input type="text" name="entrainv" placeholder="entrainv" id="entrainv" class="form-control" required>
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
    <!-- agregar libros -->

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="./php/editarlibro.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Editar libro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_libroEdit" name="id_libro">
              <div class="modal-body">
              <div class="form-group">
                <label for="coddewEdit">codigo</label>
                <input type="text" name="coddew" placeholder="Codigo" id="coddewEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="tituloEdit">Titulo</label>
                <input type="text" name="titulo" placeholder="Titulo" id="tituloEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="id_autorEdit">Autor</label>
                <select name="id_autor" id="id_autorEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from autor");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nom_persona'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="edicionEdit">Edicion</label>
                <input type="text" name="edicion" placeholder="Edicion" id="edicionEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="costoEdit">Costo</label>
                <input type="number" name="costo" placeholder="Costo" id="costoEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="fechaEdit">Fecha</label>
                <input type="date" name="fecha" placeholder="Fecha" id="fechaEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="id_estadoEdit">Estado</label>
                <select name="id_estado" id="id_estadoEdit" class="form-control" required>
                  <option value="1">NUEVO</option>
                  <option value="2">BUENO</option>
                  <option value="3">REGULAR</option>
                  <option value="4">MALO</option>
                </select>
              </div>
              <div class="form-group">
                <label for="observacionesEdit">Observaciones</label>
                <textarea name="observaciones" id="observacionesEdit" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="id_origenEdit">Origen</label>
                <select name="id_origen" id="id_origenEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from origen");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_editorialEdit">Editorial</label>
                <select name="id_editorial" id="id_editorialEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from editorial");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_areaEdit">Area</label>
                <select name="id_area" id="id_areaEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from areas");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_claseEdit">Clase</label>
                <select name="id_clase" id="id_claseEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from clase");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="temasEdit">Temas</label>
                <input type="text" name="temas" placeholder="Temas" id="temasEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="id_ciudadEdit">Ciudad</label>
                <select name="id_ciudad" id="id_ciudadEdit" class="form-control" required>
                  <?php
                  $res = $conexion->query("select * from ciudad");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_seccionEdit">Seccion</label>
                <select name="id_seccion" id="id_seccionEdit" class="form-control" required>
                  <?php
               $res = $conexion->query("select * from seccion where tipo = '1' ");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="codinvEdit">Codigo invitado</label>
                <input type="text" name="codinv" placeholder="Codigo invitado" id="codinvEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="npagEdit">Numero de paginas</label>
                <input type="number" name="npag" placeholder="Numero de paginas" id="npagEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="fimpresionEdit">Fecha de impresion</label>
                <input type="date" name="fimpresion" placeholder="Fecha de impresion" id="fimpresionEdit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="temas2Edit">Temas 2</label>
                <input type="text" name="temas2" placeholder="Temas 2" id="temas2Edit" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="entrainvEdit">entrainv</label>
                <input type="text" name="entrainv" placeholder="entrainv" id="entrainvEdit" class="form-control" required>
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
    <!-- Modal Editar -->

    <!-- Modal ver sin editar-->
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditar">Detalles libro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id_libroEdit2" name="id_libro">
              <div class="modal-body">
              <div class="form-group">
                <label for="coddewEdit2">codigo</label>
                <input type="text" name="coddew" placeholder="Codigo" id="coddewEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="tituloEdit2">Titulo</label>
                <input type="text" name="titulo" placeholder="Titulo" id="tituloEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="id_autorEdit2">Autor</label>
                <select name="id_autor" id="id_autorEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from autor");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['nom_persona'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="edicionEdit2">Edicion</label>
                <input type="text" name="edicion" placeholder="Edicion" id="edicionEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="costoEdit2">Costo</label>
                <input type="number" name="costo" placeholder="Costo" id="costoEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="fechaEdit2">Fecha</label>
                <input type="date" name="fecha" placeholder="Fecha" id="fechaEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="id_estadoEdit2">Estado</label>
                <select name="id_estado" id="id_estadoEdit2" class="form-control" required readonly>
                  <option value="1">NUEVO</option>
                  <option value="2">BUENO</option>
                  <option value="3">REGULAR</option>
                  <option value="4">MALO</option>
                </select>
              </div>
              <div class="form-group">
                <label for="observacionesEdit2">Observaciones</label>
                <textarea name="observaciones" id="observacionesEdit2" class="form-control" required readonly></textarea>
              </div>
              <div class="form-group">
                <label for="id_origenEdit2">Origen</label>
                <select name="id_origen" id="id_origenEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from origen");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_editorialEdit2">Editorial</label>
                <select name="id_editorial" id="id_editorialEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from editorial");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_areaEdit2">Area</label>
                <select name="id_area" id="id_areaEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from areas");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_claseEdit2">Clase</label>
                <select name="id_clase" id="id_claseEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from clase");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="temasEdit2">Temas</label>
                <input type="text" name="temas" placeholder="Temas" id="temasEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="id_ciudadEdit2">Ciudad</label>
                <select name="id_ciudad" id="id_ciudadEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from ciudad");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_seccionEdit2">Seccion</label>
                <select name="id_seccion" id="id_seccionEdit2" class="form-control" required readonly>
                  <?php
                  $res = $conexion->query("select * from seccion");
                  while ($f = mysqli_fetch_array($res)) {
                    echo '<option value="' . $f['id'] . '" >' . $f['descrip'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="codinvEdit2">Codigo invitado</label>
                <input type="text" name="codinv" placeholder="Codigo invitado" id="codinvEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="npagEdit2">Numero de paginas</label>
                <input type="number" name="npag" placeholder="Numero de paginas" id="npagEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="fimpresionEdit2">Fecha de impresion</label>
                <input type="date" name="fimpresion" placeholder="Fecha de impresion" id="fimpresionEdit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="temas2Edit2">Temas 2</label>
                <input type="text" name="temas2" placeholder="Temas 2" id="temas2Edit2" class="form-control" required readonly>
              </div>
              <div class="form-group">
                <label for="entrainvEdit2">entrainv</label>
                <input type="text" name="entrainv" placeholder="entrainv" id="entrainvEdit2" class="form-control" required readonly>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  
    <!-- Modal ver sin editar-->

    <!-- Modal eliminar -->
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
        id_libro = $(this).data('id_libro');
        coddew = $(this).data('coddew');
        titulo = $(this).data('titulo');
        existe = $(this).data('existe');
        id_autor = $(this).data('id_autor');
        edicion = $(this).data('edicion');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');
        var id_estado = $(this).data('id_estado');
        var id_origen = $(this).data('id_origen');
        var id_editorial = $(this).data('id_editorial');
        var id_area = $(this).data('id_area');
        var id_clase = $(this).data('id_clase');
        var observaciones = $(this).data('observaciones');
        var id_seccion = $(this).data('id_seccion');
        var temas = $(this).data('temas');
        var id_ciudad = $(this).data('id_ciudad');
        var codinv = $(this).data('codinv');
        var npag = $(this).data('npag');
        var fimpresion = $(this).data('fimpresion');
        var temas2 = $(this).data('temas2');
        var entrainv = $(this).data('entrainv');

        // Asignar valores a los elementos
        $("#id_libroEdit").val(id_libro);
        $("#coddewEdit").val(coddew);
        $("#tituloEdit").val(titulo);
        $("#existeEdit").val(existe);
        $("#id_autorEdit").val(id_autor);
        $("#edicionEdit").val(edicion);
        $("#costoEdit").val(costo);
        $("#fechaEdit").val(fecha);
        $("#id_estadoEdit").val(id_estado);
        $("#id_origenEdit").val(id_origen);
        $("#id_editorialEdit").val(id_editorial);
        $("#id_areaEdit").val(id_area);
        $("#id_claseEdit").val(id_clase);
        $("#observacionesEdit").val(observaciones);
        $("#id_seccionEdit").val(id_seccion);
        $("#temasEdit").val(temas);
        $("#id_ciudadEdit").val(id_ciudad);
        $("#codinvEdit").val(codinv);
        $("#npagEdit").val(npag);
        $("#fimpresionEdit").val(fimpresion);
        $("#temas2Edit").val(temas2);
        $("#entrainvEdit").val(entrainv);
      });

      $(".btndetalles").click(function() {
        id_libro = $(this).data('id_libro');
        coddew = $(this).data('coddew');
        titulo = $(this).data('titulo');
        existe = $(this).data('existe');
        id_autor = $(this).data('id_autor');
        edicion = $(this).data('edicion');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');
        var id_estado = $(this).data('id_estado');
        var id_origen = $(this).data('id_origen');
        var id_editorial = $(this).data('id_editorial');
        var id_area = $(this).data('id_area');
        var id_clase = $(this).data('id_clase');
        var observaciones = $(this).data('observaciones');
        var id_seccion = $(this).data('id_seccion');
        var temas = $(this).data('temas');
        var id_ciudad = $(this).data('id_ciudad');
        var codinv = $(this).data('codinv');
        var npag = $(this).data('npag');
        var fimpresion = $(this).data('fimpresion');
        var temas2 = $(this).data('temas2');
        var entrainv = $(this).data('entrainv');

        // Asignar valores a los elementos
        $("#id_libroEdit2").val(id_libro);
        $("#coddewEdit2").val(coddew);
        $("#tituloEdit2").val(titulo);
        $("#existeEdit2").val(existe);
        $("#id_autorEdit2").val(id_autor);
        $("#edicionEdit2").val(edicion);
        $("#costoEdit2").val(costo);
        $("#fechaEdit2").val(fecha);
        $("#id_estadoEdit2").val(id_estado);
        $("#id_origenEdit2").val(id_origen);
        $("#id_editorialEdit2").val(id_editorial);
        $("#id_areaEdit2").val(id_area);
        $("#id_claseEdit2").val(id_clase);
        $("#observacionesEdit2").val(observaciones);
        $("#id_seccionEdit2").val(id_seccion);
        $("#temasEdit2").val(temas);
        $("#id_ciudadEdit2").val(id_ciudad);
        $("#codinvEdit2").val(codinv);
        $("#npagEdit2").val(npag);
        $("#fimpresionEdit2").val(fimpresion);
        $("#temas2Edit2").val(temas2);
        $("#entrainvEdit2").val(entrainv);
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