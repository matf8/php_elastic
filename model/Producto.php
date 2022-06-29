<?php
include_once("Catalogo.php");
class Producto extends Catalogo {   
    private $idProducto;
    private $nombre;
    private $imagen;
    private $precio;
    private $descripcion;
    private $comentarios;
    private $dbh;

    public function __construct(){
        try {
		    $this->dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
	}

    public function listar_productos() {
        try {
            $sqlSELECT = "SELECT * FROM productos";
            $prods = array(); 
            $res = $this->dbh->query($sqlSELECT);        
		    foreach ($res as $c) 
                $prods[]=$c;  
		    return $prods;
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }
    }

    public function listarProductosPorCategoria($categoria) {
        try {
            $sqlSELECT = "SELECT * FROM productos WHERE categoria='$categoria'";        
            $res = $this->dbh->query($sqlSELECT);
            $prodsByCat = array();       
            foreach ($res as $c) 
                $prodsByCat[]=$c;  
            return $prodsByCat;
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }
    }

    public function alta_producto($nombreProducto, $desc, $precio, $stock, $cat, $imagenProducto) {
		$sqlINSERT = "INSERT INTO productos (nombre, precio, descripcion, imagen, categoria, stock)
                      VALUES ('$nombreProducto','$precio','$desc','$imagenProducto','$cat','$stock')";
        try {
		    $this->dbh->query($sqlINSERT);
            return "Producto " . $nombreProducto . " agregado con éxito!!";
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }
	}

    public function buscarProducto($p) {     
        $q = "select categoria from catalogos";
        $res = $this->dbh->query($q);
        $categorias = array();
        foreach ($res as $nc) 
            $categorias[]=$nc;
        $_SESSION['ListCategorias'] = json_encode($categorias);  
     
		$q = "select * from productos where idProducto='$p' or nombre='$p';";
        $res = $this->dbh->query($q);
		$producto = array();  
		foreach ($res as $c) 
            $producto[]=$c;	
        if (count($producto) == 1) {  
			$_SESSION["encontradoProd"] = true;
			$_SESSION['idProd'] = $producto[0]['idProducto'];			
			$_SESSION['nombreProd'] = $producto[0]['nombre'];  
			$_SESSION['precio'] = $producto[0]['precio']; 
            if ($producto[0]['imagen'] == '') {
                $filepath = '../view/resources/noimg.jpg';
                $image = imagecreatefromjpeg($filepath);               
                ob_start(); // Let's start output buffering.
                    imagejpeg($image); //This will normally output the image, but because of ob_start(), it won't.
                    $contents = ob_get_contents(); //Instead, output above is saved to $contents
                ob_end_clean(); //End the output buffer.
                $_SESSION['imagenProd'] = base64_encode($contents);
            }             
            else {                                 
                if (!$this->img64($producto[0]['imagen'])) {         
                    $_SESSION['imagenProd'] = base64_encode($producto[0]['imagen']);  
                } else { 
                    $_SESSION['imagenProd'] = $producto[0]['imagen'];
                }
            }
			$_SESSION['stock'] = $producto[0]['stock'];  
			$_SESSION['categoria'] = $producto[0]['categoria'];
			$_SESSION['descripcion'] = $producto[0]['descripcion'];
			$_SESSION['message'] = 'Producto encontrado';     
			return "ok"; 
		} else $_SESSION['message'] = 'Producto no existe';      
		return "no";       
	}

    private function img64($data) {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))  {         
            return true;
        } else {         
            return false;     
        }
    }

    public function baja_Producto($id) {
		try {			
			$sqlDELETE = "DELETE FROM productos WHERE idProducto='$id'";			
			$this->dbh->query($sqlDELETE);
			return "El producto se borró correctamente.";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}		
	}

    public function modificar_producto($id, $nombre, $precio, $stock, $cat, $desc, $img) {
		try {	
			$sqlUPDATE = "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$desc', imagen='$img', categoria='$cat', stock='$stock' WHERE idProducto='$id'";			
			$this->dbh->query($sqlUPDATE);		
            return "Producto " . $nombre . " modificado con éxito!!";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}
	}

    public function agregarComentario($idProducto, $comentarioProducto) {
        $sqlUPDATE = "";//agrego el comentario al producto
        try {
		    $this->dbh->query($sqlUPDATE);
        } catch (Exception $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
        return "Comentario agregado al producto con id: " . $idProducto . "!!";
    }

    public function decrementarStockProducto($nombreProductoAg, $cant) {
        try {	
            $res = $this->dbh->query("SELECT stock FROM productos WHERE nombre='$nombreProductoAg'");	           
            $stock = array();
            foreach ($res as $nc) 
                $stock[]=$nc;
            $stockProd = $stock[0]['stock'];                      
            if ($stockProd - $cant >= 0) {
			    $sqlUPDATE = "UPDATE Productos SET stock = stock - '$cant' WHERE nombre='$nombreProductoAg'";			
			    $this->dbh->query($sqlUPDATE);		
                return "Stock " . $nombre . " modificado con éxito!!";
            } else return "negativo";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}    
    }

    public function incrementarStockProducto($nombreProductoAg, $cant) {
        try {	
            $res = $this->dbh->query("SELECT stock FROM productos WHERE nombre='$nombreProductoAg'");	           
            $stock = array();
            foreach ($res as $nc) 
                $stock[]=$nc;
            if (count($stock) == 1)
			    $sqlUPDATE = "UPDATE productos SET stock = stock + '$cant' WHERE nombre='$nombreProductoAg'";			
			    $this->dbh->query($sqlUPDATE);		
                return "Stock " . $nombre . " modificado con éxito!!";           
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}    
    }

    public function listarComentariosProducto($producto) {
        try {
            $sqlSELECT = "SELECT c.idComentario, c.texto, c.valoracion, c.producto, c.usuario, cl.nombre, cl.imagen FROM comentarios c JOIN clientes cl ON c.usuario = cl.correo WHERE producto='$producto'";        
            $res = $this->dbh->query($sqlSELECT);
            $comentarios = array();       
            foreach ($res as $c) 
                $comentarios[]=$c;  
            return $comentarios;
        } catch (Exception $e) {
           echo 'Falló la conexión: ' . $e->getMessage();
           return null;
        }
    }
}
?>
