<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <?php include("header.php") ?>           
    </head>
    <body>    
        <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: 300">

            <h2> Editar usuario pendiente </h2>

            <form action= "/TB-ROOT/controller/AdminController.php" method="post">
                <?php 
                    if (isset($_GET['id'])) {
                        $id = $_GET['id']; 
                        echo 'Usuario Id: ' . $id ?> <br>                 
                        <input type="hidden" name="cambiarPendiente" value="<?php echo $id?>">
                        <input class="btn btn-secondary mt-3 mb-3" type="submit" value="Cambiar"/>                
                <?php } ?>
            </form>
        </div>
    </body>
<?php include("footer.html") ?>   
</html>