<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php"); ?>
    </head>
    <body>

    <form action="/TB-ROOT/controller/ClienteController.php" method="post">
        <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: 540px">
            <h5 id="header" class="modal-title" id="exampleModalLabel"> <?php echo "Valorar producto: " . $_GET['id'] ?> </h5>        
            <div class="col-md-12 me-1">
                <label for="validationDefault01" class="form-label ms-1"> Comentario </label>
                <textArea class="form-control" id="validationDefault01" name="comentario" rows="5" cols="20"> </textarea>
            </div> 
            <div class="col-md-10">
                <label for="validationDefault01" class="form-label ms-1"> Valorar [ 1- Malo -> 5 - Muy bueno]</label>
                <div class="col-md-2">
                    <input class="form-control ms-3" id="validationDefault02" name="valoracion" type="number" value="1" min="1" max="5"> </input>
                </div>
            </div> 
                           
            <input type="hidden" id="productoComentado" name="productoComentado" value="<?php echo $_GET['id'] ?>"/>  
            <input type="hidden" name="comentarProducto"/>    
            <input type="submit" class="btn btn-primary mt-4" value="Comentar"/>                      
        </div>           
    </form>
         
    </body>
<?php include("footer.html") ?>   
</html>