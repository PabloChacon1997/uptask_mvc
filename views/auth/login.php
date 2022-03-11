<div class="contenedor login">
<?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>


  <div class="contenedor-sm">
    <p class="descripcion-pagina">Iniciar sesión</p>
    <?php include_once __DIR__.'/../templates/alertas.php'; ?>
    <form method="POST" action="/" class="formulario">
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" />
      </div>
      <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" />
      </div>

      <input type="submit" value="Iniciar sesión" class="boton" />
    </form>
    <div class="acciones">
      <a href="/crear">¿Aun no tienes cuenta? Crea una</a>
      <a href="/olvide">¿Olvidates tu Password?</a>
    </div>
  </div> <!-- Fin contenedor-sm -->
</div>