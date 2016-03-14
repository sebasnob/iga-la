<?php

define("WSC_RETURN_NORMAL", 0);
define("WSC_RETURN_ARRAY", 1);
define("WSC_RETURN_JSON", 2);


class wsc_sistema{   
    
    private $base_url;
    private $request_method = "GET";
    private $response_format = "JSON";
    private $url;
    private $response_data;
    public $metodo;
    public $parametros = array();
    private $errors = array();
    private $error_status = false;
    
    /* FUNCTION CONSTRUCT */
    
    function __construct($metodo = null, array $parametros = null){
        //$this->base_url = $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.106'  ? 'http://192.168.1.106/igacloud/' : 'http://sistema.igacloud.net/';

//$this->base_url = 'http://dev.igacloud.net/';
		$this->base_url = 'http://sistema.igacloud.net/';
        if($metodo != null){
            $this->metodo = $metodo;
            $this->parametros = $parametros;    
            $this->setURL();
        }
    }
    
    /* PRIVATE FUNCTIONS */
    
    private function setURL(){
        $url = '';
        $request = "GET";
        $response = "JSON";
        switch ($this->metodo) {
            
            /* CERTIFICADOS */
            
            case "get_certificados_pendientes":
                $url = "certificados/get_certificados_pendientes";
                $request = "POST";
                break;
            
            /* INSCRIPCIONES WEB */
            
            case "sincronizar_reservas_inscripciones_web":              
                $url = "reservas/sincronizar_reservas_inscripciones_web/";
                $request = "POST";
                break;
            
            case "sincronizar_reservas_inscripciones":                          // dejar de utilizar esta function y reemplazarla por sincronizar_reservas_inscripciones_web
                $url = "reservas/guardarReservaInscripcion/";
                $request = "POST";
                break;
            
            case "sincronizar_mails_consultas_reservas":
                $url = "reservas/guardarMailsConsultasReservas/";
                $request = "POST";
                break;
            
            /* MAILS CONSULTAS */
            
            case "sincronizar_consulta_web":
                $url = "consultasweb/guardar_consulta_ws/";
                $request = "POST";
                break;
            
            case "mails_consultas_get_max_codigo":
                $url = "consultasweb/getMaxCodigo/";
                $request = "POST";
                break;
            
            case "sincronizar_respuesta_consultas_web":
                $url = "consultasweb/guardar_respuesta_consulta/";
                $request = "POST";
                break;
           
            /* DEFAULT */
            
            default:
                $url = '';
                break;
        }
        if ($request == "GET" && $this->parametros != null && is_array($this->parametros)){
            $url .= implode("/", $this->parametros);
        }
        $this->request_method = $request;
        $this->response_format = $response;
        $this->url = $this->base_url.$url;
    }
    
    /* PUBLIC FUNCTIONS */
    
    public function isError(){
        return $this->error_status;
    }
    
    public function setCall($callName, $clearParam = true){
        $this->metodo = $callName;
        $this->setURL();
        if ($clearParam){
            $this->parametros = array();
        }
    }
    
    public function getResponse(){
        return $this->response_data;
    }
    
    public function setParametros(array $arrParametros){
        $this->parametros = $arrParametros;
    }
    
    public function showError(){
        echo "<pre>";
        print_r($this->errors);
        echo "</pre>";
    }
    
    public function getError(){
        return $this->errors;
    }
    
    public function exec($returnType = WSC_RETURN_NORMAL){
        $soap_do = curl_init();
        $requestTime = strtotime(date("Y-m-d h:i:s"));
        curl_setopt($soap_do, CURLOPT_URL, $this->url);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 1500 );        
        $header = array (
            'Connection: close', 
            'Accept-Language : es-ar,es;q=0.8,en-us;q=0.5,en;q=0.3',
            'X_AUTHORIZATION_TOKEN: 343b1b831066a40e308e0af92e0f06f0',
            'REQUEST_TIME: '.$requestTime,
            'CONTENT: '.md5(md5(md5($requestTime."y_h23oo0154__m")))
            );
        if ($this->request_method == 'multipart'){
            $header[] = "Content-Type:multipart/form-data";
            curl_setopt($soap_do, CURLOPT_POST, 1 );
            curl_setopt($soap_do,  CURLOPT_INFILESIZE, $this->parametros['filesize']);
            curl_setopt($soap_do, CURLOPT_POSTFIELDS, array("filedata" => $this->parametros['filedata'], "filename" => $this->parametros['filename']));
        } else if ($this->request_method == 'POST'){
            curl_setopt($soap_do, CURLOPT_POST, 1 );
            curl_setopt($soap_do, CURLOPT_FOLLOWLOCATION, false);
            if (isset($this->parametros) && is_array($this->parametros))
                curl_setopt($soap_do,CURLOPT_POSTFIELDS,http_build_query($this->parametros));
        }
        
        curl_setopt ($soap_do, CURLOPT_HTTPHEADER, $header);
        curl_setopt($soap_do, CURLOPT_USERPWD, "admin:".md5("adminCibernet77"));
        $respuesta = curl_exec($soap_do);
        if (curl_errno($soap_do) <> 0){
            $this->errors[] = "[".curl_errno($soap_do)."] ".curl_error($soap_do);
            $this->error_status = true;
        }
        $this->response_data = $respuesta;
        curl_close($soap_do);
        if ($returnType != null){
            if ($returnType == WSC_RETURN_ARRAY){
                if ($this->response_format == "JSON"){
                    return json_decode($this->response_data, true);
                } else {                                                        // definir otros metodos de entrada como XML
                    return "response format no definido";
                }
            } else if ($returnType == WSC_RETURN_JSON) {
                if ($this->response_format == "JSON"){
                    return $this->response_data;
                } else {
                    return "response format no definido";
                }
            } else {                                                            // definir otros metodos de salida como json
                return "metodo de retorno no definido";
            }
        } else {
            return $this->response_data;
        }
    }
    
    /* STATIC FUNCTIONS */
    
    static public function validar($metodo, wsc_sistema &$wsc = null){
        if ($wsc == null){
            $wsc = new wsc_sistema($metodo);
        } else if ($wsc->metodo <> $metodo){
            $wsc->setCall($metodo);
        }
    }
}
