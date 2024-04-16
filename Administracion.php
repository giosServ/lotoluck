<?php
class Administracion {
    private $id_administracion;
    private $activo;
    private $descripcion_interna;
    private $status;
    private $veces_activo;
    private $veces_premio;
    private $fecha_alta;
    private $familia;
    private $nombre;
    private $nombre_actv;
    private $slogan;
    private $slogan_actv;
    private $envia;
    private $titular;
    private $nif_cif;
    private $banco;
    private $cuenta_bancaria;
    private $desp_receptor_num;
    private $desp_operador_num;
    private $admin_num;
    private $admin_num_actv;
    private $direccion;
    private $direccion_actv;
    private $direccion2;
    private $direccion2_actv;
    private $lat;
    private $lon;
    private $poblacion;
    private $poblacion_actv;
    private $provincia;
    private $provincia_actv;
    private $cod_pos;
    private $cod_pos_actv;
    private $telefono;
    private $telefono_actv;
    private $telefono2;
    private $telefono2_actv;
    private $fax;
    private $fax_actv;
    private $email;
    private $email_actv;
    private $web;
    private $web_actv;
    private $web_externa;
    private $web_externa_actv;
    private $web_ext_titulo;
    private $web_es_externa;
    private $agente_comercial;
    private $contactado;
    private $fecha_contacto;
    private $interesado;
    private $cliente;
    private $rellamar;
    private $logo_file_path;
    private $imagen_file_path;
    private $fecha_inicio;
    private $fecha_fin;
    private $comentarios;
    private $recibir_newsletter;
    private $quiere_vip;
    private $quiere_web_lotoluck;
    private $pagina_compradores;
    private $creado_por;
    private $fecha_creacion;
    private $metadata;

	
	public function getIdAdministracion() {
        return $this->id_administracion;
    }

