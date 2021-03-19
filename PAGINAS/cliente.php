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
        <li> <a href="#">Inicio</a> </li>
        <li> <a href="./perfil_cliente.php">Perfil</a> </li>
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

Sucursal: <select class="" id="sucursal" name="sucursal" onchange="actualizar()">
  <option value=""> ------ </option>
<?php for($i = 0; $i < $objeto_sucursal->nsucursal; $i++ ) { ?>
  <option> <?php echo $objeto_sucursal->sucursal[$i]['nombre'] ?> </option>
<?php } ?>

</select>
<h1>Valor: <?php echo $cliente_comprando->valor_pagar." $"; ?></h1>

<button type="button" name="button" onclick="finalizar_compra()">FINALIZAR COMPRA</button> <br>

</header>
<?php //-------------------------------------------------------------------------------------------------------------------?>
<?php //-----------------------------------------------imagen de los muebles-----------------------------------------------?>

<table class="tabla_productos" >
<?php
$i = 0;
$l = 0;
while ( $i < count($objeto_mueble->mueble) - 1 && $objeto_mueble->mueble[$i]['imagen'] ) {
?>

  <tr>
<?php
for ($j = 0; $j < 4 ; $j++) {
  if(  $l < count($cliente_comprando->tener) - 1 && $objeto_mueble->mueble[$i]['id_tipo'] == $cliente_comprando->tener[$l]['id_tipo']  ) { ?>
    <?php ++$l;
?>
<td>
        <section class="campo_imagenes"  >
         <img id="imagen<?php echo $objeto_mueble->mueble[$i]['id_tipo']; ?>" style="display:block"
         src="<?php echo $objeto_mueble->mueble[$i]['imagen']; ?>" height="300" width="300"></img>
          <?php //division de los detalles ?>
          <section class="modal"  style="display:none" id = "modal<?php echo $objeto_mueble->mueble[$i]['id_tipo']; ?>">
            <div class="contenedor-modal">
              <header> DETALLES </header>
              <div class="contenido">
                <?php //contenido que se vaya a poner ?>

              </div>
              <table>
                <tr>
                  <td colspan="3" align="center" >ID:</td>
                  <td colspan="4" align="center" ><?php echo $objeto_mueble->mueble[$i]['id_tipo']; ?></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" >PROVEEDOR:</td>
                  <td colspan="4" align="center" ><?php echo $objeto_mueble->mueble[$i]['id_proveedor']; ?></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" >CATEGORIA:</td>
                  <td colspan="4" align="center" ><?php echo $objeto_mueble->mueble[$i]['categoria']; ?> </td>
                </tr>
                <tr>
                  <td colspan="3" align="center" >MATERIAL:</td>
                  <td colspan="4" align="center" ><?php echo $objeto_mueble->mueble[$i]['material']; ?> </td>
                </tr>
                <tr>
                  <td colspan="3" align="center" >COLOR:</td>
                  <td colspan="4" align="center" ><?php echo $objeto_mueble->mueble[$i]['color']; ?></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" >PRECIO:</td>
                  <td colspan="4" align="center" ><?php echo $objeto_mueble->mueble[$i]['precio']; ?></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" >DIMENCIONES (A, H, P):</td>
                  <td colspan="4" align="center" > <?php echo $objeto_mueble->mueble[$i]['ancho']."x".$objeto_mueble->mueble[$i]['alto'].
                  "x".$objeto_mueble->mueble[$i]['profundo']; ?> </td>
                </tr>
              </table>
              </div>
          </section>

        </section>
        <section>
          <button type="button" name=""  id ="<?php echo $objeto_mueble->mueble[$i]['id_tipo']; ?>"     onclick="mostrar_detalles(this)" >Ver Detalles</button>
          <button type="button" name=""  id = "<?php echo $objeto_mueble->mueble[$i]['id_tipo']; ?>"    onclick="añadir_muebles(this)" >Añadir</button>
          <?php //division de añadir  ?>

        </section>
</td>


<?php }
else{
  --$j;
}
if($i < $objeto_mueble->nmueble - 1) {
  ++$i; }
else{
  $j = 4;
  }
} ?><tr><?php } ?>

</table>
</section>

</form>
<?php //-----------------------------------------------------------------------------------------------------------------?>
<?php //-----------------------------------------------imagen del vendedor-----------------------------------------------?>
<section class="vendedor">

  <img src= "<?php echo $cliente_comprando->asesor[0]['imagen']; ?>" height="250" width="200"></img>
  <p> Bienvenido </p>

</section>

  </body>
</html>

<?php
}
?>
