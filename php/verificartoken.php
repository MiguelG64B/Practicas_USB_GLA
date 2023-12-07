<?php
include "conexion.php";
$email = $_POST['email'];
$token = $_POST['token'];
$codigo = $_POST['codigo'];
$res = $conexion->query("select * from passwords where 
        email='$email' and token='$token' and codigo=$codigo") or die($conexion->error);
$correcto = false;
if (mysqli_num_rows($res) > 0) {
  $fila = mysqli_fetch_row($res);
  $fecha = $fila[4];
  $fecha_actual = date("Y-m-d h:m:s");
  $seconds = strtotime($fecha_actual) - strtotime($fecha);
  $minutos = $seconds / 60;
  /* if($minutos > 10 ){
            echo "token vencido";
        }else{
            echo "todo correcto";
        }*/
  $correcto = true;
} else {

  $correcto = false;
  $mensaje_error = "Código incorrecto o expirado";
  header("Location: ../reset.php?email=$email&token=$token&error=$mensaje_error");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Proyecto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">

  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://gimnasiolosalmendros.edu.co/wp-content/uploads/2023/06/IMG_0653-scaled.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Recuperar contraseña</h1>
            <p class="text-lead text-white"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Cambiar contraseña</h5>
            </div>
            <div class="card-body">
            <?php if ($correcto) { ?>
    <form role="form" class="needs-validation" method="post" action="cambiarpassword.php" onsubmit="return validarContraseñas()">
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Repite la nueva contraseña" name="p1" aria-label="password" required>
            <div class="valid-feedback">Ya es válido</div>
            <div class="invalid-feedback">Complete los campos</div>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Confirmar nueva contraseña" name="p2" aria-label="password" required>
            <div class="valid-feedback">Ya es válido</div>
            <div class="invalid-feedback">Complete los campos</div>
        </div>
        <input type="hidden" class="form-control" id="c" name="email" value="<?php echo $email ?>">
        <input type="hidden" class="form-control" id="c" name="token" value="<?php echo $token ?>">
        <input type="hidden" class="form-control" id="c" name="codigo" value="<?php echo $codigo ?>">
        <div class="text-center">
            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Cambiar contraseña</button>
        </div>
        <p class="text-sm mt-3 mb-0">Ya tienes una cuenta ? <a href="../login.php" class="text-dark font-weight-bolder">Iniciar sesión</a></p>
    </form>
    <script>
        function validarContraseñas() {
            var p1 = document.getElementsByName("p1")[0].value;
            var p2 = document.getElementsByName("p2")[0].value;

            if (p1 !== p2) {
                alert("Las contraseñas no coinciden");
                return false; // Evita que el formulario se envíe
            }

            return true; // Permite que el formulario se envíe
        }
    </script>
<?php } else { ?>
    <div class="alert alert-danger">Código incorrecto o vencido, vuelve a ingresar al enlace de tu correo</div>
<?php } ?>

        <?php
        if (isset($_GET['todobien'])) {
          echo '<div class="col-12 alert alert-success">' . $_GET['todobien'] . '</div>';
        }
        ?>
        <?php
        if (isset($_GET['error'])) {
          echo '<div class="col-12 alert alert-danger">' . $_GET['error'] . '</div>';
        }
        ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>