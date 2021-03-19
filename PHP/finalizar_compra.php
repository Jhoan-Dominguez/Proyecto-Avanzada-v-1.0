<?php
include('../CLASES/Clases.php');
session_start();

if (!$_SESSION){
  echo "no hay una sesion iniciada";
}
else {
  $cliente_comprando = $_SESSION['cliente_comprando'];
  $objeto_estar = $_SESSION['estar'];

  //actualizar la tabla venta con los datos correspondientes
  $numero_venta = $_COOKIE['numero_venta'];
  $id_cliente = $cliente_comprando->cliente[0]['id_cliente'];
  $codigo_asesor = $cliente_comprando->asesor[0]['codigo'];
  $fecha = $_COOKIE['fecha'];
  $sucursal = $cliente_comprando->sucursal[0]['nombre'];
  $id_estar = $objeto_estar->nestar + 1;

  echo var_dump($cliente_comprando->mueble);

  $sql = "INSERT INTO venta VALUES ($numero_venta, $id_cliente, $codigo_asesor,
            '$fecha', '$cliente_comprando->valor_pagar')";
  $res = pg_query(conexion::conectar(), $sql);

  //actualizar la tabla estar
  $i = 0;

$mueblesss = $cliente_comprando->mueble;

$x1 = count($mueblesss);
$x = count($cliente_comprando->mueble);


  while ( $i < $x)  {
      $cant = 0;
      $id_tipo = $cliente_comprando->mueble[$i]['id_tipo'];
      $j = 0;
    while ( $j < $x1 ){
      if( !is_null( $mueblesss[$j]['id_tipo'] ) ){
          echo "antes = ".$cliente_comprando->mueble[$i]['id_tipo']."==".$mueblesss[$j]['id_tipo']."<br>";
          if ( $cliente_comprando->mueble[$i]['id_tipo'] == $mueblesss[$j]['id_tipo'] ){
            echo $cliente_comprando->mueble[$i]['id_tipo']."==".$mueblesss[$j]['id_tipo']."<br>";
            $mueblesss[$j]['id_tipo'] = 0;
            ++$cant;
          }
        }
          ++$j;
    }
    echo "nose";

if($cant != 0){
      //actualizar la tabla estar
    $sql = "INSERT INTO estar VALUES ($id_estar, $numero_venta, '$fecha',
      $cant, $id_cliente, $id_tipo)";
    $res = pg_query(conexion::conectar(), $sql);

      //actualizar tabla tener
    $sql = "UPDATE tener SET inventario_cantidad = ( inventario_cantidad - $cant)
            WHERE id_tipo = $id_tipo AND nombre_sucursal IN
            (SELECT nombre FROM sucursal WHERE nombre = '$sucursal')";

    $res1 = pg_query(conexion::conectar(), $sql);
}

    unset($cliente_comprando->mueble[$i]);
    echo $i;
    ++$i;
    echo $i;

    ++$id_estar;
  }


  $cliente_comprando->valor_pagar = 0;

  $objeto_estar->nestar = $id_estar;
  $_SESSION['estar'] = $objeto_estar;
  $_SESSION['cliente_comprando'] = $cliente_comprando;
  ++$numero_venta;

  setcookie ("numero_venta", $numero_venta, time()+86400);
  echo "nice";
  header('Location: ../PAGINAS/cliente.php');
}
