<?php
include('../CLASES/Clases.php');
session_start();

if (!$_SESSION){
  echo "no hay una sesion iniciada";
}
else {


    if(!$_COOKIE || !$_COOKIE['fecha'] || !$_COOKIE['numero_venta']){
      $fecha = date("d-m-Y");
      $numero_venta = 29;
      setcookie ("fecha", $fecha, time()+86400);
      setcookie ("numero_venta", $numero_venta, time()+86400);
    }else{
      $fecha = $_COOKIE['fecha'];
      $numero_venta = $_COOKIE['numero_venta'];
      setcookie ("fecha", $fecha, time()+86400);
    }

    echo $_COOKIE['fecha'];
    echo $_COOKIE['numero_venta'];


  $objeto_sucursal = $_SESSION['sucursal'];
  $sucursal_actual = $_SESSION['sucursal_actual'];
  $objeto_asesor = $_SESSION['asesor'];
  $objeto_mueble = $_SESSION['mueble'];
  $objeto_proveer = $_SESSION['proveer'];
  $objeto_proveedor = $_SESSION['proveedor'];
  $objeto_tener = $_SESSION['tener'];
  $objeto_venta = $_SESSION['venta'];
  $objeto_estar = $_SESSION['estar'];

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Menu de Navegacion</title>
      <link rel="stylesheet" href="../CSS/pagina_DBA.css">
      <script type="text/javascript" src="../JS/cliente.js"></script>
  </head>
  <body>

    <header class = "cabecera">
      <div class="contenedor">
      <nav class = "navigation">

      <ul>
        <li> <a href="./sucursal.php">Inicio</a> </li>
        <li> <a href="./reporte_sucursal.php">Mirar Reporte</a> </li>
        <li> <a href="../PHP/cerrar_sesion.php"> <button type="button" name="button">Salir</button> </a> </li>
      </ul>

      </nav>
    </div>
    </header>

<form class="" action="" method="post">

<section class="form_productos">

<?php //------------------------------------------------------cabecera----------------------------------------------------?>
<header>
<h1>Informacion Sucursal</h1>
<?php echo var_dump($sucursal_actual->sucursal ); ?>

</header>


<table class="tabla_producto" border="1px">

  <tr>
    <td colspan="2" rowspan="1" > <?php  echo "Informacion Sucursal"; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Nombre:           </td>
    <td colspan="1" rowspan="1" > <?php echo $sucursal_actual->sucursal['nombre']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Direccion:           </td>
    <td colspan="1" rowspan="1" > <?php echo $sucursal_actual->sucursal['direccion']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Telefono:           </td>
    <td colspan="1" rowspan="1" > <?php echo $sucursal_actual->sucursal['telefono']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Nombre de Usuario:           </td>
    <td colspan="1" rowspan="1" > <?php echo $sucursal_actual->sucursal['sucursal_nombre_usuario']; ?> </td>
  </tr>

  <tr>
    <td colspan="2" rowspan="4" >  <img src= "<?php echo $sucursal_actual->sucursal['imagen']; ?> " alt="" height="300" width="300"> </td>
  </tr>

</table>

</section>

</form>

  </body>
</html>

<?php
}
?>
