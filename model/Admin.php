<?php
include_once("Usuario.php");
class Admin extends Usuario {
    private $dbh;

	public function __construct(){
		$this->dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
	}

	public function alta_admin($cedulaAdmin, $passwordAdmin) {
		$sqlINSERT = "INSERT INTO administradores (ci, password)
					  VALUES ('$cedulaAdmin','$passwordAdmin')";
	   try {		
		    $this->dbh->query($sqlINSERT);	
			return "Administrador agregado con éxito!!";	
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }        
	}

	public function listarUsuarios(){
		$sql = "SELECT idUsuario, ci, estado FROM clientes
				UNION 
				SELECT idUsuario, ci, null FROM administradores 
				ORDER BY idUsuario";
        $users = array(); 
        foreach ($this->dbh->query($sql) as $res) 
            $users[]=$res;  
		return $users;            
	}

	public function listarUsuariosPendientes() { 
		$sql = "SELECT idUsuario, ci, estado FROM clientes";			
        $users = array(); 
		$pendientes = array();
        foreach ($this->dbh->query($sql) as $res) 
            $users[]=$res;  
		for ($i=0; $i<count($users); $i++) 
			if ($users[$i]['estado'] == 'Pendiente') {				
				array_push($pendientes, $users[$i]);				
			}
		return $pendientes;            
	}

	public function cambiarClientePend($id){
		$sqlUPDATE = "UPDATE clientes SET estado='Aceptado' WHERE idUsuario='$id'";
		try {
			$this->dbh->query($sqlUPDATE);
			return "El usuario con id: " . $id . " fue Aceptado correctamente.";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}
	}

	public function editarUsuario($idUsuario, $nombreUsuario, $passUsuario, $cedulaUsuario, $correoUsuario, $tipo, $fNac) {
		try {
			if($tipo == "Cliente") {
				$sqlUPDATE = "UPDATE clientes SET nombre='$nombreUsuario', ci='$cedulaUsuario', password='$passUsuario', correo='$correoUsuario', fNac='$fNac' WHERE idUsuario='$idUsuario'";
			} else if($tipo == "Admin") {
				$sqlUPDATE = "UPDATE administradores SET ci='$cedulaUsuario', password='$passUsuario' WHERE idUsuario = '$idUsuario'";
			}
			$this->dbh->query($sqlUPDATE);
			return "El usuario con cedula: " . $cedulaUsuario . " fue modificado con éxito!!";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}
	}

	public function buscarUsuarios($usuario) {
		$q = "select * from administradores where ci='$usuario';";
        $res = $this->dbh->query($q);
		$user = array();  
		foreach ($res as $c) 
            $user[]=$c;	
        if (count($user) == 1) {  
			$_SESSION["encontrado"] = true;
			$_SESSION["tipoEditar"] = "Admin";
			$_SESSION['id'] = $user[0]['idUsuario'];			
			$_SESSION['ci'] = $user[0]['ci'];  
			$_SESSION['fnac'] = "";
			$_SESSION['correo'] = "";
			$_SESSION['nombre'] = "";
			$_SESSION['message'] = 'Usuario encontrado';     
			return "ok";        
        } else { // no es admin, puede ser cliente
            $q = "select * from clientes where ci='$usuario' or correo='$usuario' or idUsuario='$usuario';";
			$res = $this->dbh->query($q);
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
				if (!$this->img64($img)) {     
					$_SESSION['img'] = base64_encode($img); 
				} else $_SESSION['img'] = $user[0]['imagen'];
				$_SESSION["tipoEditar"] = "Cliente";
                $_SESSION['message'] = 'Usuario encontrado';  
				return "ok";
            } else {
                $_SESSION['message'] = 'Datos incorrectos';   
            }  
		}  
		return "no";       
	}

	private function img64($data) {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))  {   
            return true;
        } else {         
            return false;     
        }
    }

	public function borrarUsuario($id, $tipo) {
		try {
			if($tipo == "Cliente") {
				$sqlDELETE = "DELETE FROM clientes WHERE idUsuario='$id'";
			} else if($tipo == "Admin") {
				$sqlDELETE = "DELETE FROM administradores WHERE idUsuario='$id'";
			}
			$this->dbh->query($sqlDELETE);
			$_SESSION['message'] = "El usuario se borro correctamente.";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}		
	}

	public function listarProductos(){
		$sql = "SELECT idProducto, nombre, precio, categoria, stock FROM productos";				
        $productos = array(); 
        foreach ($this->dbh->query($sql) as $res) 
            $productos[]=$res; 
		return $productos;            
	}

	public function listarCompras(){			
        $compras = array(); 
		$res = $this->dbh->query("SELECT * FROM compras");
        foreach ($res as $c) 
            $compras[]=$c; 
		return $compras;            
	}

	public function eliminarCompra($id) {
		try {			
			$this->dbh->query("DELETE FROM compras WHERE idCompra='$id'");
			return "Compra borrada correctamente.";
		} catch (Exception $e) {
			return 'Falló la conexión: ' . $e->getMessage();
		}		
	}

	public function buscarCatalogo($idC) {	
        $res = $this->dbh->query("SELECT * FROM catalogos WHERE idCatalogo='$idC'");
		$catalogo = array();  
		foreach ($res as $c) 
            $catalogo[]=$c;	
        if (count($catalogo) == 1)   
			return $catalogo[0];
		else return null;
	} 

}
?>
