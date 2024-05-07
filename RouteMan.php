<?php

/**
 * Clase RouteMan que proporciona funcionalidad de enrutamiento.
 */
class RouteMan
{
    /** La ruta al directorio de archivos para rutas tipo "file". */
    private $routePath;

    /** El tipo de contenido predeterminado. */
    private  $defaultContentType;

    /** El arreglo de rutas configuradas. */
    private  $arrRoutes;

    /**   El protocolo usado para acceder la ruta HTTP/HTTPS. */
    private  $requestURL;

    /** La ruta actual gestionada. */
    private $currentRoute;

    /** La base de reescritura para las rutas. */
    private $rewriteBase;

    /**
     * Constructor de RouteMan.
     */
    public function __construct()
    {
        // Inicializar propiedades
        $this->requestURL = (isset($_SERVER["HTTPS"]) ? "https://" : "http://") 
                            . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $this->routePath = 'Loto/';
        $this->defaultContentType = 'text/html';
        $this->currentRoute = '';
        $this->rewriteBase = '/';

        //mensaje por defecto cuando no se encuentra una ruta.
        $this->addRoute('error', [
            'function' => function ($route) {
                echo "Route " . $route . " not found!";
            }
        ]);
    }

    /**
     * Agrega una ruta a la instancia de RouteMan.
     *
     * @param string $url La URL de la ruta, ejemplo "about".
     * @param array $routeAttr El atributo de archivo de la ruta. Este parámetro
     * tiene la siguiente estructura:
     *
     * array("file" => "nombre del archivo php a usar", 
     *       "content" => "text/html")
     *
     * array("function" => function(){
     *         echo "hello";
     *       }, 
     *       "content" => "text/html")
     *
     * @return void
     */
    public function addRoute(string $url, array $routeAttr): void
    {
        $arrURLs = explode(",", $url);

        foreach ($arrURLs as $urlItem) {
            $this->arrRoutes[$urlItem] = $routeAttr;
        }
    }

    /**
     * Gestiona las acciones y acceso a las rutas configuradas a partir del URL
     *
     * @return void
     */
    public function manageRoutes(): void
    {

        $this->requestURL = (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

        $arrURL = parse_url($this->requestURL);
        $arrURLParams = array();

        if (isset($arrURL['query'])) {

            parse_str($arrURL['query'], $arrURLParams);
        }

        // Convertimos los parámetros enviados a través de javascript usando 
        // .fetch() a un arreglo "global" como $_POST o $_GET
        $_RMFETCH = json_decode(file_get_contents("php://input"), true);

        if (is_null($_RMFETCH)) {

            $_RMFETCH = array();
        }

        $arrURL["path"] = str_replace($this->rewriteBase, "", $arrURL["path"]);
        $this->currentRoute = trim($arrURL['path'], "/");

        if (array_key_exists($this->currentRoute, $this->arrRoutes)) {

            if (array_key_exists('content', $this->arrRoutes[$this->currentRoute])) {

                $this->setHeaderType($this->arrRoutes[$this->currentRoute]['content']);
            } else {

                $this->setHeaderType();
            }

            if (isset($this->arrRoutes[$this->currentRoute]['file'])) {

                $filePath = $this->routePath . $this->arrRoutes[$this->currentRoute]['file'];

                if (file_exists($filePath)) {

                    require $filePath;
                    exit;
                }
            }

            if (isset($this->arrRoutes[$this->currentRoute]['function'])) {

                $this->arrRoutes[$this->currentRoute]['function']();
                exit;
            }
        } else {
            $this->arrRoutes["error"]['function']($this->currentRoute);
            exit;
        }
    }

    /**
     * Fija el Content-Type a usar para cada ruta invocada.
     *
     * @param string|null $type The content type
     * @return void
     */
    public function setHeaderType($type = null): void
    {
        if (is_null($type)) {

            $type = $this->defaultContentType;
        }

        header("Content-Type: " . $type . "; charset=UTF-8");
    }
}