<?php
class Banner {
    private $id_campana;
    private $id_zona;
    private $image;
    private $descripcion;
    private $url;
    private $activo;
	private $juegos;

    public function __construct($id_campana, $id_zona, $image, $descripcion,$url, $activo,$juegos) {
        $this->id_campana = $id_campana;
        $this->id_zona = $id_zona;
        $this->image = $image;
        $this->descripcion = $descripcion;
        $this->url = $url;
        $this->activo = $activo;
        $this->juegos = $juegos;
    }
	
	 
	public function getId_campana() {
        return $this->id_campana;
    }

    public function setId_campana($id_campana) {
        $this->id_campana = $id_campana;
    }

    public function getId_zona() {
		
		if($this->id_zona==24){
			
			echo "text-align:center;padding-top:1em;padding-bottom:2em;'>";
		}
		else if($this->id_zona==4){
			
			echo "' class='banner_pral_izdo'>";
		}
		else if($this->id_zona==5){
			
			echo "' class='banner_pral_derecho'>";
		}
		else if($this->id_zona==27){
			
			echo "' class='banner_pral_izdo'>";
		}
		else if($this->id_zona==29){
			
			echo "' class='banner_pral_inferior'>";
		}
		else if($this->id_zona==30){
			
			echo "' class='banner_pral_superior'>";
		}
		else if($this->id_zona==36){
			
			echo "' class='banner_inferior_emergente' id='bannerInferiorEmergente' ><div style='text-align:right;'><button  id='btnCerrarBanner' onclick='cerrarBanner()'class='boton'>X</button><br></div>";
		}
		else{
			echo "'>";
		}
		
        
    }

    public function setId_zona($id_zona) {
        $this->id_zona = $id_zona;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }
	
	
	 public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }
	
	public function getJuegos() {
        return $this->juegos;
    }

    public function setJuegos($juegos) {
        $this->juegos = $juegos;
    }

    public function mostrarInformacion() {
        echo "ID: " . $this->id_zona . "<br>";
        echo "Imagen: " . $this->image . "<br>";
        echo "URL: " . $this->url . "<br>";
        echo "Activo: " . $this->activo . "<br>";
    }
}
?>