<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php") ?>   
    </head>
    <body>
    <div class="container mt-5 bg-secondary bg-gradient text-white">	
        <form action="/TB-ROOT/controller/UsuarioController.php" enctype="multipart/form-data" name="alta" method="post" class="row g-3" oninput='up2.setCustomValidity(up2.value != up.value ? "Las contraseñas no coinciden." : "")'>
            <div class="col-md-2">
                <label for="validationDefaultUsername" class="form-label">Cedula</label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend2">@</span>
                    <input type="text" class="form-control" id="validationDefaultUsername" name="cedula" aria-describedby="inputGroupPrepend2" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="validationDefault01" name="nombre">
            </div>         
            
            <div class="col-md-3">
                <label for="password1" class="form-label">Contraseña</label>
                <input id="password1" class="form-control" type="password" name="up" required>
            </div>
            
            <div class="col-md-3">
                <label for="password2" class="form-label">Confirmar contraseña</label>
                <input id="password2" class="form-control" type="password" name="up2">
            </div>
            
            <div class="col-md-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mail" required>
                <div id="emailHelp" class="form-text text-white">Nunca compartiremos tu e-mail a nadie.</div>
            </div>
            
            <div class="col-md-2">
                <label for="validationDefault02" class="form-label">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="validationDefault02" name="fnac" required>
            </div>
                            
            <div class="col-md-3">
                <div class="wrap-input3 validate-input"> Subir foto de perfil			
                    <input style="margin-top: 8px" class="input3" type="file" accept="image/png, image/gif, image/jpeg" size="60" name="filecover"> 			            	             		              				
                </div>
            </div>	

            <input type="hidden" name="registro">
            <div class="col-12">
                <input class="btn btn-light mb-2" type="submit" value="Registrarse"/>
            </div>		  
        </form>	
    </div>
    </body>
    <?php include("footer.html") ?>     
</html>
