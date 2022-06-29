<?php
require_once("/var/www/webroot/TB-ROOT/model/Producto.php");
$producto = new Producto();
$productosIndex = $producto -> listar_productos();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("/var/www/webroot/TB-ROOT/view/header.php") ?>          
    </head>
    <body>     	
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="staticBackdropLabel">Cargando espere por favor...</p>
                    </div>
                    <div class="modal-body">
                        <section>
                            <div class="progressbarWrapper">
                                <span id="greenBar"></span>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION["loggedin"]) && !strcmp($_SESSION["tipo"],"admin")) { ?>
            <div style="height: auto; width: auto">
                <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: 500px; float: left; margin-left: 30px; height: 262px">
                    <h3> Gestión usuarios </h3> 

                        <form action="/TB-ROOT/controller/AdminController.php" method="post">
                            <input type="hidden" name="listarUser">
                            <input class="btn btn-warning mt-3 me-3 float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Listar Usuarios"/> 
                        </form>   
                        
                        <input class="btn btn-warning mt-3 ms-3" value="Crear Usuario" type="submit" onclick="toggleCrearUser()"/> <br>
                        
                        <form action="controller/AdminController.php" method="post">
                            <input type="hidden" name="listarUserPendiente">
                            <input class="btn btn-warning mt-3 mb-1 float-end me-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Listar Usuarios PENDIENTES"/>
                        </form>     
                        
                        <input class="btn btn-warning mt-3 ms-3" type="submit" value="Buscar Usuario" onclick="toggleBuscarUser()"/> <br>

                </div>

                <div class="container mt-5 bg-secondary bg-gradient text-white float-start ms-2" style="width: 500px; height: 262px">
                    <h3> Gestión catálogo </h3>                    
                    <form action="/TB-ROOT/controller/AdminController.php" method="post">
                        <input type="hidden" name="listarCategorias">
                        <input type="hidden" name="gestion">
                        <input class="btn btn-success mt-3 me-3 float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Listar categorias"/>
                    </form>  

                    <input class="btn btn-success mt-3 ms-3" value="Agregar categorías" type="submit" onclick="toggleAgregarCatalogo()"/> <br>
                    
                    <form action="/TB-ROOT/controller/AdminController.php" method="post">                            
                        <input type="hidden" name="listarProductos">
                        <input class="btn btn-success mt-3 me-3 float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Listar productos & stock"/> 
                    </form> 

                    <form action="/TB-ROOT/controller/AdminController.php" method="post">     
                        <input type="hidden" name="listarCategorias"> 
                        <input class="btn btn-success mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" value="Agregar productos" type="submit"/> <br>
                    </form>  
                    <input class="btn btn-success mt-3 ms-3" type="submit" value="Buscar producto" onclick="toggleBuscarProducto()"/> <br>
                </div>

                <div class="container mt-5 bg-secondary bg-gradient text-white float-start ms-2" style="width: 420px; height: 262px">
                    <h3> Compras </h3> 
                    <form action="/TB-ROOT/controller/AdminController.php" method="post">     
                        <input type="hidden" name="listarCompras"> 
                        <input class="btn btn-danger mt-3 ms-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" value="Ver compras" type="submit"/> <br>
                    </form>                      
                </div>
                <div style="clear: both">
            </div>

            <?php //include_once("gestorAdmin.php"); ?>

            <!-- ////////LISTA DE COMPRAS/////////// -->

            <?php if (isset($_SESSION['compras'])) { ?>
                <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: 600px">
                    <h3>Compras realizadas en Tecno-Bay</h3></br> 

                    <?php $compras = json_decode($_SESSION['compras'], true); ?>
                    <table border="1" class="table table-hover">
                    <thead>
                        <tr><th>#</th>  
                        <th><strong>Cliente</strong></td> 
                        <th><strong>Total compra</strong></td> 
                        <th><strong>Metodo</strong></td> 
                        <th><strong>Fecha</strong></td>                         
                        <th><strong>*</strong></td>                          
                    </tr></thead>
                    <tbody id="myTable">
                    <?php for ($i=0; $i < count($compras); $i++) { ?>                      
                        <tr style="display: table-row;">
                            <td> <?php echo $compras[$i]["idCompra"] ?> </td>
                            <td> <?php echo $compras[$i]["usuario"] ?> </td>
                            <td> <?php echo $compras[$i]["total"] ?> </td>
                            <td> <?php echo $compras[$i]["metodo"] ?> </td>
                            <td> <?php echo $compras[$i]["fecha"] ?> </td>
                            <td> <a href="<?php echo '/TB-ROOT/view/eliminarCompra.php?id='.$compras[$i]['idCompra']?>">Eliminar </a> </td> 
                                 
                        </tr>                                                       
                    <?php } ?>
                    </tbody></table>                   
                    <a href="index.php">
                        <input class="btn btn-secondary mt-3" type="submit" value="Cerrar" onclick=<?php unset($_SESSION["compras"]) ?>/>
                    </a>                  
                </div> 
            <?php } ?> 

            <!-- ////////LISTA DE CATEGORIAS/////////// -->
            <?php if (isset($_SESSION['categoriasAgregarProd'])) { ?>
                <div class="container mt-5 bg-secondary bg-gradient text-white" style="width: 600px">
                    <h3>Categorías del catálogo</h3></br> 
                    <div><img src="/TB-ROOT/view/resources/warning.png" height="40px" width="40px">
                     Si borra una categoría, borra con ella todos sus productos. </div>
                    
                    
                    <?php $categorias = json_decode($_SESSION['categoriasAgregarProd'], true); ?>
                    <table border="1" class="table table-hover">
                    <thead>
                        <tr><th>#</th>  
                        <th><strong>Categoría</strong></td>   
                        <th><strong>*</strong></td>     
                        <th><strong>*</strong></td>                       
                    </tr></thead>
                    <tbody id="myTable">
                    <?php for ($i=0; $i < count($categorias); $i++) { ?>                      
                        <tr style="display: table-row;">
                            <td> <?php echo $categorias[$i]["idCatalogo"] ?> </td>
                            <td> <?php echo $categorias[$i]["categoria"] ?> </td>
                            <form name="borrar" action="controller/AdminController.php" method="post">
                            <input class="btn btn-link" name="submitBajaCatalogo" value="<?php echo $categorias[$i]["idCatalogo"] ?>" type="hidden"/>   
                            <td> <input class="btn btn-link" value="Eliminar" type="submit"/> </td> </form>                                          
                            <td> <a href="<?php echo '/TB-ROOT/view/editarCatalogo.php?id='.$categorias[$i]['idCatalogo']?>">Editar </a> </td> 
                      
                        </tr>                                                       
                    <?php } ?>
                    </tbody></table>                   
                    <a href="index.php">
                        <input class="btn btn-secondary mt-3" type="submit" value="Cerrar" onclick=<?php unset($_SESSION["categoriasAgregarProd"]) ?>/>
                    </a>                  
                </div> 
            <?php } ?> 
                        

            <!-- ////////REGISTRO DE CATEGORIAS/////////// -->
            <div id="formAgregarCatalogo" class="container mt-5 bg-secondary bg-gradient text-white" style="display: none">
                <form action="/TB-ROOT/controller/AdminController.php" method="post">                    
                <h3>Nueva categoría de catálogo</h3>  
                    <div class="col-md-4 ms-4">                                             
                        <label for="validationDefault01" class="form-label">Nombre categoría</label>
                        <input type="text" class="form-control" id="validationDefault01" name="categoria">
                        <input type="hidden" name="submitAltaCatalogo">
                        <input class="btn btn-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Crear categoria"/>
                    </div>    
                </form> 
            </div>
                      
            <!-- ////////LISTA DE PRODUCTOS/////////// -->
            <?php if (isset($_SESSION['productos'])) { ?>
                <div class="container mt-5 bg-secondary bg-gradient text-white">
                    <h3>Productos</h3></br>
                    <?php $productos = json_decode($_SESSION['productos'], true); ?>
                    <table border="1" class="table table-hover">
                    <thead>
                        <tr><th>#</th>  
                        <th><strong>Categoria</strong></td> 
                        <th><strong>Nombre</strong></td>
                        <th><strong>Precio</strong></td>
                        <th><strong>Stock</strong></td>
                    </tr></thead>
                    <tbody id="myTable">
                    <?php for ($i=0; $i < count($productos); $i++) { ?>                      
                        <tr style="display: table-row;">
                            <td> <?php echo $productos[$i]["idProducto"] ?> </td>
                            <td> <?php echo $productos[$i]["categoria"] ?> </td>
                            <td> <?php echo $productos[$i]["nombre"] ?> </td>
                            <td> <?php echo $productos[$i]["precio"] ?> </td>
                            <td> <?php echo $productos[$i]["stock"] ?> </td>                              
                        </tr>                                                       
                    <?php } ?>
                    </tbody></table>                   
                    <a href="index.php">
                        <input class="btn btn-secondary mt-3" type="submit" value="Cerrar" onclick=<?php unset($_SESSION["productos"]) ?>/>
                    </a>                  
                </div> 
            <?php } ?> 
                        
            <!-- ////////COMPRAS DE PRODUCTOS/////////// -->      
            <div id="formCompras" class="container mt-5 bg-secondary bg-gradient text-white" style="display: none">
                <form action="/TB-ROOT/controller/AdminController.php" method="post">
                    <h4> aca aparecen todas las compras wachin </h4>
                </form> 
            </div>   

            <!-- ////////BUSCADOR DE PRODUCTO/////////// -->
            <div id="formBuscarProducto" class="container mt-5 bg-secondary bg-gradient text-white" style="display: none">
                <form action="/TB-ROOT/controller/AdminController.php" method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <h3> Ingrese nombre o id del producto </h3>
                        </div>
                        <div class="col-md-3 mt-2">                   
                            <div class="input-group">                                
                                <input type="text" class="form-control" id="validationDefaultUsername" name="producto" aria-describedby="inputGroupPrepend2" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="buscarProducto">
                    <input class="btn btn-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Buscar"/>
                </form> 
            </div>                    
            <!-- ////////BUSCADOR DE USUARIO/////////// -->
            <div id="formBuscarUser" class="container mt-5 bg-secondary bg-gradient text-white" style="display: none">
                <form action="/TB-ROOT/controller/AdminController.php" method="post">
                    <div class="row">
                        <div class="col-md-2 ">
                            <h3> Ingrese cedula o correo </h3>
                        </div>
                        <div class="col-md-3 mt-2">                   
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                <input type="text" class="form-control" id="validationDefaultUsername" name="user" aria-describedby="inputGroupPrepend2" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="buscarUser">
                    <input class="btn btn-secondary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Buscar"/>
                </form> 
            </div>   
            <!-- ////////LISTA DE USUARIOS/////////// -->
            <?php if (isset($_SESSION['usuarios'])) { ?>
                <div class="container mt-5 bg-secondary bg-gradient text-white">
                        <h3>Usuarios</h3></br>
                        <?php $usuarios = json_decode($_SESSION['usuarios'], true); ?>
                        <table border="1" class="table table-hover">
                        <thead>
                            <tr><th>#</th>   
                            <th><strong>Cedula</strong></td>
                            <th><strong>Estado</strong></td>
                        </tr></thead>
                        <tbody id="myTable">
                        <?php for ($i=0; $i < count($usuarios); $i++) { ?>                      
                            <tr style="display: table-row;">
                                <td> <?php echo $usuarios[$i]["idUsuario"] ?> </td>
                                <td> <?php echo $usuarios[$i]["ci"] ?> </td>
                                <td> <?php echo $usuarios[$i]["estado"] ?> </td>                              
                            </tr>                                                       
                        <?php } ?>
                        </tbody></table>  
                        <a href="index.php">
                            <input class="btn btn-secondary mt-3" type="submit" value="Cerrar" onclick=<?php unset($_SESSION["usuarios"]) ?>/>
                        </a>
                    <?php } ?>     
                </div>  
            <!-- ////////LISTA DE USUARIOS CON ESTADO PENDIENTE/ACEPTADO/////////// -->
            <?php if (isset($_SESSION['pendientes'])) { ?>
                <div class="container mt-5 bg-secondary bg-gradient text-white">
                        <h3>Usuarios</h3></br>
                        <?php $usuariosP = json_decode($_SESSION['pendientes'], true); ?>
                        <table border="1" class="table table-hover">
                        <thead>
                            <tr><th>#</th>   
                            <th><strong>Cedula</strong></td>
                            <th><strong>Estado</strong></td>
                            <th><strong>*</strong></td>
                        </tr></thead>
                        <tbody id="myTable2">
                        <?php for ($i=0; $i < count($usuariosP); $i++) { ?>                      
                            <tr style="display: table-row;">
                                <td> <?php echo $usuariosP[$i]["idUsuario"] ?> </td>
                                <td> <?php echo $usuariosP[$i]["ci"] ?> </td>                                
                                <td> <?php echo $usuariosP[$i]["estado"] ?> </td>  
                                <td> <a href="<?php echo '/TB-ROOT/view/editarEstado.php?id='.$usuariosP[$i]['idUsuario']?>">Editar </a> </td> 
                            </tr>                                                     
                        <?php } ?>
                        </table>  
                        <a href="index.php">
                            <input class="btn btn-secondary mt-3" type="submit" value="Cerrar" onclick=<?php unset($_SESSION["pendientes"]) ?>/>
                        </a>
                    <?php } ?>     
                </div>  
            <!-- ////////REGISTRO DE USUARIO/////////// -->
            <div id="formCrearUser" class="container mt-5 bg-secondary bg-gradient text-white" style="display: none; width: auto">
                <form action="/TB-ROOT/controller/AdminController.php" method="post" class="row g-3">
                    <div class="col-md-2">
                        <label for="validationDefaultUsername" class="form-label">Cedula</label>
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend2">@</span>
                            <input type="text" class="form-control" id="validationDefaultUsername" name="cedula" aria-describedby="inputGroupPrepend2" required>
                        </div>
                    </div> 

                    <div class="col-md-3">
                        <label for="password1" class="form-label">Contraseña</label>
                        <input id="password1" class="form-control" type="password" name="up" required>
                    </div>

                    <div class="col-md-4">
                        <label for="validationDefault01" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="validationDefault01" name="nombre">
                    </div>  

                    <div class="col-md-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mail">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="validationDefault02" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="validationDefault02" name="fnac">
                    </div>
                    
                    <select name="tipo" class="form-select form-select-sm" style="width: 180px; height: 40px; margin-top: 48px; margin-left: 20px" aria-label=".form-select-sm example">                    
                        <option value="Admin">Administrador</option>
                        <option value="Cliente">Cliente</option>
                    </select>

                    <input type="hidden" name="registroUser">                
                    <input class="btn btn-light mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="move()" type="submit" value="Registrarse"/>                    
                </form>	
            </div>
           

        <?php } else { ?>
            <div class="container mt-5" style="width: 300">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <form id="verProducto" action="/TB-ROOT/view/producto.php" method="post">                        
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="10">
                                <img class="d-block mx-auto" src="/TB-ROOT/view/resources/tecnobay.jpg" height="300">
                            </div> 
                            <?php
                                for ($i=0; $i < count($productosIndex); $i++) {                                
                                    $img = base64_encode($productosIndex[$i]['imagen']);
                                    $id = $productosIndex[$i]['idProducto']; ?>   
                                    <div class="carousel-item" data-bs-interval="10">  
                                        <a href="<?php echo '/TB-ROOT/view/producto.php?id='.$id?>"> <img class="d-block mx-auto" src="data:image/jpg;base64,<?php echo $img ?>"> </a>
                                    </div> 
                                <?php  }  ?>                      
                        </div>
                  </form>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
           
        <?php } ?>
        <script>
            function toggleCrearUser() {
                var div = document.getElementById("formCrearUser");
                div.style.display = div.style.display == "none" ? "block" : "none";
            }
            function toggleListarUser() {
                var div = document.getElementById("formListarUser");
                div.style.display = div.style.display == "none" ? "block" : "none";
            }
            function toggleBuscarUser() {
                var div = document.getElementById("formBuscarUser");
                div.style.display = div.style.display == "none" ? "block" : "none";
            }
            function toggleVerCompras() {
                var div = document.getElementById("formCompras");
                div.style.display = div.style.display == "none" ? "block" : "none";
            }
            function toggleBuscarProducto() {
                var div = document.getElementById("formBuscarProducto");
                div.style.display = div.style.display == "none" ? "block" : "none";
            }
            function toggleAgregarCatalogo() {
                var div = document.getElementById("formAgregarCatalogo");
                div.style.display = div.style.display == "none" ? "block" : "none";              
            }
            function spinnerMostrar() {
                var spinner = document.getElementById('spinner')
                spinner.style.display = spinner.style.display == "none" ? "block" : "none";
            }  
            function toggleListarCategorias() {
                var div = document.getElementById("formListarCategorias");
                div.style.display = div.style.display == "none" ? "block" : "none";              
            }

            function move() {
                let elem = document.getElementById("greenBar");
                let stepValue = 0;
                let id = setInterval(frame, 800);

                function frame() {
                    if (stepValue >= 100) {
                        clearInterval(id);                        
                    } else {
                        elem.style.width = (stepValue + 10) + "%";
                        elem.innerHTML = (stepValue + 10) + "%";
                        stepValue=(stepValue + 10);
                    }
                }
            }
        </script> 
    </body>
    <?php include("view/footer.html") ?>     
 </html>   
 
