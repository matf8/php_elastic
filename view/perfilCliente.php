<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php");
        include_once("/var/www/webroot/TB-ROOT/model/Cliente.php")  ?>          
    </head>
    <body>   
        <?php 
        $cliente = new Cliente();
        $res = $cliente->buscarCliente($_SESSION['idCliente']);
        if ($res == "ok") {
            $id = $_SESSION['id'];
            $tipo = $_SESSION['tipoEditar'];
            $cedula = $_SESSION['ci'];
            $nombre = $_SESSION['nombre'];
            $correo = $_SESSION['correo'];
            $fnac = $_SESSION['fnac'];
            $img = $_SESSION['img'];
        }        
        $compras = $cliente -> listarComprasUsuario($correo);  
        ?>      

        <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto">
          
            <h2> Perfil </h2>
            <input class="btn btn-secondary mt-3" value="Modificar mis datos" type="submit" onclick="toggleModificar()"/> <br>
            <input class="btn btn-secondary mt-3 mb-2" type="submit" value="Modificar contraseña" onclick="togglePassword()"/> <br>

        </div>

        <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto">
          
            <h2> Historial de compras </h2>

            <?php if (isset($compras)) { ?>                                        
                    <table border="1" class="table table-hover">
                    <thead>       
                        <th><strong>Compra</strong></th>                      
                        <th><strong>Metodo</strong></th>     
                        <th><strong>Total</strong></th>    
                        <th><strong>Fecha</strong></th>
                        <th><strong>Producto</strong></th>                            
                    </tr></thead>
                    <tbody id="myTable">
                    <?php $j=0; while ($j < count($compras)) { ?>                      
                        <tr style="display: table-row;">  
                            <td> <?php echo '#' . $compras[$j]['idCompra'] ?> </td>
                            <td> <?php echo $compras[$j]['metodo'] ?> </td>
                            <td> <?php echo $compras[$j]['total'] ?> </td>
                            <td> <?php echo $compras[$j]['fecha'] ?> </td>
                            <?php $productos = $cliente -> listarProductosUsuario($compras[$j]['idCompra']); 
                                  $j++;
                                  if (isset($productos)) {  
                                       $i=0; 
                                       do { ?> 
                                        <td> 
                                        <table border="1" class="table table-hover">
                                            <thead>   
                                            <th><strong>Nombre</strong></th>
                                            <th><strong>*</strong></th>
                                            </tr></thead>
                                            <tbody id="myTable">                                                                    
                                            <tr style="display: table-row;">  
                                                <td> <?php echo $productos[$i]['producto'] ?> </td> 
                                                <?php if (!$cliente->checkComentario($productos[$i]['producto'], $_SESSION['correo'])) { ?>
                                                    <td> <a href="/TB-ROOT/view/comentarProducto.php?id=<?php echo $productos[$i]['producto']?>"> <input class="btn btn-warning" type="button" value="Valorar producto"/> </a> </td>                                         
                                                <?php } else { ?> <td> <button disabled class="btn btn-warning" type="button"> Valorar producto </button> </td> <?php } ?> <td>                                     
                                                </tr>  
                                    <?php $i++; } while ($i < count($productos));
                                    } ?>
                                    </tbody></table>                                        
                        </tr>                                            
                    <?php                         
                      $j++;   } ?>
                    </tbody></table>                          
                </div> 
            <?php } ?>        
        
  

        <div id="mod" class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto; display: none">
            <form action="/TB-ROOT/controller/ClienteController.php" enctype="multipart/form-data" method="post" class="row g-3">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id)?>">
                <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo)?>">

                <div class="col-md-4">
                    <label for="validationDefault01" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="validationDefault01" name="Nnombre" value="<?php echo htmlspecialchars($nombre)?>"/>
                </div>  

                <div class="col-md-4">
                    <label for="validationDefault01" class="form-label">Cedula</label>
                    <input type="text" class="form-control" id="validationDefault01" readonly name="Ncedula" value="<?php echo htmlspecialchars($cedula)?>"/>
                </div>  
                <div class="col-md-4">
                    <label for="validationDefault01" class="form-label">Correo</label>
                    <input type="text" class="form-control" id="validationDefault01" name="Ncorreo" value="<?php echo htmlspecialchars($correo)?>"/>
                </div>  

                <div class="col-md-4">
                    <label for="validationDefault01" class="form-label">Fecha de nacimiento </label>
                    <input type="text" class="form-control" id="validationDefault01" readonly name="Nfnac" value="<?php echo htmlspecialchars($fnac)?>"/>
                </div>  

                <div class="col-md-4">
                    <img src="data:image/jpg;base64,<?php echo $img ?>" class="img-fluid rounded-start">
                </div>

                <div class="col-md-3">
                    <div class="wrap-input3 validate-input"> Cambiar foto de perfil			
                        <input style="margin-top: 8px" class="input3" type="file" accept="image/png, image/gif, image/jpeg" size="60" name="filecover"> 			            	             		              				
                    </div>
                </div>	
            
                <input type="hidden" name="editarUser">
                <div class="col-12">
                    <input class="btn btn-light mb-2 mt-2" type="submit" value="Editar"/>
                </div>          
            </form>
        </div>

        <div id="pass" class="container mt-5 bg-secondary bg-gradient text-white" style="width: auto; display: none">
            <form action="/TB-ROOT/controller/UsuarioController.php" method="post" enctype="multipart/form-data" class="row g-3" oninput='up.setCustomValidity(new.value != up.value ? "Las contraseñas no coinciden." : "")'>
                <input type="hidden" name="nuevaPass">
                <div class="col-md-4">
                    <label for="password1" class="form-label">Contraseña antigua</label>
                    <input id="password1" class="form-control" type="password" name="old" required>
                </div>

                <div class="col-md-4">
                    <label for="password2" class="form-label">Contraseña nueva</label>
                    <input id="password2" class="form-control" type="password" name="new" required>
                </div>
                
                <div class="col-md-4">
                    <label for="password3" class="form-label">Confirmar contraseña</label>
                    <input id="password3" class="form-control" type="password" name="up">
                </div>
                
                <div class="col-12" style="margin-top: 20px">
                    <input class="btn btn-light mb-2" type="submit" value="Cambiar contraseña"/>
                </div>		 
            </form>

        </div>

        <script>
        function toggleModificar() {
            var div = document.getElementById("mod");
            div.style.display = div.style.display == "none" ? "block" : "none";
        }
        function togglePassword() {
            var div = document.getElementById("pass");
            div.style.display = div.style.display == "none" ? "block" : "none";
        }
      
        function cargarDatosComentar(){
            var producto = document.getElementById("producto").value;
            document.getElementById("header").innerHTML = "Valorar Producto " + producto;
            document.getElementById("productoComentado").value = producto;

        }
            
        </script>
    </body>
<?php include("footer.html") ?>   
</html>