<?php
include_once("Usuario.php");
class Cliente extends Usuario {   
    private $correo;
    private $fNac;
    private $img;
	private $estado; // Pendiente - Aceptado
	private $dbh;

  	public function __construct(){
		try {		
		    $this->dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
	}

 	public function listar_clientes() {
		$sqlSELECT = "SELECT * FROM clientes;";
		try {
			$clientes = array();
            foreach ($this->dbh->query($sqlSELECT) as $row)
                $clientes[]=$row;
            return $clientes;
        } catch (Exception $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
	}

	public function alta_cliente($nombreCliente, $cedulaCliente, $passwordCliente, $correoCliente, $fNacCliente, $estadoCliente, $imagenCliente) {
		$sqlINSERT = "INSERT INTO clientes (nombre, ci, password, correo, fNac, imagen, estado)
					  VALUES ('$nombreCliente','$cedulaCliente','$passwordCliente','$correoCliente','$fNacCliente','$imagenCliente','$estadoCliente')";
	   try {		
		    $this->dbh->query($sqlINSERT);	
			return "Cliente " . $nombreCliente . " agregado con éxito!!";	
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }        
	}

  	public function baja_cliente($idCliente) {
		$sqlDELETE = "DELETE FROM clientes WHERE idCliente= " . $idCliente . ";";
		try{
			$this->dbh->query($sqlDELETE);
		} catch (Exception $e) {
			echo 'Falló la conexión: ' . $e->getMessage();
		}
		return "El cliente con id: " . $idCliente . " fue eliminado con éxito!!";
	}

	public function editarUsuario($idUsuario, $nombreUsuario, $correoUsuario, $img) {
		try {			
			$pass = $_SESSION['pass'];
			$ci = $_SESSION['ci']; 
			$sqlUPDATE = "UPDATE clientes SET nombre='$nombreUsuario', ci='$ci', password='$pass', correo='$correoUsuario', imagen='$img' WHERE idUsuario='$idUsuario'";			
			$this->dbh->query($sqlUPDATE);
			// update datos en sesion			
			$this->buscarCliente($idUsuario);
			return "Datos modificados";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}
	}

	public function buscarCliente($usuario) {
			$res = $this->dbh->query("SELECT * FROM clientes WHERE idUsuario='$usuario'");
			$user = array();  
			foreach ($res as $c) 
				$user[]=$c;		
			if (count($user) == 1) {
				$_SESSION["encontrado"] = true;
				$_SESSION['id'] = $user[0]['idUsuario'];
                $_SESSION['nombre'] = $user[0]['nombre'];  
                $_SESSION['ci'] = $user[0]['ci'];  
				$_SESSION['correo'] = $user[0]['correo'];  
				$_SESSION['fnac'] = $user[0]['fNac'];  
				$img = $user[0]['imagen'];
				if (!$this->img64($img))     
					$_SESSION['img'] = base64_encode($img); 
				else $_SESSION['img'] = $img;				
				$_SESSION["tipoEditar"] = "Cliente";
                $_SESSION['message'] = 'Usuario encontrado';  
				return "ok";
            } else {
                $_SESSION['message'] = 'Datos incorrectos';   
            }  
	}

	private function img64($data) {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))  {   
            return true;
        } else {         
            return false;     
        }
    }

	public function iniciarCarrito($usuario) {
		try {
			$sqlSELECT = "SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'";		
			$res = $this->dbh->query($sqlSELECT);
			$carrito = array();  
			foreach ($res as $c) 
					$carrito[]=$c;	
			if (count($carrito) == 1) {
				return $carrito[0]['idCarrito'];
			} else {				
				$sqlINSERT = "insert into carritos (usuario, estado) values ('$usuario', 'Pendiente')";	
				$res = $this->dbh->query($sqlINSERT);
				return $this->dbh->lastInsertId();
			}			
		} catch (Expcetion $e) {
			return $e->getMessage();
		}
	}

