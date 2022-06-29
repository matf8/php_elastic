<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php");
        include_once("/var/www/webroot/TB-ROOT/model/Producto.php");
        $productos = new Producto(); ?>  
    </head>
    <body>       
        <?php if (isset($_SESSION['allProducts']) && $_SESSION['allProducts'] == true) { 
            $productos = $productos->listar_productos(); ?>       
            <div class="row row-cols-5 g-5">
                <?php foreach ($productos as $p): { ?>
                <div class="col"> 
                    <div class="card text-white bg-dark border-primary" style="max-width: 18rem;">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($p['imagen']) ?>" class="card-img-top img-thumbnail">
                    <div class="card-body">
                        <p class="card-title text-center"><?php echo $p['nombre'] . " - " . $p['categoria'] ?> </p>
                        <p class="card-text fw-light fst-italic"> <?php echo $p['descripcion'] ?> </p>
                        <P class="text-muted"><?php echo "USD " . $p['precio'] ?> </p>
                    </div>
                    <div class="card-footer text-muted">
                         <a href="<?php echo '/TB-ROOT/view/producto.php?id='.$p['idProducto']?>" class="btn btn-success btn-block" onclick="move()"> Ver <i class="fa fa-angle-right"></i> </a>
                    </div>
                </div>
            </div>
            <?php } endforeach; ?>                

        <?php } else if (isset($_SESSION['prodByCat'])) {
            $prodByCat = $productos->listarProductosPorCategoria($_SESSION['prodByCat']);             
            if (!count($prodByCat) == 0) {  ?>    
                <div class="row row-cols-5 g-5">
                    <?php foreach ($prodByCat as $p): { ?>
                    <div class="col"> 
                        <div class="card text-white bg-dark border-primary" style="max-width: 18rem;">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($p['imagen']) ?>" class="card-img-top img-thumbnail">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $p['nombre'] . " - " . $p['categoria'] ?> </h5>
                            <p class="card-text"> <?php echo $p['descripcion'] ?> </p>
                            <h5 class="text-muted"><?php echo "USD " . $p['precio'] ?> </h5>
                        </div>
                        <div class="card-footer text-muted">
                            <a href="<?php echo '/TB-ROOT/view/producto.php?id='.$p['idProducto']?>" class="btn btn-success btn-block"> Ver <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php } endforeach; 
            } else { ?> 
                <h1> Categoría lamentablente sin productos por ahora </h1>
        <?php }
        } ?> 
         
    </body>
    <?php include("footer.html") ?>   
</html>