    public function setIdAdministracion($id_administracion) {
        $this->id_administracion = $id_administracion;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function getDescripcionInterna() {
        return $this->descripcion_interna;
    }

    public function setDescripcionInterna($descripcion_interna) {
        $this->descripcion_interna = $descripcion_interna;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getVecesActivo() {
        return $this->veces_activo;
    }

    public function setVecesActivo($veces_activo) {
        $this->veces_activo = $veces_activo;
    }

    public function getVecesPremio() {
        return $this->veces_premio;
    }

    public function setVecesPremio($veces_premio) {
        $this->veces_premio = $veces_premio;
    }

    public function getFechaAlta() {
        return $this->fecha_alta;
    }

    public function setFechaAlta($fecha_alta) {
        $this->fecha_alta = $fecha_alta;
    }

    public function getFamilia() {
        return $this->familia;
    }

    public function setFamilia($familia) {
        $this->familia = $familia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombreActv() {
        return $this->nombre_actv;
    }

    public function setNombreActv($nombre_actv) {
        $this->nombre_actv = $nombre_actv;
    }

    public function getSlogan() {
        return $this->slogan;
    }

    public function setSlogan($slogan) {
        $this->slogan = $slogan;
    }

    public function getSloganActv() {
        return $this->slogan_actv;
    }

    public function setSloganActv($slogan_actv) {
        $this->slogan_actv = $slogan_actv;
    }

    public function getEnvia() {
        return $this->envia;
    }

    public function setEnvia($envia) {
        $this->envia = $envia;
    }

    public function getTitular() {
        return $this->titular;
    }

    public function setTitular($titular) {
        $this->titular = $titular;
    }

    public function getNifCif() {
        return $this->nif_cif;
    }

    public function setNifCif($nif_cif) {
        $this->nif_cif = $nif_cif;
    }
    public function getBanco() {
        return $this->banco;
    }

    public function setBanco($banco) {
        $this->banco = $banco;
    }

    public function getCuentaBancaria() {
        return $this->cuenta_bancaria;
    }

    public function setCuentaBancaria($cuenta_bancaria) {
        $this->cuenta_bancaria = $cuenta_bancaria;
    }

    public function getDespReceptorNum() {
        return $this->desp_receptor_num;
    }

    public function setDespReceptorNum($desp_receptor_num) {
        $this->desp_receptor_num = $desp_receptor_num;
    }

    public function getDespOperadorNum() {
        return $this->desp_operador_num;
    }

    public function setDespOperadorNum($desp_operador_num) {
        $this->desp_operador_num = $desp_operador_num;
    }

    public function getAdminNum() {
        return $this->admin_num;
    }

    public function setAdminNum($admin_num) {
        $this->admin_num = $admin_num;
    }

    public function getAdminNumActv() {
        return $this->admin_num_actv;
    }

    public function setAdminNumActv($admin_num_actv) {
        $this->admin_num_actv = $admin_num_actv;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getDireccionActv() {
        return $this->direccion_actv;
    }

    public function setDireccionActv($direccion_actv) {
        $this->direccion_actv = $direccion_actv;
    }

    public function getDireccion2() {
        return $this->direccion2;
    }

    public function setDireccion2($direccion2) {
        $this->direccion2 = $direccion2;
    }

    public function getDireccion2Actv() {
        return $this->direccion2_actv;
    }

    public function setDireccion2Actv($direccion2_actv) {
        $this->direccion2_actv = $direccion2_actv;
    }

    public function getLat() {
        return $this->lat;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function getLon() {
        return $this->lon;
    }

    public function setLon($lon) {
        $this->lon = $lon;
    }

    public function getPoblacion() {
        return $this->poblacion;
    }

    public function setPoblacion($poblacion) {
        $this->poblacion = $poblacion;
    }

    public function getPoblacionActv() {
        return $this->poblacion_actv;
    }

    public function setPoblacionActv($poblacion_actv) {
        $this->poblacion_actv = $poblacion_actv;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    public function getProvinciaActv() {
        return $this->provincia_actv;
    }

    public function setProvinciaActv($provincia_actv) {
        $this->provincia_actv = $provincia_actv;
    }

    public function getCodPos() {
        return $this->cod_pos;
    }

    public function setCodPos($cod_pos) {
        $this->cod_pos = $cod_pos;
    }

    public function getCodPosActv() {
        return $this->cod_pos_actv;
    }

    public function setCodPosActv($cod_pos_actv) {
        $this->cod_pos_actv = $cod_pos_actv;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getTelefonoActv() {
        return $this->telefono_actv;
    }

    public function setTelefonoActv($telefono_actv) {
        $this->telefono_actv = $telefono_actv;
    }

    public function getTelefono2() {
        return $this->telefono2;
    }

    public function setTelefono2($telefono2) {
        $this->telefono2 = $telefono2;
    }

    public function getTelefono2Actv() {
        return $this->telefono2_actv;
    }

    public function setTelefono2Actv($telefono2_actv) {
        $this->telefono2_actv = $telefono2_actv;
    }

    public function getFax() {
        return $this->fax;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function getFaxActv() {
        return $this->fax_actv;
    }

    public function setFaxActv($fax_actv) {
        $this->fax_actv = $fax_actv;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmailActv() {
        return $this->email_actv;
    }

    public function setEmailActv($email_actv) {
        $this->email_actv = $email_actv;
    }

    public function getWeb() {
        return $this->web;
    }

    public function setWeb($web) {
        $this->web = $web;
    }

    public function getWebActv() {
        return $this->web_actv;
    }

    public function setWebActv($web_actv) {
        $this->web_actv = $web_actv;
    }

    public function getWebExterna() {
        return $this->web_externa;
    }

    public function setWebExterna($web_externa) {
        $this->web_externa = $web_externa;
    }

    public function getWebExternaActv() {
        return $this->web_externa_actv;
    }

    public function setWebExternaActv($web_externa_actv) {
        $this->web_externa_actv = $web_externa_actv;
    }

    public function getWebExtTitulo() {
        return $this->web_ext_titulo;
    }

    public function setWebExtTitulo($web_ext_titulo) {
        $this->web_ext_titulo = $web_ext_titulo;
    }

    public function getWebEsExterna() {
        return $this->web_es_externa;
    }

    public function setWebEsExterna($web_es_externa) {
        $this->web_es_externa = $web_es_externa;
    }
	public function getAgenteComercial() {
        return $this->agente_comercial;
    }

    public function setAgenteComercial($agente_comercial) {
        $this->agente_comercial = $agente_comercial;
    }

    public function getContactado() {
        return $this->contactado;
    }

    public function setContactado($contactado) {
        $this->contactado = $contactado;
    }

    public function getFechaContacto() {
        return $this->fecha_contacto;
    }

    public function setFechaContacto($fecha_contacto) {
        $this->fecha_contacto = $fecha_contacto;
    }

    public function getInteresado() {
        return $this->interesado;
    }

    public function setInteresado($interesado) {
        $this->interesado = $interesado;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function getRellamar() {
        return $this->rellamar;
    }

    public function setRellamar($rellamar) {
        $this->rellamar = $rellamar;
    }

    public function getLogoFilePath() {
        return $this->logo_file_path;
    }

    public function setLogoFilePath($logo_file_path) {
        $this->logo_file_path = $logo_file_path;
    }

    public function getImagenFilePath() {
        return $this->imagen_file_path;
    }

    public function setImagenFilePath($imagen_file_path) {
        $this->imagen_file_path = $imagen_file_path;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    public function getComentarios() {
        return $this->comentarios;
    }

    public function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    public function getRecibirNewsletter() {
        return $this->recibir_newsletter;
    }

    public function setRecibirNewsletter($recibir_newsletter) {
        $this->recibir_newsletter = $recibir_newsletter;
    }

    public function getQuiereVIP() {
        return $this->quiere_vip;
    }

    public function setQuiereVIP($quiere_vip) {
        $this->quiere_vip = $quiere_vip;
    }

    public function getQuiereWebLotoluck() {
        return $this->quiere_web_lotoluck;
    }

    public function setQuiereWebLotoluck($quiere_web_lotoluck) {
        $this->quiere_web_lotoluck = $quiere_web_lotoluck;
    }

    public function getPaginaCompradores() {
        return $this->pagina_compradores;
    }

    public function setPaginaCompradores($pagina_compradores) {
        $this->pagina_compradores = $pagina_compradores;
    }

    public function getCreadoPor() {
        return $this->creado_por;
    }

    public function setCreadoPor($creado_por) {
        $this->creado_por = $creado_por;
    }

    public function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function setMetadata($metadata) {
        $this->metadata = $metadata;
    }
}
?>
