//mostrar detalles de cada mueble

function mostrar_detalles(boton) {

  const id1 = 'imagen'+ boton.id;
  const id2 = 'modal' + boton.id;

  if(  document.getElementById(id1).style.display == 'block'){
    document.getElementById(id1).style.display = 'none';
    document.getElementById(id2).style.display = 'block';
  }else{
    document.getElementById(id1).style.display = 'block';
    document.getElementById(id2).style.display = 'none';
  }

}

function añadir_muebles(boton){

  document.getElementById('sucursal').disabled=true;

  const id_tipo = boton.id;
  alert("se ha añadido el mueble seleccionado");
  location.href = 'http://localhost/Distrital/Proyecto%20DBA/PHP/operaciones.php'+'?idtipo='+id_tipo;
}

function finalizar_compra(){
    alert('se ha realizado la compra con exito, puedes seguir mirando nuestro articulos :)  ')
    location.href = 'http://localhost/Distrital/Proyecto%20DBA/PHP/finalizar_compra.php';
}

function actualizar(){

  var select1 = "";
  select1 = document.getElementById('sucursal');
  var seleccion1 = select1.options[select1.selectedIndex].text;
  location.href = 'http://localhost/Distrital/Proyecto%20DBA/PHP/actualizar.php' + '?seleccion1=' + seleccion1;

}
