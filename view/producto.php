<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php");
        include_once("/var/www/webroot/TB-ROOT/model/Producto.php") ?>   
    </head>
    <body>
       
        <?php if (isset($_GET['id'])) {          
            $producto = new Producto();
            $producto->buscarProducto($_GET['id']); 
            if (isset($_SESSION['encontradoProd'])) {
                $id = $_SESSION['idProd'];
                $nombre = $_SESSION['nombreProd'];
                $precio = $_SESSION['precio'];
                $img = $_SESSION['imagenProd'];
                $stock = $_SESSION['stock'];
                $cat = $_SESSION['categoria'];
                $desc = $_SESSION['descripcion'];     
            }
        }      
        ?>       

        <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: 540px">
            <div class="card mb-3 bg-secondary bg-gradient text-white" style="max-width: 540px;">
                <div class="row g-0 justify-content-center">
                    <div class="col-md-4">
                        <img class="d-block mx-auto img-thumbnail" src="data:image/jpg;base64,<?php echo $img ?>">
                    </div>                            
                        <div class="col-md-10">
                            <form name="editar" action="/TB-ROOT/controller/ClienteController.php" method="post">
                            <input type="hidden" name="nombreProductoAg" value="<?php echo htmlspecialchars($nombre)?>">
                            <input type="hidden" name="precioProductoAg" value="<?php echo htmlspecialchars($precio)?>">
                            <div class="card-body text-white">
                            <p class="card-title text-center">Producto: <?php echo $nombre ?></p>
                            <p class="card-text fw-light fst-italic"><?php echo $desc ?></p>
                            <p class="card-text"><?php echo 'U$D: ' . $precio ?></p>

                            <?php if (isset($_SESSION['correo'])) { ?> 
                                <div class="col-3">
                                    <input name="cant" type="number" class="form-control text-center" value="1" min="1" max="<?php echo $stock ?>">
                                </div>
                                <input type="hidden" name="agregarProductoCarrito">
                                <?php if ($stock > 0) { ?>
                                    <input type="submit" class="btn btn-secondary mt-3" value="Agregar al carrito">
                                <?php } else { ?> 
                                        <a href="/TB-ROOT/index.php"> <input class="btn btn-secondary" type="button" value="Producto sin stock, lo sentimos." style="margin-top: 10px"> 
                                <?php } ?>  
                            <?php } ?>             
                            </form>  
                        </div>    
                        <a href="/TB-ROOT/index.php" onclick="<?php unset($_SESSION['message']) ?>"> <input class="btn btn-secondary" type="button" style="margin-left: 15px; margin-bottom: 5px" value="Volver"> </a>
                </div>
            </div>
        </div>
        <?php include("comentarios.php") ?> 
    </body>
    <?php include("footer.html") ?>      
</html>