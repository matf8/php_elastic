<?php	
	ob_start();
	require_once("/var/www/webroot/TB-ROOT/model/Usuario.php");	
	require_once("/var/www/webroot/TB-ROOT/view/header.php");

	if (isset($_POST['iniciarS'])) {		
		iniciarSesion($_POST['id'], $_POST['pass']);
	}

	if (isset($_POST['registro'])) {			
		if (!empty($_FILES["filecover"]["name"])) {
			$fileName = basename($_FILES["filecover"]["name"]); 
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 		
			$allowTypes = array('jpg','png','jpeg','gif'); 
			if (in_array($fileType, $allowTypes)) { 
				$image = $_FILES['filecover']['tmp_name']; 
				$imgContent = addslashes(file_get_contents($image)); 				
			} 
		} else {
			$filepath = '/var/www/webroot/TB-ROOT/view/resources/default.jpg';
            $image = imagecreatefromjpeg($filepath);               
            ob_start(); // Let's start output buffering.
                imagejpeg($image); //This will normally output the image, but because of ob_start(), it won't.
                $contents = ob_get_contents(); //Instead, output above is saved to $contents
            ob_end_clean(); //End the output buffer.
            $imgContent = base64_encode($contents);
		}
		registrar($_POST['cedula'], $_POST['nombre'], password_hash($_POST['up'], PASSWORD_DEFAULT), $_POST['mail'], $_POST['fnac'], "Pendiente", $imgContent);		
	}

  	if (isset($_POST['cerrarSesion'])) {
		cerrarSesion();	
	}

	function cerrarSesion() {
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		session_destroy();
		header("Location: /TB-ROOT/index.php");
		die;
	}

	function iniciarSesion($ci, $pass) {
        $dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
        $q = "select * from administradores where ci='$ci';";
        $res = $dbh->query($q);
		$user = array();  
		foreach ($res as $c) 
                $user[]=$c;	
        if (count($user) == 1) {                          
            $passDB = $user[0]['password'];
         	if (password_verify($pass, $passDB)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['tipo'] = "admin";
                $_SESSION['username'] = "admin"; 
                $_SESSION['message'] = 'Sesion iniciada.';  				
            } else $_SESSION['message'] = 'Contraseña incorrecta';
        } else { // no es admin, puede ser cliente
            $q = "select * from clientes where ci='$ci' or correo='$ci';";
			$res = $dbh->query($q);
			$user = array();  
			foreach ($res as $c) 
					$user[]=$c;		
			if (count($user) == 1) {
                $passDB = $user[0]['password'];	
				$estado = $user[0]['estado'];					
                if (password_verify($pass, $passDB)) {
					if ($estado == 'Aceptado') {
						$_SESSION['loggedin'] = true;
						$_SESSION['tipo'] = "cliente";
						$_SESSION['idCliente'] = $user[0]['idUsuario'];  
						$_SESSION['correo'] = $user[0]['correo'];  
						$_SESSION['username'] = $user[0]['nombre'];  
						$_SESSION['pass'] = $user[0]['password']; 
						$img = $user[0]['imagen']; 						
						if (!img64($img)) {         
							$_SESSION['img'] = base64_encode($img);  
						} else { 
							$_SESSION['img'] = $img;
						}
						$_SESSION['message'] = 'Sesion iniciada.';	
					} else $_SESSION['message'] = 'Lo sentimos, su cuenta está pendiente de activación por la administración.'; 	
                } else $_SESSION['message'] = 'Contraseña incorrecta';       
            } else $_SESSION['message'] = 'Datos incorrectos';               
        }	
		header("Location: /TB-ROOT/index.php");			
    }

	function img64($data) {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))  {  		   
            return true;
        } else {         
            return false;     
        }
    }

	function registrar($cedula, $nombre, $pass, $mail, $fnac, $estado, $img){
		try {
			$dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
			$q = "INSERT INTO clientes (nombre, ci, password, correo, fNac, estado, imagen)
				VALUES ('$nombre', '$cedula', '$pass', '$mail', '$fnac', '$estado', '$img')";
			$dbh->query($q);
			$_SESSION['message'] = 'Su cuenta será activada por los administradores en las próximas 48 horas. Bienvenido a Tecno-Bay - Conectando el futuro';		
		} catch (Exception $e) {
			$_SESSION['message'] = $e;
			
		}
		header("Location: /TB-ROOT/index.php");
	}
	
	if (isset($_POST['nuevaPass'])) {
		try {
			$new = $_POST['up'];
			$old = $_POST['old'];
			$tipo = $_SESSION['tipo'];
			$dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
			if ($tipo == "admin") {
				$ci = $_SESSION['username'];
				$res = $dbh->query("SELECT * FROM administradores WHERE ci='$ci'");				
				$user = array();  
				foreach ($res as $c) 
               		$user[]=$c;	
        		if (count($user) == 1) {                         
            		$passDB = $user[0]['password'];					
           			if (password_verify($old, $passDB)) {									
						$new = password_hash($new, PASSWORD_DEFAULT);
						$dbh->query("UPDATE administradores SET password = '$new' where ci='$ci'");				
						$_SESSION['message'] = "Contraseña cambiada correctamente";
					} else $_SESSION['message'] = "Contraseña incorrecta";
				} 
			} else if ($tipo == "cliente") {				
				$correo = $_SESSION['correo'];
				$res = $dbh->query("SELECT * FROM clientes WHERE correo='$correo'");				
				$user = array();  
				foreach ($res as $c) 
               		$user[]=$c;	
        		if (count($user) == 1) {                         
            		$passDB = $user[0]['password'];
           			if (password_verify($old, $passDB)) {
						$new = password_hash($new, PASSWORD_DEFAULT);
						$dbh->query("UPDATE clientes SET password = '$new' where correo = '$correo'");				
						$_SESSION['message'] = "Contraseña cambiada correctamente";				
					} else $_SESSION['message'] = "Contraseña incorrecta";
				} 
			}	
		} catch (Exception $e){
			$_SESSION['message'] = $e->getMessage();
		}	
		header("Location: /TB-ROOT/index.php");
	}
 

?>
      
       
