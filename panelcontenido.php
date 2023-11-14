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

if ($arregloUsuario['permisos']['per_seccion'] != '1') {
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

// Calcular el desplazamiento (offset) para la consulta SQL
$offset = ($paginaActual - 1) * $registrosPorPagina;

// Consulta SQL con limit y offset
$sql = "SELECT * FROM areas LIMIT $offset, $registrosPorPagina";
$areas = mysqli_query($conexion, $sql);
$sql2 = "SELECT * FROM autor LIMIT $offset, $registrosPorPagina";
$autor = mysqli_query($conexion, $sql2);
$sql3 = "SELECT * FROM ciudad LIMIT $offset, $registrosPorPagina";
$ciudad = mysqli_query($conexion, $sql3);
$sql4 = "SELECT * FROM clase LIMIT $offset, $registrosPorPagina";
$clase = mysqli_query($conexion, $sql4);
$sql5 = "SELECT * FROM editorial LIMIT $offset, $registrosPorPagina";
$editorial = mysqli_query($conexion, $sql5);
// Calcular el número total de páginas
$totalRegistros = mysqli_num_rows($areas); // Reemplaza con la cantidad total de registros en tu tabla
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
    Panel Contenido de libros
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
        <!-- area -->
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Areas</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="col-sm-6 text-right">
                    <button type="button" title="Agregar Areas" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      <i class="fa fa-plus"></i> Agregar Area
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
                      <th></th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($areas)) {
                    ?>
                      <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td>
                          <?php echo $f['descrip']; ?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-small btnEditar" title="Editar Area" data-id="<?php echo $f['id']; ?>" data-nombre="<?php echo $f['descrip']; ?>" data-toggle="modal" data-target="#modalEditar">
                            <i class="fa fa-edit"></i>
                          </button>
                          <!--<button class="btn btn-danger btn-small btnEliminar" title="Eliminar Seccion" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i>
                          </button>-->
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>

                </table>
                <div class="pagination">
                  <?php if ($paginaActual > 1) : ?>
                    <a href="?page=<?php echo $paginaActual - 1; ?>" class="btn btn-primary">Anterior</a>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                    <a href="?page=<?php echo $i; ?>" class="btn btn-primary <?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
                  <?php endfor; ?>

                  <?php if ($paginaActual < $totalPaginas) : ?>
                    <a href="?page=<?php echo $paginaActual + 1; ?>" class="btn btn-primary">Siguiente</a>
                  <?php endif; ?>
                </div>

              </div>
            </section>
            <!-- Agregar botones de paginación -->
          </div>


        </div>
        <!-- area -->
        <!-- autor -->
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Autor</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="col-sm-6 text-right">
                    <button type="button" title="Agregar Autor" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
                      <i class="fa fa-plus"></i> Agregar Autor
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
                      <th></th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($autor)) {
                    ?>
                      <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td>
                          <?php echo $f['nom_persona']; ?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-small btnEditar2" title="Editar Autor" data-id2="<?php echo $f['id']; ?>" data-nombre2="<?php echo $f['nom_persona']; ?>" data-toggle="modal" data-target="#modalEditar2">
                            <i class="fa fa-edit"></i>
                          </button>
                          <!--<button class="btn btn-danger btn-small btnEliminar" title="Eliminar Seccion" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i>
                          </button>-->
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>

                </table>
                <div class="pagination">
                  <?php if ($paginaActual > 1) : ?>
                    <a href="?page=<?php echo $paginaActual - 1; ?>" class="btn btn-primary">Anterior</a>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                    <a href="?page=<?php echo $i; ?>" class="btn btn-primary <?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
                  <?php endfor; ?>

                  <?php if ($paginaActual < $totalPaginas) : ?>
                    <a href="?page=<?php echo $paginaActual + 1; ?>" class="btn btn-primary">Siguiente</a>
                  <?php endif; ?>
                </div>

              </div>
            </section>
            <!-- Agregar botones de paginación -->
          </div>


        </div>
        <!-- autor -->
        <!-- ciudad -->
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Ciudad</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="col-sm-6 text-right">
                    <button type="button" title="Agregar Ciudad" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal3">
                      <i class="fa fa-plus"></i> Agregar Ciudad
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
                      <th></th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($ciudad)) {
                    ?>
                      <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td>
                          <?php echo $f['descrip']; ?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-small btnEditar3" title="Editar Ciudad" data-id3="<?php echo $f['id']; ?>" data-nombre3="<?php echo $f['descrip']; ?>" data-toggle="modal" data-target="#modalEditar3">
                            <i class="fa fa-edit"></i>
                          </button>
                          <!-- area<button class="btn btn-danger btn-small btnEliminar" title="Eliminar Seccion" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i>
                          </button>-->
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>

                </table>
                <div class="pagination">
                  <?php if ($paginaActual > 1) : ?>
                    <a href="?page=<?php echo $paginaActual - 1; ?>" class="btn btn-primary">Anterior</a>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                    <a href="?page=<?php echo $i; ?>" class="btn btn-primary <?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
                  <?php endfor; ?>

                  <?php if ($paginaActual < $totalPaginas) : ?>
                    <a href="?page=<?php echo $paginaActual + 1; ?>" class="btn btn-primary">Siguiente</a>
                  <?php endif; ?>
                </div>

              </div>
            </section>
            <!-- Agregar botones de paginación -->
          </div>


        </div>
        <!-- ciudad -->
        <!-- clase -->
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Clase</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="col-sm-6 text-right">
                    <button type="button" title="Agregar Clase" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal4">
                      <i class="fa fa-plus"></i> Agregar Clase
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
                      <th></th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($clase)) {
                    ?>
                      <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td>
                          <?php echo $f['descrip']; ?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-small btnEditar4" title="Editar Clase" data-id4="<?php echo $f['id']; ?>" data-nombre4="<?php echo $f['descrip']; ?>" data-toggle="modal" data-target="#modalEditar4">
                            <i class="fa fa-edit"></i>
                          </button>
                          <!--<button class="btn btn-danger btn-small btnEliminar" title="Eliminar Seccion" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i>
                          </button>-->
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>

                </table>
                <div class="pagination">
                  <?php if ($paginaActual > 1) : ?>
                    <a href="?page=<?php echo $paginaActual - 1; ?>" class="btn btn-primary">Anterior</a>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                    <a href="?page=<?php echo $i; ?>" class="btn btn-primary <?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
                  <?php endfor; ?>

                  <?php if ($paginaActual < $totalPaginas) : ?>
                    <a href="?page=<?php echo $paginaActual + 1; ?>" class="btn btn-primary">Siguiente</a>
                  <?php endif; ?>
                </div>

              </div>
            </section>
            <!-- Agregar botones de paginación -->
          </div>


        </div>
        <!-- clase -->
        <!-- Editorial -->
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Editorial</h6>
            </div>
            <div class="content-wrapper">
              <div class="content-header">
                <div class="container-fluid">
                  <div class="col-sm-6 text-right">
                    <button type="button" title="Agregar Editorial" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal5">
                      <i class="fa fa-plus"></i> Agregar Editorial
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
                      <th></th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                    while ($f = mysqli_fetch_array($editorial)) {
                    ?>
                      <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td>
                          <?php echo $f['descrip']; ?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-small btnEditar5" title="Editar Editorial" data-id5="<?php echo $f['id']; ?>" data-nombre5="<?php echo $f['descrip']; ?>" data-toggle="modal" data-target="#modalEditar5">
                            <i class="fa fa-edit"></i>
                          </button>
                          <!-- area <button class="btn btn-danger btn-small btnEliminar" title="Eliminar Seccion" data-id="<?php echo $f['id']; ?>" data-toggle="modal" data-target="#modalEliminar">
                            <i class="fa fa-trash"></i>
                          </button>-->
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>

                </table>
                <div class="pagination">
                  <?php if ($paginaActual > 1) : ?>
                    <a href="?page=<?php echo $paginaActual - 1; ?>" class="btn btn-primary">Anterior</a>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                    <a href="?page=<?php echo $i; ?>" class="btn btn-primary <?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
                  <?php endfor; ?>

                  <?php if ($paginaActual < $totalPaginas) : ?>
                    <a href="?page=<?php echo $paginaActual + 1; ?>" class="btn btn-primary">Siguiente</a>
                  <?php endif; ?>
                </div>

              </div>
            </section>
            <!-- Agregar botones de paginación -->
          </div>


        </div>
        <!-- editorial -->

        <!-- INSERTAR -->

        <!-- area -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/insertararea.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insertar Area</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" placeholder="nombre" id="nombre" class="form-control" required>
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
        <!-- area -->
        <!-- autor -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/insertarautor.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insertar Autor</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre">Nombre del autor</label>
                    <input type="text" name="nombre" placeholder="nombre" id="nombre" class="form-control" required>
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
        <!-- autor -->
        <!-- ciudad -->
        <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/insertarciudad.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insertar Ciudad</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre">Nombre de la ciudad</label>
                    <input type="text" name="nombre" placeholder="Ciudad" id="nombre" class="form-control" required>
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
        <!-- ciudad -->
        <!-- clase -->
        <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/insertarclase.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insertar Clase</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre">Nombre de la clase</label>
                    <input type="text" name="nombre" placeholder="Clase" id="nombre" class="form-control" required>
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
        <!-- clase -->
        <!-- editorial -->
        <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/insertareditorial.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Insertar Editorial</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre">Nombre de la editorial</label>
                    <input type="text" name="nombre" placeholder="Editorial" id="nombre" class="form-control" required>
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
        <!-- editorial -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel">Eliminar contenido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ¿Desea eliminar este contenido?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger eliminar" data-dismiss="modal">Eliminar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- EDITAR -->
        <!-- area -->
        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/editararea.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditar">Editar Area</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="idEdit" name="id">

                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="nombreEdit" name="nombre" placeholder="nombre de area" id="nombreEdit" class="form-control" required>
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
        <!-- area -->
        <!-- autor -->
        <div class="modal fade" id="modalEditar2" tabindex="-1" role="dialog" aria-labelledby="modalEditar2" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/editarautor.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditar2">Editar Autor</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="idEdit2" name="id">

                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="nombreEdit" name="nombre" placeholder="Nombre del autor" id="nombreEdit2" class="form-control" required>
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
        <!-- autor -->
         <!-- ciudad -->
         <div class="modal fade" id="modalEditar3" tabindex="-1" role="dialog" aria-labelledby="modalEditar3" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/editarciudad.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditar3">Editar Ciudad</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="idEdit3" name="id">

                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="nombreEdit3" name="nombre" placeholder="Nombre del la ciudad" id="nombreEdit3" class="form-control" required>
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
        <!-- ciudad -->
        <!-- clase -->
        <div class="modal fade" id="modalEditar4" tabindex="-1" role="dialog" aria-labelledby="modalEditar4" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/editarclase.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditar4">Editar Clase</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="idEdit4" name="id">

                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="nombreEdit4" name="nombre" placeholder="Nombre de clase" id="nombreEdit4" class="form-control" required>
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
        <!-- clase -->
           <!-- editorial -->
        <div class="modal fade" id="modalEditar5" tabindex="-1" role="dialog" aria-labelledby="modalEditar5" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="./php/editareditorial.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditar5">Editar Editorial</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="idEdit5" name="id">

                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="nombreEdit5" name="nombre" placeholder="Nombre de la editorial" id="nombreEdit5" class="form-control" required>
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
        <!-- editorial -->
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
      var idEliminar2 = -1;
      var idEditar = -1;
      var fila;
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: './php/eliminarseccion.php',
          method: 'POST',
          data: {
            id: idEliminar
          }
        }).done(function(res) {

          $(fila).fadeOut(1000);
        });

      });
            $(".btnEliminar2").click(function() {
        idEliminar2 = $(this).data('id');
        fila = $(this).parent('td').parent('tr');
      });
      $(".eliminar").click(function() {
        $.ajax({
          url: './php/eliminarseccion.php',
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
        $("#nombreEdit").val(nombre);
        $("#idEdit").val(idEditar);
      });
      $(".btnEditar2").click(function() {
        idEditar2 = $(this).data('id2');
        var nombre2 = $(this).data('nombre2');
        $("#nombreEdit2").val(nombre2);
        $("#idEdit2").val(idEditar2);
      });
      $(".btnEditar3").click(function() {
        idEditar3 = $(this).data('id3');
        var nombre3 = $(this).data('nombre3');
        $("#nombreEdit3").val(nombre3);
        $("#idEdit3").val(idEditar3);
      });
      $(".btnEditar4").click(function() {
        idEditar4 = $(this).data('id4');
        var nombre4 = $(this).data('nombre4');
        $("#nombreEdit4").val(nombre4);
        $("#idEdit4").val(idEditar4);
      });
      $(".btnEditar5").click(function() {
        idEditar5 = $(this).data('id5');
        var nombre5 = $(this).data('nombre5');
        $("#nombreEdit5").val(nombre5);
        $("#idEdit5").val(idEditar5);
      });
    });
  </script>

  <!-- Code injected by live-server -->



</body>

</html>