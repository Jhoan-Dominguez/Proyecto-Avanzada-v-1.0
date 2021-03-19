<?php
class conexion {

public static function conectar(){
      $conec = pg_connect( "host='localhost' dbname=muebles port=5432 user=postgres password=admin " )
      or die ("error de conexion".pg_last_error());

      return $conec;
    }
}

//se realizaran las compras
class cliente_comprando {
  public $cliente;
  public $sucursal;
  public $tener;
  public $asesor;
  public $mueble;
  public $valor_pagar;

  public function __construct(){
    $this->cliente = array();
    $this->sucursal = array();
    $this->tener = array();
    $this->asesor = array();
    $this->mueble = array();
  }
                          //cliente que ini.   datos de el
  public function cliente($cliente_comprando, $cliente){
    $cliente_comprando->cliente[0] = $cliente;
    return $cliente_comprando;
  }
                          //cliente que ini.   datos de la sucursal
  public function sucursal($cliente_comprando, $sucursal){
    $cliente_comprando->sucursal[0] = $sucursal;
    return $cliente_comprando;
  }

  public function eliminar_tener($cliente_comprando){
    $j=count($cliente_comprando->tener);
        for ($i=0; $i < $j ; $i++) {
            unset($cliente_comprando->tener[$i]);
            }
            return $cliente_comprando;
  }

  public function cambio_sucursal($cliente_comprando){

    $j=count($cliente_comprando->mueble);
        for ($i=0; $i < $j ; $i++) {
            unset($cliente_comprando->mueble[$i]);
            }
        $cliente_comprando->valor_pagar = 0;

        return $cliente_comprando;
  }

  public function tener($cliente_comprando, $tener_x){
    $cliente_comprando->tener = $tener_x;
  }

                          //cliente que ini.   datos de el asesor
  public function asesor($cliente_comprando, $asesor){
    $cliente_comprando->asesor[0] = $asesor;
    return $cliente_comprando;
  }
                          //cliente que ini.   datos de el mueble añadido
  public function mueble($cliente_comprando, $mueble){
    $cliente_comprando->mueble[] = $mueble;
    return $cliente_comprando;
  }
                          //cliente que ini.   datos del valor
  public function valor_pagar($cliente_comprando, $valor_pagar){
    $cliente_comprando->valor_pagar = $cliente_comprando->valor_pagar + $valor_pagar;
    return $cliente_comprando;
  }

  public function mostrar_imagenes ($cliente_comprando, $objeto_mueble){
    $bool = 0;
        for($i = 0; $i < count($cliente_comprando->tener) -1 ; $i++){
            for($j = 0; $j < count($objeto_mueble->mueble) - 1 ; $j++) {
                if( $objeto_mueble->mueble[$j]['id_tipo'] == $cliente_comprando->tener[$i]['id_tipo']){
                    $bool = $j;
                    $i = count($cliente_comprando->tener);
                    $j = count($objeto_mueble->mueble);
                  }
            }
        }

    return $bool;

  }

}

//clase sucursal
class sucursal {

 //atributos
  public $sucursal;
  public $nsucursal;

  public function __construct(){
      $this->sucursal=array();
  }


  //cargar los datos de los proveedores y darselos a el opbjeto
  public function agregar_sucursal(){
    $sucursal_aux = new sucursal();
    $i=0;
    $sql = "SELECT * FROM sucursal";
    $res1=pg_query(conexion::conectar(),$sql);

    if($res1 != null) {
        while($row=pg_fetch_assoc($res1)){
            $i+=1;
            $row['imagen'] ="../IMG/Sucursal/".$row[ 'nombre' ].".jpg";
            $sucursal_aux->sucursal[]= $row;
          }
    $sucursal_aux->nsucursal = $i;
   }
    return $sucursal_aux;
  }

}

//clase asesores
class asesor {
  public $nasesor;
  public $asesor;

  public function __construct(){
      $this->asesor=array();
  }

  //agregar asesor
  public function agregar_asesor (){
    $asesor_aux = new asesor();
    $i = 0;
    $sql = "SELECT * FROM asesor ";
    $res1=pg_query(conexion::conectar(),$sql);

        if($res1 != null) {
            while($row=pg_fetch_assoc($res1)){
                $i+=1;
                $row['imagen'] ="../IMG/Asesores/".$row[ 'codigo' ].".jpg";
                $asesor_aux->asesor[]= $row;
              }
        $asesor_aux->nasesor = $i;
        }
    return $asesor_aux;
  }

}

//clase muebles
class mueble {

  public $nmueble;
  public $categorias;
  public $mueble;

  public function __construct(){
      $this->mueble=array();
      $this->categorias=array();
  }

