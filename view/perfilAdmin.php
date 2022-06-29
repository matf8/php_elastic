<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php") ?>   
    </head>
    <body>
    
        <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto">
            <form action="/TB-ROOT/controller/UsuarioController.php" enctype="multipart/form-data" name="alta" method="post" class="row g-3" oninput='up2.setCustomValidity(up2.value != up.value ? "Las contraseñas no coinciden." : "")'>
                <input type="hidden" name="nuevaPass">

                <div class="col-md-4">
                    <label for="old" class="form-label">Contraseña antigua</label>
                    <input id="old" class="form-control" type="password" name="old" required>
                </div>

                <div class="col-md-3">
                    <label for="password1" class="form-label">Contraseña nueva</label>
                    <input id="password1" class="form-control" type="password" name="up" required>
                </div>
                
                <div class="col-md-3">
                    <label for="password2" class="form-label">Confirmar contraseña</label>
                    <input id="password2" class="form-control" type="password" name="up2">
                </div>

                <div class="col-12" style="margin-top: 20px">
                    <input class="btn btn-light mb-2" type="submit" value="Cambiar contraseña"/>
                </div>		 
            </form>
        </div>
    </body>
    <?php include("footer.html") ?>   
</html>