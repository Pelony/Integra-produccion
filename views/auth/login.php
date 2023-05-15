<h1 class="nombre-pagina"> Inicia Sesion</h1>
<p class="descripcion-pagina"> Inicia Sesion con tus datos</p>

<?php  include_once __DIR__ . "/../templates/alertas.php";?>
<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="correo"> Email </label>
        <input type="email" name="correo" id="correo" placeholder="Correo">
    </div>
    <div class="campo">
        <label for="password"> Password </label>
        <input type="password" name="password" id="password" placeholder="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesion" >
</form>

<div class="acciones">
    <a href='/crear-cuenta'> Aun no tienes una cuenta? Crea una.</a> 
    <a href='/olvide'> Olvidaste tu contraseña</a> 
</div>