  //agregar asesor
  public function agregar_mueble ($objeto_mueble){
    $mueble_aux = $objeto_mueble;
    $i = 0;
    //trae toda la informacion de los muebles que hay en la DB
    $sql = "SELECT * FROM mueble";
    $res1=pg_query(conexion::conectar(),$sql);

    //resultado de todos los datos de los muebles que hay en la DB
    if($res1 != null) {
        while($row=pg_fetch_assoc($res1)){
            $i+=1;
            $row['imagen'] ="../IMG/Muebles/".$row[ 'id_tipo' ].".jpg";
            $mueble_aux->mueble[]= $row;
        }
        $mueble_aux->nmueble = $i;
   }
   //trae solo las categorias
   $sql1 = "SELECT categoria FROM mueble GROUP BY categoria";
   $res2=pg_query(conexion::conectar(),$sql1);

   //resultado de las categorias
   if($res2 != null) {
      while($row1=pg_fetch_assoc($res2)){
          $mueble_aux->categorias[]= $row1;
      }
    }
    return $mueble_aux;

  }

}

//clase proveer
class proveer {
  public $proveer;
  public $nproveer;

  public function __construct(){
    $this->proveer = array();
  }

  public function agregar_proveer($objeto_proveer){
    $proveer_aux = $objeto_proveer;
    $i=0;

    $sql = "SELECT * FROM proveer ";
    $res1 = pg_query(conexion::conectar(), $sql);

    if($res1 != null){
          while ($row = pg_fetch_assoc($res1)) {
              $i+=1;
              $proveer_aux->proveer[] = $row;
            }
          $proveer_aux->nproveer = $i;
    }
    return $proveer_aux;
  }

}

//clase clientes
class cliente {

    public $ncliente;
    public $cliente_ejecucion;
    public $cliente;

    public function __construct(){
        $this->cliente=array();
        $this->cliente_ejecucion = array();
    }

    public function agregar_cliente ($objeto_cliente){
      $cliente_aux = $objeto_cliente;
      $i = 0;

      $sql = "SELECT * FROM cliente";
      $res1=pg_query(conexion::conectar(),$sql);

      if($res1 != null) {
          while($row=pg_fetch_assoc($res1)){
              $i+=1;
              $cliente_aux->cliente[]= $row;
            }
      $cliente_aux->ncliente = $i;
      }
    return $cliente_aux;
  }

}

//clase proveedor
class proveedor{
  public $proveedor;
  public $nproveedor;

  public function __construct(){
    $this->proveedor = array();
  }

  public function agregar_proveedor ($objeto_proveedor){
    $proveedor_aux = $objeto_proveedor;
    $i=0;

    $sql = "SELECT * FROM proveedor";
    $res1 = pg_query(conexion::conectar(), $sql);

    if($res1 != null){
          while($row = pg_fetch_assoc($res1)){
              $i+=1;
              $proveedor_aux->proveedor[] = $row;
            }
      $proveedor_aux->nproveedor = $i;
    }
    return $proveedor_aux;
  }
}

//clase tener
class tener {
  public $tener;
  public $ntener;

  public function __construct(){
    $this->tener = array();
  }

  public function agregar_tener($objeto_tener){
    $tener_aux = $objeto_tener;
    $i=0;

    $sql = "SELECT * FROM tener ORDER BY tener.id_tipo";
    $res1 = pg_query(conexion::conectar(), $sql);

    if($res1 != null){
          while ($row = pg_fetch_assoc($res1)) {
              $i+=1;
              $tener_aux->tener[] = $row;
            }
      $tener_aux->ntener = $i;
    }
    return $tener_aux;
  }
}

//clase venta
class venta {
  public $venta;
  public $nventa;

  public function __construct(){
    $this->venta = array();
  }

  public function agregar_venta($objeto_venta){
    $venta_aux = $objeto_venta;
    $i=0;

    $sql = "SELECT * FROM venta ";
    $res1 = pg_query(conexion::conectar(), $sql);

    if($res1 != null){
          while ($row = pg_fetch_assoc($res1)) {
              $i+=1;
              $venta_aux->venta[] = $row;
            }
      $venta_aux->nventa = $i;
    }
    return $venta_aux;
  }

}

//clase estar
class estar {
  public $estar;
  public $nestar;

  public function __construct(){
    $this->estar = array();
  }

  public function agregar_estar($objeto_estar){
    $estar_aux = $objeto_estar;
    $i=0;

    $sql = "SELECT * FROM estar ";
    $res1 = pg_query(conexion::conectar(), $sql);

    if($res1 != null){
          while ($row = pg_fetch_assoc($res1)) {
              $i+=1;
              $estar_aux->estar[] = $row;
            }
      $estar_aux->nestar = $i;
    }
    return $estar_aux;
  }

}

 ?>
