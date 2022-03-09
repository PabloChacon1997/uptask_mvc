<div class="contenedor olvide">
<?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>


  <div class="contenedor-sm">
    <p class="descripcion-pagina">Recupera tu password</p>

    <form method="POST" action="/olvide" class="formulario">
      <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" />
      </div>

      <input type="submit" value="Enviar instrucciones" class="boton" />
    </form>
    <div class="acciones">
      <a href="/">¿Ya tienes cuenta? Iniciar sesión</a>
      <a href="/crear">¿Aun no tienes cuenta? Crea una</a>
    </div>
  </div> <!-- Fin contenedor-sm -->
</div>