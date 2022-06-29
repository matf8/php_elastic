<?php
	require_once("/var/www/webroot/TB-ROOT/model/Cliente.php");
    require_once("/var/www/webroot/TB-ROOT/model/Admin.php");
    require_once("/var/www/webroot/TB-ROOT/model/Producto.php");
    require_once("/var/www/webroot/TB-ROOT/model/Catalogo.php");

    session_start();
    $cliente = new Cliente();
    $admin = new Admin();
    $catalogo = new Catalogo();
    $producto = new Producto();

    if(isset($_POST['borrarUser'])) {
        $res = $admin->borrarUsuario($_POST['id'], $_POST['tipo']);   
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['buscarUser'])) {
        $res = $admin->buscarUsuarios($_POST['user']);   
        if (strcmp($res, "ok"))    
            header("Location: /TB-ROOT/index.php");
        else header("Location: /TB-ROOT/view/editarUsuario.php");
    }

    if(isset($_POST['editarUser'])) {
      	$pass = password_hash($_POST['Npass'], PASSWORD_DEFAULT);
        $res = $admin->editarUsuario($_POST['id'], $_POST['Nnombre'], $pass, $_POST['Ncedula'], $_POST['Ncorreo'], $_POST['tipo'], $_POST['Nfnac']);    
        $_SESSION['message'] = $res;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['cambiarPendiente'])) {
        $res = $admin->cambiarClientePend($_POST['cambiarPendiente']);
        $_SESSION['message'] = $res;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['registroUser'])) {
        $tipo = $_POST['tipo'];      
        if (!strcmp($tipo, 'Admin')) 
            $ret = $admin->alta_admin($_POST['cedula'], password_hash($_POST['up'], PASSWORD_DEFAULT));           
        else if (!strcmp($tipo, 'Cliente'))          
            $ret = $cliente->alta_cliente($_POST['nombre'], $_POST['cedula'], password_hash($_POST['up'], PASSWORD_DEFAULT), $_POST['mail'], $_POST['fnac'], "Aceptado", null);
            
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['listarUser'])) {     
        $users = $admin->listarUsuarios();
        $_SESSION['usuarios'] = json_encode($users);   
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['listarUserPendiente'])) {     
        $users = $admin->listarUsuariosPendientes();      
        $_SESSION['pendientes'] = json_encode($users);   
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['submitAltaCatalogo'])) {
        $ret = $catalogo -> alta_catalogo($_POST['categoria']);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['submitModificarCatalogo'])) {
        $ret = $catalogo -> modificar_catalogo($_POST['idCatalogo'], $_POST['Nnombre']);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['listarCategorias'])) {     
        $categorias = $catalogo->listar_catalogos();
        if ($categorias != null)        
            $_SESSION['categoriasAgregarProd'] = json_encode($categorias);   
        if (!isset($_POST['gestion']))
            header("Location: /TB-ROOT/view/agregarProducto.php");
        else header("Location: /TB-ROOT/index.php");
    }    

    if(isset($_POST['submitBajaProducto'])) {
        $ret = $producto -> baja_producto($_POST['idProducto']);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['submitBajaCatalogo'])) {
        $ret = $catalogo -> baja_catalogo($_POST['submitBajaCatalogo']);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    } 

    if(isset($_POST['submitAltaProducto'])) {
        if (!empty($_FILES["filecover"]["name"])) {
			$fileName = basename($_FILES["filecover"]["name"]); 
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 		
			$allowTypes = array('jpg','png','jpeg','gif'); 
			if (in_array($fileType, $allowTypes)) { 
				$image = $_FILES['filecover']['tmp_name']; 
				$imgContent = addslashes(file_get_contents($image));        
            } 
		} else {
            $filepath = '/TB-ROOT/view/resources/noimg.jpg';
            $image = imagecreatefromjpeg($filepath);               
            ob_start(); // Let's start output buffering.
                imagejpeg($image); //This will normally output the image, but because of ob_start(), it won't.
                $contents = ob_get_contents(); //Instead, output above is saved to $contents
            ob_end_clean(); //End the output buffer.
            $imgContent = base64_encode($contents);
        } 
        $ret = $producto -> alta_producto($_POST['nombreProd'], $_POST['descProd'], $_POST['precioProd'], $_POST['stockProd'], $_POST['catProd'], $imgContent);
        $_SESSION['message'] = $ret;
        unset($_SESSION['categoriasAgregarProd']);
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['submitBajaProducto'])) {
        $ret = $producto -> baja_producto($_POST['idProducto']);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }

    if(isset($_POST['submitModificarProducto'])) {
        if (!empty($_FILES["filecover"]["name"])) {
			$fileName = basename($_FILES["filecover"]["name"]); 
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 		
			$allowTypes = array('jpg','png','jpeg','gif'); 
			if (in_array($fileType, $allowTypes)) { 
				$image = $_FILES['filecover']['tmp_name']; 
				$imgContent = addslashes(file_get_contents($image));        
            } 
		} else {
            $imgContent = $_SESSION['imagenProd'];
        } 
        $ret = $producto -> modificar_producto($_POST['idProducto'], $_POST['Nnombre'], $_POST['Nprecio'], $_POST['Nstock'], $_POST['NCat'], $_POST['Ndesc'], $imgContent);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }
    
    if(isset($_POST['buscarProducto'])) {     
        $res = $producto->buscarProducto($_POST['producto']);   
        if (strcmp($res, "ok"))    
            header("Location: /TB-ROOT/index.php");
        else header("Location: /TB-ROOT/view/editarProducto.php");
    }
    
    if(isset($_POST['listarProductos'])) {     
        $productos = $admin->listarProductos();
        if ($productos != null)        
            $_SESSION['productos'] = json_encode($productos);   
        header("Location: /TB-ROOT/index.php");
    }  
    
    if(isset($_POST['listarCompras'])) {     
        $compras = $admin->listarCompras();
        if ($compras != null)        
            $_SESSION['compras'] = json_encode($compras);   
        header("Location: /TB-ROOT/index.php");
    }  

    if(isset($_POST['eliminarCompra'])) {
        $ret = $admin -> eliminarCompra($_POST['eliminarCompra']);
        $_SESSION['message'] = $ret;
        header("Location: /TB-ROOT/index.php");
    }


    
  
?>
