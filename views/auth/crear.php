<div class="contenedor crear">
  <?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>

  <div class="contenedor-sm">
    <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

    <form method="POST" action="/crear" class="formulario">
      <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" />
      </div>
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" />
      </div>
      <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" />
      </div>
      <div class="campo">
        <label for="password2">Repetir Password</label>
        <input type="password" id="password2" name="password2" placeholder="Repite tu password" />
      </div>

      <input type="submit" value="Iniciar sesión" class="boton" />
    </form>
    <div class="acciones">
      <a href="/">¿Ya tienes cuenta? Iniciar sesión</a>
      <a href="/olvide">¿Olvidates tu Password?</a>
    </div>
  </div> <!-- Fin contenedor-sm -->
</div>