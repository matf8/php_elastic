<?php
class Catalogo {   
    private $idCatalogo;
    private $categoria;  
    private $dbh; 

    public function __construct(){
		try {
		    $this->dbh = new PDO('mysql:host=node2692-tecno-bay.web.elasticloud.uy;dbname=tecnobaydb', "php", "tecnoinfphp");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
	}

    public function listar_catalogos() {
        $sqlSELECT = "SELECT * FROM catalogos ORDER BY idCatalogo";
        try {
            $cats = array();
            foreach ($this->dbh->query($sqlSELECT) as $row)
                $cats[]=$row;
            return $cats;
        } catch (Exception $e) {
           return 'Falló la conexión: ' . $e->getMessage();
        }
    }

    public function alta_catalogo($categoriaCatalogo) {
		$sqlINSERT = "INSERT INTO catalogos (categoria) VALUES ('$categoriaCatalogo');";
        try {
		    $this->dbh->query($sqlINSERT);
            return "Categoría de catálogo " . $categoriaCatalogo . " creado con éxito!!";
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }        
	}

    public function modificar_catalogo($idCatalogo, $categoriaCatalogo) {
        try {
            if($categoriaCatalogo == null) 
                return "faltan campos obligatorios";
            else {        
                $sqlUPDATE = "UPDATE catalogos SET categoria='$categoriaCatalogo' WHERE idCatalogo='$idCatalogo'";
                $this->dbh->query($sqlUPDATE);
                return "El catalogo con id: " . $idCatalogo . " fue modificado con éxito!!";

            }
        } catch (Exception $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
	}

	public function baja_catalogo($idCatalogo) {       
        try {
		    $sqlDELETE = "DELETE FROM catalogos WHERE idCatalogo='$idCatalogo'";        
            $this->dbh->query($sqlDELETE);
            return "Catalogo con id: " . $idCatalogo . " fue eliminado con éxito!!";
        } catch (Exception $e) {
            return 'Falló la conexión: ' . $e->getMessage();
        }        
	}
}
?>