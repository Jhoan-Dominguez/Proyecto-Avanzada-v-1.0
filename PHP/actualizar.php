<?php
include('../CLASES/Clases.php');
session_start();

if($_SESSION == null){
  echo "No hay una sesion iniciada";
}
else{

  $objeto_asesor = $_SESSION['asesor'];
  $objeto_sucursal = $_SESSION['sucursal'];
  $cliente_comprando = $_SESSION['cliente_comprando'];
  $objeto_tener = $_SESSION['tener'];

  $seleccion1 = $_GET["seleccion1"];
  $_SESSION['seleccion'] = $seleccion1;

   //seleccionar asesores
   $salir = true;
   $asesor = 0;
   while($salir){
       $asesor = rand (0, 14);
       if($objeto_asesor->asesor[$asesor]['nombre_sucursal']  == $seleccion1)
         $salir=false;
   }
     $cliente_comprando = $cliente_comprando->asesor($cliente_comprando, $objeto_asesor->asesor[$asesor]);

   //cargar la Sucursal
   for($i = 0; $i < $objeto_sucursal->nsucursal ; $i++) {
     if($objeto_sucursal->sucursal[$i]['nombre'] == $seleccion1)
         $cliente_comprando = $cliente_comprando->sucursal($cliente_comprando, $objeto_sucursal->sucursal[$i]);
   }

   //muebles que estan en la Sucursal
   $l = 0;
   for( $i = 0; $i < $objeto_tener->ntener; $i++) {
     if($objeto_tener->tener[$i]['nombre_sucursal'] ==  $cliente_comprando->sucursal[0]['nombre']){
           $cliente_comprando->tener[$l] = $objeto_tener->tener[$i];
           ++$l;
         }
   }
   $x = count($cliente_comprando->mueble);
   for( $i = 0; $i < $x; $i++) {
        unset($cliente_comprando->mueble[$i]);
   }

   $cliente_comprando->valor_pagar = 0;

   $_SESSION['cliente_comprando'] = $cliente_comprando;
   header('Location: ../PAGINAS/cliente.php');
 }

 ?>
