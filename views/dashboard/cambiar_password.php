
 <?php include_once __DIR__."/header-dashboard.php"; ?>
 <div class="contenedor-sm">
   <?php include_once __DIR__."/../templates/alertas.php"; ?>
   <a href="/perfil" class="enlace">Volver al perfil</a>
   <form action="/cambiar-password" class="formulario" method="POST">
     <div class="campo">
       <label for="passwordActual">Password actual</label>
       <input type="password" name="passwordActual" id="passwordActual" placeholder="Tu password actual" />
     </div>
     <div class="campo">
       <label for="nuevoPassword">Nuevo password</label>
       <input type="password" name="nuevoPassword" id="nuevoPassword" placeholder="Tu nuevo password" />
     </div>

     <input type="submit" value="Guardar cambios" />
   </form>
 </div>
 <?php include_once __DIR__."/footer-dashboard.php"; ?>