<<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php") ?>          
    </head>
    <body>
        	
    <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto">
        
         <?php 
            if (isset($_SESSION['encontradoProd'])) {
                $id = $_SESSION['idProd'];
                $nombre = $_SESSION['nombreProd'];
                $precio = $_SESSION['precio'];
                $img = $_SESSION['imagenProd'];
                $stock = $_SESSION['stock'];
                $cat = $_SESSION['categoria'];
                $desc = $_SESSION['descripcion'];
                $categorias = json_decode($_SESSION['ListCategorias'], true);               
            } ?>

        <h2> Editar producto - <?php echo $nombre ?> </h2> </br>
        <form action="/TB-ROOT/controller/AdminController.php" enctype="multipart/form-data" method="post" class="row g-3">
            <input type="hidden" name="idProducto" value="<?php echo htmlspecialchars($id)?>">

            <div class="col-md-3">
                <label for="validationDefault01" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="validationDefault01" name="Nnombre" value="<?php echo htmlspecialchars($nombre)?>"/>
            </div>  
            
            <div class="col-md-1">
                <label for="validationDefault01" class="form-label">Precio</label>
                
                <input type="text" class="form-control" id="validationDefault01" name="Nprecio" value="<?php echo htmlspecialchars($precio)?>"/>
            </div>  

            <div class="col-md-2">
                <label for="validationDefault01" class="form-label">Stock disponible </label>
                <input type="text" class="form-control" id="validationDefault01" name="Nstock" value="<?php echo htmlspecialchars($stock)?>"/>
            </div>  

            <div class="col-md-2">
                <label for="validationDefault01" class="form-label"> Categoría </label>
                <select name="NCat" class="form-select form-select-sm" style="width: 180px; height: 40px" aria-label=".form-select-sm example">                    
                    <option value="<?=$cat?>" selected><?=$cat?></option>
                    <?php foreach ($categorias as $row): 
                        if (strcmp($row["categoria"],$cat)) { ?>   
                            <option value="<?=$row["categoria"]?>"><?=$row["categoria"]?></option>
                    <?php }
                    endforeach ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="validationDefault01" class="form-label"> Descripcion </label>
                <textArea class="form-control" id="validationDefault01" name="Ndesc" rows="3" cols="3"> <?php echo htmlspecialchars($desc) ?> </textarea>
            </div>  

            <div class="col-md-4">
                <img src="data:image/jpg;base64,<?php echo $img ?>" class="img-fluid rounded-start">
            </div>
            <div class="col-md-3">
                <div class="wrap-input3 validate-input"> Cambiar imagen producto			
                    <input style="margin-top: 8px" class="input3" type="file" accept="image/png, image/gif, image/jpeg" size="60" name="filecover"> 			            	             		              				
                </div>
            </div>	

            <input type="hidden" name="submitModificarProducto">
            <div class="col-12">
                <input class="btn btn-light mb-2 mt-2" type="submit" value="Editar"/>
            </div>	
        </form>

        <form action="/TB-ROOT/controller/AdminController.php" method="post">
            <input type="hidden" name="idProducto" value="<?php echo htmlspecialchars($id)?>">       
            <input type="hidden" name="submitBajaProducto">
            <div class="col-12">
                <input class="btn btn-light mb-2 mt-2" type="submit" value="Borrar"/>
            </div>	
        </form>

    </div>
</body>
<?php include("footer.html") ?>   
</html>
