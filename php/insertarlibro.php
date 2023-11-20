
<?php 
include "./conexion.php";

if(isset($_POST['coddew']) && isset($_POST['titulo'])&& isset($_POST['id_autor'])
&& isset($_POST['edicion'])&& isset($_POST['costo'])&& isset($_POST['fecha'])&& isset($_POST['id_estado'])
&& isset($_POST['id_origen'])&& isset($_POST['id_editorial'])&& isset($_POST['id_area'])
&& isset($_POST['id_clase'])&& isset($_POST['observaciones'])&& isset($_POST['id_seccion'])
&& isset($_POST['temas'])&& isset($_POST['id_ciudad'])&& isset($_POST['codinv'])
&& isset($_POST['npag'])&& isset($_POST['fimpresion'])&& isset($_POST['temas2'])&& isset($_POST['entrainv'])) {
    $existe = 'si';
    $conexion->query("INSERT INTO libros 
        (coddew,titulo,existe,id_autor,edicion,costo,fecha,id_estado,id_origen,id_editorial,id_area,id_clase,observaciones,id_seccion,temas,id_ciudad,codinv,npag,fimpresion,temas2,entrainv) VALUES
        (
            '".$_POST['coddew']."',
            '".$_POST['titulo']."',
            '$existe',
            '".$_POST['id_autor']."',
            '".$_POST['edicion']."',
            '".$_POST['costo']."',
            '".$_POST['fecha']."',
            '".$_POST['id_estado']."',
            '".$_POST['id_origen']."',
            '".$_POST['id_editorial']."',
            '".$_POST['id_area']."',
            '".$_POST['id_clase']."',
            '".$_POST['observaciones']."',
            '".$_POST['id_seccion']."',
            '".$_POST['temas']."',
            '".$_POST['id_ciudad']."',
            '".$_POST['codinv']."',
            '".$_POST['npag']."',
            '".$_POST['fimpresion']."',
            '".$_POST['temas2']."',
            '".$_POST['entrainv']."'
        )") or die($conexion->error);
    
    header("Location: ../panellibros.php?success");
} else {
    header("Location: ../panellibros.php?error=Favor de llenar todos los campos");
}
?>
