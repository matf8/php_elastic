<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php") ?>   
    </head>
    <body>
        <div id="formAgregarProducto" class="container mt-5 bg-secondary bg-gradient text-white">
            <form action="/TB-ROOT/controller/AdminController.php" enctype="multipart/form-data" method="post" class="row g-3">       
                <h3>Nuevo producto </h3> 
                <div class="col-md-3">                        
                    <label for="validationDefault01" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="validationDefault01" name="nombreProd">  
                </div> 
                <div class="col-md-3">                        
                    <label for="validationDefault01" class="form-label">Precio</label>
                    <input type="text" class="form-control" id="validationDefault01" name="precioProd">  
                </div>
                <div class="col-md-3">                        
                    <label for="validationDefault01" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="validationDefault01" name="descProd">  
                </div>                    
                <div class="col-md-3">                        
                    <label for="validationDefault01" class="form-label">Stock</label>
                    <input type="text" class="form-control" id="validationDefault01" name="stockProd">  
                </div>
                <div class="col-md-3">                        
                    <label for="validationDefault01" class="form-label">Imagen producto</label>
                    <input class="input3" type="file" accept="image/png, image/gif, image/jpeg" size="60" name="filecover"> 			            	             		              				
                </div>

                <div class="col-md-2">
                    <label for="validationDefault01" class="form-label"> Categoría </label>
                    <select name="catProd" class="form-select form-select-sm" style="width: 180px; height: 40px" aria-label=".form-select-sm example">                    
                        <?php if (isset($_SESSION['categoriasAgregarProd'])) {
                                $categorias = json_decode($_SESSION['categoriasAgregarProd'], true);  
                                foreach ($categorias as $row): ?>                               
                                    <option value="<?=$row["categoria"]?>"><?=$row["categoria"]?></option>
                        <?php   endforeach;
                            } ?>
                    </select>
                </div>
                
                <div class="col-12">                
                    <input type="hidden" name="submitAltaProducto">
                    <input class="btn btn-secondary mt-3 mb-3" type="submit" value="Crear Producto"/>
                 </div>
            </form> 
        </div>  

    </body>
    <?php include("footer.html") ?>     
</html>
