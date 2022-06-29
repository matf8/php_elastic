<?php
	require_once("/var/www/webroot/TB-ROOT/model/Cliente.php");
	require_once("/var/www/webroot/TB-ROOT/model/Producto.php");
	session_start();
    
	$cliente = new Cliente();
	$producto = new Producto();

	if(isset($_POST['listadoCliente'])) {
       $cliente -> listar_clientes();
    }

	if(isset($_POST['editarUser'])) {
		if (!empty($_FILES["filecover"]["name"])) {
			$fileName = basename($_FILES["filecover"]["name"]); 
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 		
			$allowTypes = array('jpg','png','jpeg','gif'); 
			if (in_array($fileType, $allowTypes)) { 
				$image = $_FILES['filecover']['tmp_name']; 
				$imgContent = addslashes(file_get_contents($image));			
			} 
		} else { 
			echo "no cambié";
			$imgContent = $_SESSION['img'];
		}
        $res = $cliente->editarUsuario($_POST['id'], $_POST['Nnombre'], $_POST['Ncorreo'], $imgContent);    
        $_SESSION['message'] = $res;
        header("Location: /TB-ROOT/index.php");
    } 

	if(isset($_POST['agregarProductoCarrito'])) {
		try {
      		$idCarrito = $cliente -> iniciarCarrito($_SESSION['correo']);	
			$res2 = $producto -> decrementarStockProducto($_POST['nombreProductoAg'], $_POST['cant']);
			if ($res2 == "negativo")
				$_SESSION['message'] = "Stock insuficiente para su compra";
			else {
				$res = $cliente -> agregarProductoCarrito($idCarrito, $_POST['nombreProductoAg'], $_POST['cant']);
				$_SESSION['message'] = $res;
			} 		 	
			header("Location: /TB-ROOT/view/productos.php");
		} catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
		}
	}

	if(isset($_POST['eliminarProductoCarrito'])) { // elimina de a 1 hasta llegar a 0
		try {
      		$res = $cliente -> quitarProductoCarrito($_SESSION['correo'], $_POST['eliminarProductoCarrito']);	
			$cliente->checkCantProductos($_SESSION['correo']);
			$_SESSION['message'] = $res;				
			header("Location: /TB-ROOT/view/carrito.php");
		} catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
		}
	}

	if(isset($_POST['eliminarTodos'])) {	// elimina el producto sin importa la cantidad
		try {
      		$res = $cliente -> eliminarProductoCarrito($_SESSION['correo'], $_POST['eliminarTodos']);				
			$res2 = $producto -> incrementarStockProducto($_POST['eliminarTodos'], $_POST['eliminarTodosCant']);
			$cliente->checkCantProductos($_SESSION['correo']);
			$_SESSION['message'] = $res;				
			header("Location: /TB-ROOT/view/carrito.php");
		} catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
		}
	}
	
	if(isset($_POST['realizaCompraMC'])) {
		$res = $cliente -> realizarCompra("mastercard", $_SESSION['correo'], $_POST['total']);		
		if ($res = "ok") {
			$res2 = $cliente -> cambiarCarritoCompletado($_SESSION['correo']);
			if ($res2 = "ok") 
				$_SESSION['message'] = "Gracias por su compra con MasterCard!! El equipo de deliverys ya empezó a preparar su paquete; lo esperamos nuevamente.";		
			else $_SESSION['message'] = $res2;
		} else $_SESSION['message']	= $res;	
		header("Location: /TB-ROOT/index.php");	
	} else if(isset($_POST['realizaCompraV'])) {
		$cliente -> realizarCompra("visa", $_SESSION['correo'], $_POST['total']);	
		if ($res = "ok") {
			$res2 = $cliente -> cambiarCarritoCompletado($_SESSION['correo']);
			if ($res2 = "ok") 
				$_SESSION['message'] = "Gracias por su compra con Visa!! El equipo de deliverys ya empezó a preparar su paquete; lo esperamos nuevamente.";		
				else $_SESION['message'] = $res2;
		} else $_SESSION['message']	= $res;	
		header("Location: /TB-ROOT/index.php");
	} else if(isset($_POST['realizaCompraPP'])) {
		$cliente -> realizarCompra("paypal", $_SESSION['correo'], $_POST['total']);	
		if ($res = "ok") {
			$res2 = $cliente -> cambiarCarritoCompletado($_SESSION['correo']);
			if ($res2 = "ok") 
				$_SESSION['message'] = "Gracias por su compra con PayPal!! El equipo de deliverys ya empezó a preparar su paquete; lo esperamos nuevamente.";		
			else $_SESSION['message'] = $res2;
		} else $_SESSION['message']	= $res;		
		header("Location: /TB-ROOT/index.php");
	}

	if(isset($_POST['comentarProducto'])) {	
		try {
      		$producto = $_POST['productoComentado'];
			$comentario = $_POST['comentario'];
			$usuario = $_SESSION['correo'];
			$valoracion = $_POST['valoracion'];
			//echo $producto . "- " . "usuario " .$usuario . ": " . $comentario;
			$res = $cliente -> comentarProducto($producto, $comentario, $valoracion, $usuario);
			$_SESSION['message'] = $res;
		} catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
		}
		header("Location: /TB-ROOT/index.php");
	}

	if (isset($_POST['cancelarCompra'])) {
		try {
			$res = $cliente->cerrarCarritoPorCancelar($_SESSION['correo']);
			$_SESSION['message'] = $res;
			header("Location: /TB-ROOT/index.php");
		} catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
		}	
	}
?>