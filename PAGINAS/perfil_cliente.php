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
        <li> <a href="#">Perfil</a> </li>
        <li> <a href="./historial_cliente.php">Historial</a> </li>
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

  <tr>
    <td colspan="1" rowspan="1" > Identificacion:   </td>
    <td colspan="1" rowspan="1" > <?php echo $cliente_comprando->cliente[0]['id_cliente']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Nombre:           </td>
    <td colspan="1" rowspan="1" > <?php echo $cliente_comprando->cliente[0]['nombre']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Direccion:         </td>
    <td colspan="1" rowspan="1" > <?php echo $cliente_comprando->cliente[0]['direccion']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Correo:            </td>
    <td colspan="1" rowspan="1" > <?php echo $cliente_comprando->cliente[0]['correo']; ?> </td>
  </tr>

  <tr>
    <td colspan="1" rowspan="1" > Nombre de Usuario: </td>
    <td colspan="1" rowspan="1" > <?php echo $cliente_comprando->cliente[0]['cliente_nombre_usuario']; ?> </td>
  </tr>


</table>

</section>

</form>

  </body>
</html>

<?php
}
?>
