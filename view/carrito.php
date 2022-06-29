<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php");          
            $cliente = new Cliente();
            $productosCarrito = $cliente -> listar_productosCarrito($_SESSION['correo']);                                
        ?>          
    </head>
    <body>       
        </div>		
        <div class="container">
            <?php if (isset($productosCarrito)) {
                    if ($productosCarrito == "Carrito no existe") { ?>
                <h1 style="color: white"> No tiene productos agregados al carrito </h1> 
                <a href="/TB-ROOT/index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> ¡Ir a comprar!</a></td>
       
                <?php } else { ?>
                <table id="cart" class="table table-hover table-condensed">                    
                    <thead>
                        <tr class="text-light">
                            <th style="width:50%">Producto</th>
                            <th style="width:10%">Precio</th>
                            <th style="width:8%">Cantidad</th>
                            <th style="width:22%" class="text-center">Subtotal</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <?php /// Envolver el tbody en un for para traer cada producto de la bd ?>
                    <?php for ($i=0; $i < count($productosCarrito); $i++) { ?>                      
                    <tbody>                    
                        <tr class="table-success">
                            <td data-th="Producto">
                                <div class="row">
                                    <div class="col-sm-2 hidden-xs me-3"><img src="data:image/jpg;base64,<?php echo base64_encode($productosCarrito[$i]["imagen"]) ?>" alt="..." class="img-thumbnail"/></div>
                                    <div class="col-sm-8 ms-5">
                                        <h4 class="nomargin"><?php echo $productosCarrito[$i]["nombre"] ?></h4>
                                        <p> <?php echo $productosCarrito[$i]["descripcion"] ?> </p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Precio"> <?php echo $productosCarrito[$i]["precio"] ?> </td>
                            <input type="hidden" id="precio" value="<?php echo $productosCarrito[$i]["precio"] ?>">
                            <td data-th="Cantidad"> <?php echo $productosCarrito[$i]["cantidad"]  ?> </td>
                            <input type="hidden" id="cant" value="<?php echo $productosCarrito[$i]["cantidad"] ?>">
                            <td data-th="Subtotal" class="text-center"> <div id="subtotal"> <?php echo ($productosCarrito[$i]["precio"] * $productosCarrito[$i]["cantidad"]); ?> </div> </td>
                            <td class="actions" data-th="">
                                <form id="eliminarProductoCarrito" action="/TB-ROOT/controller/ClienteController.php" method="post"> 
                                    <input type="hidden" name="eliminarProductoCarrito" value="<?php echo $productosCarrito[$i]["nombre"] ?>">                                
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> 1 Unidad</button>
                                </form>	
                                <form id="eliminarProductoCarrito2" action="/TB-ROOT/controller/ClienteController.php" method="post"> 
                                    <input type="hidden" name="eliminarTodos" value="<?php echo $productosCarrito[$i]["nombre"] ?>">  
                                    <input type="hidden" name="eliminarTodosCant" value="<?php echo $productosCarrito[$i]["cantidad"] ?>">                                
                              
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Todos</button>
                                </form>							
                            </td>
                        </tr>
                    </tbody>
                    <?php } ?>    
                    <tfoot>
                        <tr>
                            <td><a href="../index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuar comprando</a></td>
                            <td colspan="2" class="hidden-xs"></td>
                            <td class="hidden-xs text-center text-light">Total: 
                                <?php  $total = 0; 
                                       for ($j=0; $j<count($productosCarrito); $j++) 
                                           $total = $total + ($productosCarrito[$j]["precio"] * $productosCarrito[$j]["cantidad"]);
                                        echo $total;
                                        $uriCheckout = '/TB-ROOT/view/checkout.php?total=' . $total;                                                     
                                    ?> 
                            </td>                                                                                      
                            <td><a href="<?php echo $uriCheckout ?>"  class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
                        </tr>
                    </tfoot>
                </table>
            <?php }
            } ?>
        </div>
    
    </body>
    <?php include("footer.html") ?>         
 </html>   
   