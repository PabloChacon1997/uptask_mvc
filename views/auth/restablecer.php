<div class="contenedor restablecer">
<?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>


  <div class="contenedor-sm">
    <p class="descripcion-pagina">Coloca tu nuevo password</p>
    <?php include_once __DIR__.'/../templates/alertas.php'; ?>
    <?php if($mostrar): ?>
    <form method="POST" class="formulario">
      <div class="campo">
        <label for="password">Nuevo Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" />
      </div>

      <input type="submit" value="Guardar password" class="boton" />
    </form>
    <?php endif; ?>
    <div class="acciones">
      <a href="/crear">¿Aun no tienes cuenta? Crea una</a>
      <a href="/olvide">¿Olvidates tu Password?</a>
    </div>
  </div> <!-- Fin contenedor-sm -->
</div>