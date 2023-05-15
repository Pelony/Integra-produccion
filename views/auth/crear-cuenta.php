<h1>Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para 
    crear una cuenta</p>

        <?php  include_once __DIR__ . "/../templates/alertas.php";
        ?>
    <form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo s($usuario->nombre);?>"/>
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido);?>"/>
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu telefono" value="<?php echo s($usuario->telefono);?>"/>
    </div>
    <div class="campo">
        <label for="correo">E-mail</label>
        <input type="email" name="correo" id="correo" placeholder="Tu email" value="<?php echo s($usuario->correo);?>"/>
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu password"/>
    </div>

    <input type="submit" class="boton" value="Crear cuenta"/>
    </form>

    <div class="acciones">
    <a href='/'> Ya tienes una cuenta? Ingresa</a> 
    <a href='/olvide'> Olvidaste tu contraseña</a> 
</div>
