<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php") ?>          
    </head>
    <body>
    
    <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto">

        <h2> Editar usuario </h2>

        <?php 
            if (isset($_SESSION['encontrado'])) {
                $id = $_SESSION['id'];
                $tipo = $_SESSION['tipoEditar'];
                $cedula = $_SESSION['ci'];
                $nombre = $_SESSION['nombre'];
                $correo = $_SESSION['correo'];
                $fnac = $_SESSION['fnac'];
            }        
        ?>
        <form name="editar" action="/TB-ROOT/controller/AdminController.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id)?>">
            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo)?>">

            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="validationDefault01" name="Nnombre" value="<?php echo htmlspecialchars($nombre)?>"/>
            </div>  

            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">Cedula</label>
                <input type="text" class="form-control" id="validationDefault01" name="Ncedula" value="<?php echo htmlspecialchars($cedula)?>"/>
            </div>  
            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">Correo</label>
                <input type="text" class="form-control" id="validationDefault01" name="Ncorreo" value="<?php echo htmlspecialchars($correo)?>"/>
            </div>  

            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">Fecha de nacimiento </label>
                <input type="text" class="form-control" id="validationDefault01" name="Nfnac" value="<?php echo htmlspecialchars($fnac)?>"/>
            </div>  

            <div class="col-md-4">
                <label for="validationDefault01" class="form-label"> Password nueva </label>
                <input type="password" class="form-control" id="validationDefault01" name="Npass"/>
            </div>  

            <input type="hidden" name="editarUser">
            <div class="col-12">
                <input class="btn btn-light mb-2 mt-2" type="submit" value="Editar"/>
            </div>	
        </form>

        <form name="borrar" action="/TB-ROOT/controller/AdminController.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id)?>">
            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo)?>">
            <input type="hidden" name="borrarUser">
            <div class="col-12">
                <input class="btn btn-light mb-2 mt-2" type="submit" value="Borrar"/>
            </div>
        </form>	       
    </div>
</body>
<?php include("footer.html") ?>   
</html>
