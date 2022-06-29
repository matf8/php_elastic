<?php
	require_once("/var/www/webroot/TB-ROOT/model/Catalogo.php");    
	$catalogo = new Catalogo();

	if(isset($_POST['listadoCatalogo'])) {
        this -> $catalogo -> listar_catalogos();
    }
?>