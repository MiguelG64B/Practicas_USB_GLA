<?php
include "./conexion.php";

if(isset($_POST['coddew']) && isset($_POST['titulo'])&& isset($_POST['id_autor'])
&& isset($_POST['edicion'])&& isset($_POST['costo'])&& isset($_POST['fecha'])&& isset($_POST['id_estado'])
&& isset($_POST['id_origen'])&& isset($_POST['id_editorial'])&& isset($_POST['id_area'])
&& isset($_POST['id_clase'])&& isset($_POST['observaciones'])&& isset($_POST['id_seccion'])
&& isset($_POST['temas'])&& isset($_POST['id_ciudad'])&& isset($_POST['codinv'])
&& isset($_POST['npag'])&& isset($_POST['fimpresion'])&& isset($_POST['temas2'])&& isset($_POST['entrainv'])&& isset($_POST['id_libro'])) {
    $id_libro = $_POST['id_libro'];
    $existe = 'si';
    $conexion->query("UPDATE libros SET
        coddew = '" .$_POST['coddew']. "',
        titulo = '" . $_POST['titulo'] . "',
        existe = '$existe',
        id_autor = '" . $_POST['id_autor'] . "',
        edicion = '" . $_POST['edicion'] . "',
        costo = '" . $_POST['costo'] . "',
        fecha = '" . $_POST['fecha'] . "',
        id_estado = '" . $_POST['id_estado'] . "',
        id_origen = '" . $_POST['id_origen'] . "',
        id_editorial = '" . $_POST['id_editorial'] . "',
        id_area = '" . $_POST['id_area'] . "',
        id_clase = '" . $_POST['id_clase'] . "',
        observaciones = '" . $_POST['observaciones'] . "',
        id_seccion = '" . $_POST['id_seccion'] . "',
        temas = '" . $_POST['temas'] . "',
        id_ciudad = '" . $_POST['id_ciudad'] . "',
        codinv = '" . $_POST['codinv'] . "',
        npag = '" . $_POST['npag'] . "',
        fimpresion = '" . $_POST['fimpresion'] . "',
        temas2 = '" . $_POST['temas2'] . "',
        entrainv = '" . $_POST['entrainv'] . "'
        WHERE id_libro='$id_libro'"
    ) or die($conexion->error);

    header("Location: ../panellibros.php?success");
} else {
    header("Location: ../panellibros.php?error=Favor de llenar todos los campos");
}
?>
