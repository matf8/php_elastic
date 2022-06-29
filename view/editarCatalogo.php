<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php");
        include("/var/www/webroot/TB-ROOT/model/Admin.php");
        $admin = new Admin(); ?>          
    </head>
    <body>
        <?php 
            $catalogo = $admin -> buscarCatalogo($_GET['id']);             
            if (isset($catalogo) && count($catalogo) > 0) {
                $id = $catalogo['idCatalogo'];
                $cat = $catalogo['categoria'];
            ?>
            <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto">       
            <h2> Editar catalogo - <?php echo $cat ?> </h2> </br>    
                <form action="TB-ROOT/controller/AdminController.php" method="post">
                    <div class="col-md-3">
                        <label for="validationDefault01" class="form-label">Nombre categoría</label>
                        <input type="text" class="form-control" id="validationDefault01" name="Nnombre" value="<?php echo htmlspecialchars($cat)?>"/>
                    </div>        
                    <input type="hidden" name="idCatalogo" value="<?php echo htmlspecialchars($id)?>">       
                    <input type="hidden" name="submitModificarCatalogo">
                    <div class="col-12">
                        <input class="btn btn-light mb-2 mt-2" type="submit" value="Editar"/>
                    </div>	
                </form>
            </div>
        <?php }  ?>
</body>
<?php include("footer.html") ?>   
</html>