	public function agregarProductoCarrito($idCarrito, $nombreProducto, $cantidad) {
		try {
			$sqlSELECT = "select cantidad from productos_carrito where producto = '$nombreProducto' and carrito = '$idCarrito'";
			$res = $this->dbh->query($sqlSELECT);
			$producto = array();  
			foreach ($res as $c) 
					$producto[]=$c;	
			if (count($producto) > 0) {											
				if ($producto[0]['cantidad'] >= 1) {
						$this->dbh->query("UPDATE productos_carrito SET cantidad = cantidad + '$cantidad' WHERE carrito = '$idCarrito' and producto = '$nombreProducto'");			

						return "Incremento correctamente";
				}
			} else {
				if ($cantidad > 0)
	 				$sqlINSERT = "INSERT into productos_carrito (carrito, producto, cantidad) values ('$idCarrito', '$nombreProducto', $cantidad)";			
		    	else return "Cantidad debe ser positiva";
				$this->dbh->query($sqlINSERT);
				return "Producto " . $nombreProducto . " agregado al carrito correctamente!!";
			}
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function cantidadCarrito($usuario) {
		$sqlSELECT = "SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'";		
		$res = $this->dbh->query($sqlSELECT);
		$carrito = array();  
		foreach ($res as $c) 
				$carrito[]=$c;	
		if (count($carrito) == 1) 
			$id = $carrito[0]['idCarrito'];	

		if (isset($id)) {
			$sqlSELECT = "select count(*) from productos_carrito where carrito='$id'";
			$res = $this->dbh->query($sqlSELECT);
			$producto = array();  
			foreach ($res as $c) 
				$producto[]=$c;	
			$cant =	$producto[0]['count(*)'];
			return $cant;
		}
	}

	public function listar_productosCarrito($usuario) {
		$sqlSELECT = "SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'";		
		$res = $this->dbh->query($sqlSELECT);
		$carrito = array();  
		$productos = array();
		foreach ($res as $c) 
				$carrito[]=$c;	
		if (count($carrito) == 1) {
			$id = $carrito[0]['idCarrito'];			
			$sqlSELECT = "SELECT nombre, precio, descripcion, imagen, stock, cantidad FROM productos_carrito p JOIN productos pr on p.producto = pr.nombre where carrito = '$id';";
			$res = $this->dbh->query($sqlSELECT);
			$productos = array();  
			foreach ($res as $c) 
				$productos[]=$c;	
			return $productos;			
		} else return "Carrito no existe";		
	}

	public function quitarProductoCarrito($usuario, $nombreProducto) {
		try {
			$sqlSELECT = "SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'";		
			$res = $this->dbh->query($sqlSELECT);
			$carrito = array();  
			foreach ($res as $c) 
				$carrito[]=$c;	
			if (count($carrito) == 1) 
				$id = $carrito[0]['idCarrito'];	
			if (isset($id))	{					
				$res = $this->dbh->query("SELECT cantidad FROM productos_carrito WHERE carrito = '$id' and producto = '$nombreProducto'");
				$producto = array();  
				foreach ($res as $c) 
					$producto[]=$c;	
				if ($producto[0]['cantidad'] > 1) {
					$this->dbh->query("UPDATE productos_carrito SET cantidad = cantidad - 1 WHERE carrito = '$id' and producto = '$nombreProducto'");
					$this->dbh->query("UPDATE productos SET stock = stock + 1 WHERE nombre = '$nombreProducto'");
					return "Decremento correctamente";
				} else {				
		    		$this->dbh->query("DELETE FROM productos_carrito where carrito = '$id' and producto = '$nombreProducto'");
					$this->dbh->query("UPDATE productos SET stock = stock + 1 WHERE nombre = '$nombreProducto'");
					return "Producto " . $nombreProducto . " borrado del carrito correctamente";
				}	
			}		
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function eliminarProductoCarrito($usuario, $nombreProducto) {
		try {					
			$res = $this->dbh->query("SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'");
			$carrito = array();  
			foreach ($res as $c) 
				$carrito[]=$c;	
			if (count($carrito) == 1) 
				$id = $carrito[0]['idCarrito'];	
			if (isset($id))	{										
				$this->dbh->query("DELETE FROM productos_carrito where carrito = '$id' and producto = '$nombreProducto'");
				return "Producto " . $nombreProducto . " borrado del carrito correctamente";
			}			
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function checkCantProductos($usuario) {
		$res = $this->listar_productosCarrito($usuario);
		if (count($res) == 0)
			$this->dbh->query("DELETE FROM carritos WHERE usuario = '$usuario'");		
	}

	public function realizarCompra($metodo, $usuario, $total) {
		try {
			$sqlSELECT = "SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'";		
			$res = $this->dbh->query($sqlSELECT);
			$carrito = array();  
			foreach ($res as $c) 
				$carrito[]=$c;	
			if (count($carrito) == 1) 
				$id = $carrito[0]['idCarrito'];	
			if (isset($id))	{				
				$sqlINSERT = "INSERT INTO compras (usuario, fecha, metodo, total) values ('$usuario', NOW(), '$metodo', '$total')";
				$res = $this->dbh->query($sqlINSERT);
				$id = $this->dbh->lastInsertId();
				$productos = $this->listar_productosCarrito($usuario);
				foreach($productos as $p) {
					$nombre = $p['nombre'];
					$cant = $p['cantidad'];
					$sqlINSERT = "INSERT INTO productos_compra (compra, producto, unidades) values ('$id', '$nombre', '$cant')";
					$this->dbh->query($sqlINSERT);
				}
				return "ok";
			} else return "Imposible realizar compra";		
		} catch (Exception $e){
			return $e->getMessage();
		}
	}

	public function cambiarCarritoCompletado($usuario) {
		try {
			$sqlSELECT = "SELECT idCarrito FROM carritos WHERE usuario='$usuario' and estado='Pendiente'";		
			$res = $this->dbh->query($sqlSELECT);
			$carrito = array();  
			foreach ($res as $c) 
				$carrito[]=$c;	
			if (count($carrito) == 1) {
				$id = $carrito[0]['idCarrito'];	
				$this->dbh->query("UPDATE carritos SET estado='Aceptado' WHERE idCarrito = '$id'");
				$this->dbh->query("DELETE FROM productos_carrito WHERE carrito = '$id'");
				return "ok";
			}
		} catch (Exception $e){
			return $e->getMessage();
		}
	}

	public function cerrarCarritoPorCancelar($usuario) {
		$this->dbh->query("DELETE FROM carritos WHERE usuario = '$usuario' and estado = 'Pendiente'");
		return "Compra cancelada.";
	}


	public function listarComprasUsuario($usuario) {				
			$compras = array(); 
			$res = $this->dbh->query("SELECT c.idCompra, c.usuario, p.producto, c.metodo, c.total, c.fecha FROM compras c JOIN productos_compra p ON c.idCompra = p.compra WHERE usuario = '$usuario'");
			foreach ($res as $c) 
				$compras[]=$c; 
			if (count($compras) > 0)
				return $compras;            
			else return null;
	}

	public function listarProductosUsuario($idCompra) {				
		$productos = array(); 
		$res = $this->dbh->query("SELECT producto FROM productos_compra WHERE compra = '$idCompra'");
		foreach ($res as $c) 
			$productos[]=$c; 
		if (count($productos) > 0)
			return $productos;            
		else return null;
	}

	public function comentarProducto($producto, $comentario, $valoracion, $usuario) {	
		try {
			$res = $this->dbh->query("INSERT INTO comentarios (texto, valoracion, usuario, producto) VALUES ('$comentario', '$valoracion', '$usuario', '$producto')");
			return "Comentario agregado, muchas gracias!!";
		} catch (Exception $e){
			return $e->getMessage();
		}
	}

	public function checkComentario($producto, $usuario) {	
		try {
			$res = $this->dbh->query("SELECT * FROM comentarios WHERE producto='$producto' and usuario='$usuario'");
			$comentarios = array(); 
			foreach ($res as $c) 
				$comentarios[]=$c; 
			if (count($comentarios) > 0)
				return true;
			else return false;
		} catch (Exception $e){
			return $e->getMessage();
		}
	}	
}

?>




