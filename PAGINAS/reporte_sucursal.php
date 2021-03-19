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

//---------------variables de inico
  $sucursal_actual = $_SESSION['sucursal_actual'];
  $objeto_asesor = $_SESSION['asesor'];
  $objeto_mueble = $_SESSION['mueble'];
  $objeto_proveer = $_SESSION['proveer'];
  $objeto_proveedor = $_SESSION['proveedor'];
  $objeto_tener = $_SESSION['tener'];
  $objeto_venta = $_SESSION['venta'];
  $objeto_estar = $_SESSION['estar'];
//-----------------nuevos objetos

//----asesor que mas vendio
$fecha_2 = "03-01-2021";
$total_venta=array();

$sql = "SELECT * FROM venta WHERE fecha = '$fecha_2' ORDER BY id_asesor";
$res = pg_query(conexion::conectar(), $sql);
$row2 = array();

while ( $row = pg_fetch_assoc($res)){
  $row2[] = $row;
}

$j = 0;
$k = 0;
for ( $i = 0; $i < count($row2) -1 ; $i++){
  $total_venta[$j] = $row2[$i];
  $k += $row2[$i]['valor'];
  $total_venta[$j]['valor'] = $k;

  if( $total_venta[$j]['id_asesor'] != $row2[$i+1]['id_asesor'] )
      ++$j;
}

$asesor_mas_ventas = array();
for ($i = 0; $i < count($total_venta)-1; $i++){
  if($total_venta[$i]['valor'] < $total_venta[$i+1]['valor'])
        $asesor_mas_ventas[0]=$total_venta[$i];
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
<h1>Reporte Sucursal</h1>

</header>


<table class="tabla_producto" border="1px">

  <tr>
    <td rowspan="4">Asesor con mas Ventas: </td>
  </tr>
  <tr>
    <td colspan="1" rowspan="1" > CODIGO: <?php  echo $asesor_mas_ventas[0]['id_asesor'] ; ?> </td>
  </tr>
  <tr>
    <td colspan="1" rowspan="1" > FECHA: <?php  echo $asesor_mas_ventas[0]['fecha'] ; ?> </td>
  </tr>
  <tr>
    <td colspan="1" rowspan="1" > VALOR VENTAS: <?php  echo $asesor_mas_ventas[0]['valor'] ; ?> </td>
  </tr>



  <tr>
    <td>Asesor con mas Ventas: </td>
    <td colspan="1" rowspan="1" > <?php  echo $asesor_mas_ventas[0]['id_asesor'] ; ?> </td>
  </tr>


</table>

</section>

</form>

  </body>
</html>

<?php
}
?>
