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
  $objeto_asesor = $_SESSION['asesor'];
  $objeto_mueble = $_SESSION['mueble'];
  $objeto_proveer = $_SESSION['proveer'];
  $objeto_proveedor = $_SESSION['proveedor'];
  $objeto_cliente = $_SESSION['cliente'];
  $objeto_tener = $_SESSION['tener'];
  $objeto_venta = $_SESSION['venta'];
  $objeto_estar = $_SESSION['estar'];
  $cliente_comprando = $_SESSION['cliente_comprando'];

  //----Traer vista del historial del cliente
  $id = $cliente_comprando->cliente[0]['id_cliente'];
  $sql = "SELECT * FROM historial_cliente WHERE historial_cliente.id_cliente = $id ";
  $res = pg_query( conexion::conectar(), $sql);
  $historial_cliente = array();

  while($row = pg_fetch_assoc($res)){
    $historial_cliente[] = $row;
  }

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
        <li> <a href="./cliente.php">Inicio</a> </li>
        <li> <a href="./perfil_cliente.php">Perfil</a> </li>
        <li> <a href="#">Historial</a> </li>
        <li> <a href="../PHP/cerrar_sesion.php"> <button type="button" name="button">Salir</button> </a> </li>
      </ul>

      </nav>
    </div>
    </header>

<form class="" action="../PHP/operaciones.php" method="post">

<section class="form_productos">

<?php //------------------------------------------------------cabecera----------------------------------------------------?>
<header>
<h1>Informacion del Cliente</h1>

</header>


<table class="tabla_producto" border="1px">

  <td colspan="1" rowspan="1" > NUMERO </td>
  <td colspan="1" rowspan="1" > IDENTIFICACION </td>
  <td colspan="1" rowspan="1" > NOMBRE </td>
  <td colspan="1" rowspan="1" > NUMERO DE LA VENTA </td>
  <td colspan="1" rowspan="1" > ASESOR </td>
  <td colspan="1" rowspan="1" > FECHA </td>
  <td colspan="1" rowspan="1" > VALOR </td>
  <td colspan="1" rowspan="1" > ID MUEBLE </td>
  <td colspan="1" rowspan="1" > CANTIDAD </td>


  <?php for($i = 0; $i < count($historial_cliente) ; $i++) { ?>
  <tr>
    <td colspan="1" rowspan="1" > <?php echo $i; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['id_cliente']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['nombre']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['id_venta']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['id_asesor']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['fecha']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['valor']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['id_tipo']; ?> </td>
    <td colspan="1" rowspan="1" > <?php echo $historial_cliente[$i]['cantidad']; ?> </td>
  </tr>
  <?php } ?>

</table>

</section>

</form>

  </body>
</html>

<?php
}
?>
