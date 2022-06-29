<?php    
    function img64($data) {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))  {   
            return true;
        } else {         
            return false;     
        }
    }
    if (isset($_SESSION['encontradoProd'])) {          
        $comentarios = $producto->listarComentariosProducto($nombre);              
        if (isset($comentarios)) {
    ?>

    <div class="container">
        <div class="card bg-secondary bg-gradient border-warning">
            <?php for ($i=0; $i < count($comentarios); $i++) { ?>         
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="data:image/jpg;base64,<?php $img = $comentarios[$i]['imagen'];
                                                                if (!img64($img)) 
                                                                    $img = base64_encode($img);
                                                                echo $img ?>"
                                class="img img-rounded img-fluid "/>
                        </div>
                        <div class="col-md-10">
                            <p>
                                <strong><?php echo '#' . $comentarios[$i]['idComentario'] . ' ' .$comentarios[$i]['nombre']?></strong>
                                <?php for ($j=1; $j <= $comentarios[$i]['valoracion']; $j++) { ?>  
                                    <span class="float-end"><i class="text-warning fa fa-star"></i></span>  
                                <?php } ?>                                  
                            </p>
                        <div class="clearfix"></div>
                            <p> <?php echo $comentarios[$i]['texto'] ?> </p>                                
                        </div>
                    </div>
                </div>
            <?php } ?>           
        </div>
    </div>
<?php }
} ?>