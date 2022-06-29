<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php include("header.php");   
              $cliente = new Cliente();
              $productosCarrito = $cliente -> listar_productosCarrito($_SESSION['correo']);                             
        ?>          
    </head>
    <body">       
      
    <div class="container mt-5 bg-secondary bg-gradient text-white">
        <h3>Productos a comprar </h3></br>        
        <table border="1" class="table table-hover">
        <thead>            
            <th><strong>Nombre</strong></td>
            <th><strong>Precio</strong></td>
            <th><strong>Cantidad</strong></td>
            <th><strong>SubTotal</strong></td>
        </tr></thead>
        <tbody id="myTable2">
        <?php for ($i=0; $i < count($productosCarrito); $i++) { ?>                      
            <tr style="display: table-row;">
                <td> <?php echo $productosCarrito[$i]["nombre"] ?> </td>
                <td> <?php echo $productosCarrito[$i]["precio"] ?> </td>                                
                <td> <?php echo $productosCarrito[$i]["cantidad"] ?> </td>  
                <td> <?php echo $productosCarrito[$i]["precio"] * $productosCarrito[$i]["cantidad"] ?> </td> 
            </tr> </tbody>                                                     
        <?php } ?>
        <tfoot>            
            <tr>
                <td> Seleccione método de pago
                    <div class="row" style="margin-top: 5px">
                        <div class="col-2">
                            <form id="formComprarMC" action="/TB-ROOT/controller/ClienteController.php" method="post">
                                <a href="#" onclick="document.getElementById('formComprarMC').submit();"> 
                                    <input type="hidden" name="realizaCompraMC"> 
                                    <input type="hidden" name="total" value="<?php echo $_GET['total'] ?>">               
                                    <img src="resources/mc.png" width="70" height="50" style="margin-left: 20px"> 
                                </a>
                            </form>
                        </div>
                        <div class="col-2">
                            <form id="formComprarV" action="/TB-ROOT/controller/ClienteController.php" method="post">
                                <a href="#" onclick="document.getElementById('formComprarV').submit();"> 
                                    <input type="hidden" name="realizaCompraV">
                                    <input type="hidden" name="total" value="<?php echo $_GET['total'] ?>">  
                                    <img src="resources/visa.png" width="70" height="50" style="margin-left: 20px">
                                </a>
                            </form>
                        </div>
                        <div class="col-2">
                            <form id="formComprarPP" action="/TB-ROOT/controller/ClienteController.php" method="post">
                                <a href="#" onclick="document.getElementById('formComprarPP').submit(); "> 
                                    <input type="hidden" name="realizaCompraPP">
                                    <input type="hidden" name="total" value="<?php echo $_GET['total'] ?>">  
                                    <img src="resources/paypal.png" width="90" height="50" style="margin-left: 20px"> 
                                </a>                         
                            </form>
                        </div>
                    </div>
                </td>                                                                                                      
            </tr>
            <tr>
                <td>
                    <form id="formCancelarCompra" action="/TB-ROOT/controller/ClienteController.php" method="post">
                         <input type="hidden" name="cancelarCompra">
                         <a href="#" onclick="document.getElementById('formCancelarCompra').submit(); console.log('send');" class="btn btn-warning"><i class="fa fa-angle-left"></i> Volver y cancelar compra</a>
                    </form>
                </td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center text-light">Total: 
                    <?php echo $_GET['total']; ?> 
                </td>                                                                                                      
            </tr>
        </tfoot>
        </table>         
    </div>      
    </body>
    <?php include("footer.html") ?>         
 </html>   
   