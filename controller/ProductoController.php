<?php
	require_once("/var/www/webroot/TB-ROOT/model/Producto.php");
	session_start();
    
	$producto = new Producto();

	if(isset($_POST['listadoProducto'])) {
       $producto -> listar_productos();
    }

	if(isset($_POST['todosLosProductos'])) {	
		if (isset($_SESSION["prodByCat"]))
			unset($_SESSION['prodByCat']);
		$_SESSION["allProducts"] = true;
        header("Location: ../view/productos.php");
    }

	if(isset($_GET['cat'])) {
		if (isset($_SESSION["allProducts"]))
			unset($_SESSION['allProducts']);
        $_SESSION['prodByCat'] = $_GET['cat'];
    	header("Location: ../view/productos.php");
    }

	//require_once("../view/vista.php");
?>