<h1 class="nombre-pagina"> Olvide la contraseña</h1>
<p class="descripcion-pagina"> Restablece tu password con tu email</p>

<?php  include_once __DIR__ . "/../templates/alertas.php";?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="correo"> Email </label>
        <input type="email" name="correo" id="correo" placeholder="correo">
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones" >
</form>

<div class="acciones">
    <a href='/crear-cuenta'> Aun no tienes una cuenta? Crea una.</a> 
    <a href='/'> Ya tienes una cuenta, incia sesion</a> 
</div>
