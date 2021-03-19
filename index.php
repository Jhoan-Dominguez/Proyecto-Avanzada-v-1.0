<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Menu de Navegacion</title>
      <link rel="stylesheet" href="./CSS/pagina_DBA.css">
      <script type="text/javascript" src="./JS/interacciones.js"></script>
  </head>
  <body>


    <header class = "cabecera">
      <div class="contenedor">
      <nav class = "navigation">

      <ul>

        <li> <a href="">Inicio</a> </li>
        <li> <a href="">Proveedores</a> </li>
        <li> <a href="">Nosotros</a> </li>
        <li> <a href="">Registrar</a> </li>
        <li > <button type="button" name="ingresar" onclick="login()" > Ingresar </button>
          <ul id = "login" class = "login" style="display:none">

            <form class="inicioSesion" action="./PHP/iniciar_sesion.php" method="post">

            <li> USUARIO: <input type="text" name="usuario" value=""> </li>
            <li> CONTRASEÑA: <input type="password" name="password" value=""> </li>
            <input type="submit" name="Aceptar" value="Aceptar">

            </form>

          </ul>
        </li>
      </ul>

      </nav>
    </div>
    </header>
  </body>
</html>
