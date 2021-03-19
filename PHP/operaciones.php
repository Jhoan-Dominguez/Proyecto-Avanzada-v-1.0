<?php
include('../CLASES/Clases.php');
session_start();

if($_SESSION == null){
  echo "No hay una sesion iniciada";
}
else{

  $objeto_asesor = $_SESSION['asesor'];
  $objeto_sucursal = $_SESSION['sucursal'];
  $objeto_mueble = $_SESSION['mueble'];
  $cliente_comprando = $_SESSION['cliente_comprando'];
  $objeto_tener = $_SESSION['tener'];

  //id del mueble que se añadio
  $id_tipo = $_GET["idtipo"];

  for($i=0; $i < count($objeto_mueble->mueble); $i++)
  {
    if( $objeto_mueble->mueble[$i]['id_tipo'] == $id_tipo){
        echo "lo encontro :3";
        $cliente_comprando =  $cliente_comprando->mueble($cliente_comprando, $objeto_mueble->mueble[$i]);
        $i =  count($cliente_comprando->tener);
    }
  }

  $aux = 0;
  $i=0;
  while( $cliente_comprando->mueble[$i] ){
    $aux+= $cliente_comprando->mueble[$i]['precio'];
    ++$i;
  }

  $cliente_comprando->valor_pagar = $aux;

  $_SESSION['cliente_comprando'] = $cliente_comprando;
     header('Location: ../PAGINAS/cliente.php');
}

?>
