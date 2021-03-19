<?php

    include('../CLASES/Clases.php');
    session_start();

    //capturar datos del formulario
    $usuario = $_REQUEST['usuario'];
    $contraseña = $_REQUEST['password'];

    //recuperar y actualizar informacion de la sucursal

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
          //buscar la info ingresada en la DB
          $sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario' AND contrasena = '$contraseña' ";
          $res2 = pg_query(conexion::conectar(), $sql);
          $aux = pg_fetch_assoc($res2);
          $nom = $aux['nombre_usuario'];
          $aux1 = $aux['tipo'];


if($res2 != null){

      $mover="";
      if($aux1 == 'cliente'){
          $sql = "SELECT * FROM cliente WHERE cliente_nombre_usuario = '$nom' ";
          $mover = "Location: ../PAGINAS/cliente.php";
      }

      if($aux1 == 'asesor'){
          $sql = "SELECT * FROM asesor WHERE asesor_nombre_usuario = '$nom' ";
          $mover = "Location: ../PAGINAS/asesor.php";
      }

      if($aux1 == 'sucursal'){
          $sql = "SELECT * FROM sucursal WHERE sucursal_nombre_usuario = '$nom' ";
          $mover = "Location: ../PAGINAS/sucursal.php";
      }

      if($aux1 == 'proveedor'){
          $sql = "SELECT * FROM proveedor WHERE proveedor_nombre_usuario = '$nom' ";
          $mover = "Location: ../PAGINAS/proveedor.php";
      }

      //traer los datos correspondientes de el usuario que sea
      $res3 = pg_query(conexion::conectar(), $sql);
      $login = pg_fetch_assoc($res3);

//----------------------------------------------------------CREAR OBJETOS-------
      $objeto_sucursal=new sucursal();
      $objeto_sucursal=$objeto_sucursal->agregar_sucursal();

      $objeto_asesor=new asesor();
      $objeto_asesor=$objeto_asesor->agregar_asesor();

      $objeto_mueble=new mueble();
      $objeto_mueble=$objeto_mueble->agregar_mueble($objeto_mueble);

      $objeto_proveer=new proveer();
      $objeto_proveer=$objeto_proveer->agregar_proveer($objeto_proveer);

      $objeto_proveedor=new proveedor();
      $objeto_proveedor=$objeto_proveedor->agregar_proveedor($objeto_proveedor);

      $objeto_cliente=new cliente();
      $objeto_cliente=$objeto_cliente->agregar_cliente($objeto_cliente);

      $objeto_tener=new tener();
      $objeto_tener=$objeto_tener->agregar_tener($objeto_tener);

      $objeto_venta=new venta();
      $objeto_venta=$objeto_venta->agregar_venta($objeto_venta);

      $objeto_estar=new estar();
      $objeto_estar=$objeto_estar->agregar_estar($objeto_estar);
//------------------------------------------------------------------------------

      if($aux1 == 'cliente'){

            if  (!$_SESSION || !$_SESSION['seleccion'])  {

              $cliente_comprando = new cliente_comprando();
              $cliente_comprando = $cliente_comprando->cliente($cliente_comprando, $login);
              $cliente_comprando->valor_pagar = 0;

              //seleccionar asesores
              $salir = true;
              $asesor = 0;

                  while($salir){
                      $asesor = rand (0, 14);
                          if($objeto_asesor->asesor[$asesor]['nombre_sucursal']  == 'Prontomueble Sucursal AV.68')
                              $salir=false;
                  }

              $cliente_comprando = $cliente_comprando->asesor($cliente_comprando, $objeto_asesor->asesor[$asesor]);

                //cargar la Sucursal

              for($i = 0; $i < $objeto_sucursal->nsucursal ; $i++) {
                    if($objeto_sucursal->sucursal[$i]['nombre'] == 'Prontomueble Sucursal AV.68')
                        $cliente_comprando = $cliente_comprando->sucursal($cliente_comprando, $objeto_sucursal->sucursal[$i]);
              }

              //muebles que estan en la Sucursa

              for($i = 0; $i < $objeto_tener->ntener; $i++) {
                    if($objeto_tener->tener[$i]['nombre_sucursal'] ==  $cliente_comprando->sucursal[0]['nombre']){
                          $cliente_comprando->tener[] = $objeto_tener->tener[$i];
                    }
              }
                   //pasar el objeto por la sesion
                   $_SESSION['cliente_comprando'] = $cliente_comprando;

                   $_SESSION['sucursal'] = $objeto_sucursal;
                   $_SESSION['asesor'] = $objeto_asesor;
                   $_SESSION['mueble'] = $objeto_mueble;
                   $_SESSION['proveer'] = $objeto_proveer;
                   $_SESSION['proveedor'] = $objeto_proveedor;
                   $_SESSION['cliente'] = $objeto_cliente;
                   $_SESSION['tener'] = $objeto_tener;
                   $_SESSION['venta'] = $objeto_venta;
                   $_SESSION['estar'] = $objeto_estar;
                   $_SESSION['tipo'] = $aux1;

                   //mover a la pagina
                   header($mover);
          }
      else{

            $aux1 = $_SESSION['tipo'];
            $seleccion = $_SESSION['seleccion'];

            $cliente_comprando = $_SESSION['cliente_comprando'];
            $objeto_asesor = $_SESSION['asesor'];
            $objeto_sucursal = $_SESSION['sucursal'];
            $objeto_tener = $_SESSION['tener'];

            //seleccionar asesores
            $salir = true;
            $asesor = 0;

            $seleccion = $_SESSION['seleccion'];

              while($salir){
                  $asesor = rand (0, 14);
                      if($objeto_asesor->asesor[$asesor]['nombre_sucursal']  == $seleccion)
                      $salir=false;
              }

            $cliente_comprando = $cliente_comprando->asesor($cliente_comprando, $objeto_asesor->asesor[$asesor]);

            //cargar la Sucursal
            for($i = 0; $i < $objeto_sucursal->nsucursal ; $i++) {
                if($objeto_sucursal->sucursal[$i]['nombre'] == $seleccion)
                    $cliente_comprando = $cliente_comprando->sucursal($cliente_comprando, $objeto_sucursal->sucursal[$i]);
            }

            //muebles que estan en la Sucursal

            $cliente_comprando = $cliente_comprando->eliminar_tener( $cliente_comprando );
            $l = 0;
            for($i = 0; $i < $objeto_tener->ntener; $i++) {
                echo $objeto_tener->tener[$i]['nombre_sucursal']." === ".$cliente_comprando->sucursal[0]['nombre'];
                    if($objeto_tener->tener[$i]['nombre_sucursal'] ==  $cliente_comprando->sucursal[0]['nombre']){
                          $cliente_comprando->tener[$l] = $objeto_tener->tener[$i];
                          ++$l;
                    }
            }

            $_SESSION['cliente_comprando'] = $cliente_comprando;

            header($mover);
      }

    }
    else{

        if($aux1 == 'sucursal'){


              for( $i=0; $i < count($objeto_sucursal->sucursal); $i++ ){
                if($objeto_sucursal->sucursal[$i]['nombre'] == $login['nombre'] ){
                    $login = $objeto_sucursal->sucursal[$i];
                    $i = count($objeto_sucursal->sucursal);
                  }
              }

              $objeto_sucursal1 = new sucursal();
              $objeto_sucursal1->sucursal = $login;


              $_SESSION['sucursal'] = $objeto_sucursal;
              $_SESSION['sucursal_actual'] = $objeto_sucursal1;
              $_SESSION['asesor'] = $objeto_asesor;
              $_SESSION['mueble'] = $objeto_mueble;
              $_SESSION['proveer'] = $objeto_proveer;
              $_SESSION['proveedor'] = $objeto_proveedor;
              $_SESSION['cliente'] = $objeto_cliente;
              $_SESSION['tener'] = $objeto_tener;
              $_SESSION['venta'] = $objeto_venta;
              $_SESSION['estar'] = $objeto_estar;
              $_SESSION['tipo'] = $aux1;

            header($mover);

            }
        else {

              if($aux1 == 'asesor'){

              }
              else{

                  if($aux1 == 'proveedor'){

                  }

              }

        }

}

}
else{
  echo "Usuario no encontrado, ingrese nuevamente los datos";
}


 ?>
