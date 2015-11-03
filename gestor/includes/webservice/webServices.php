<?php

include 'AES_Encryption.php';
include 'padCrypt.php';



class webServices{
    

    
    public function send($nombreFuncion, $arrayParametros = null){
        
        $version = $this->getVersion($nombreFuncion);
        $arrayParametros = $arrayParametros == null ? array() : $arrayParametros;
        $xml = $this->formarXMLEnvio($nombreFuncion, $arrayParametros);
        $soap_do = curl_init();
        if ($_SERVER['HTTP_HOST'] == '192.168.1.106'){
            curl_setopt($soap_do, CURLOPT_URL,"http://localhost/webservice/xml_read.php");
        } else {
            curl_setopt($soap_do, CURLOPT_URL,"http://webservice.iga-la.com/xml_read.php");
        }
        curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded', 'Content-Length: '.strlen($xml)));
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
        $respuesta=curl_exec($soap_do);
        curl_close($soap_do);
        
        if ($version == 2){
            return $respuesta;
        } else if ($version == 3){
            $dom = new DOMDocument;
            $dom->loadXML($respuesta);
            $respuesta_xml = simplexml_import_dom($dom);
            $xml_datos = $this->desencapsular($respuesta_xml);
            return $xml_datos;
        }
        
    }

    /* PRIVATE FUNCTIONS */

    private function desencapsular($xml){
        $encapsulado = $xml->datos;
        if (strlen($encapsulado) > 0){
        $char .= "";
        for ($i = 0; $i < strlen($encapsulado); $i = $i + 2){
                $caracter = chr(hexdec(substr($encapsulado, $i, 2)));
                $char .= substr($caracter, strlen($caracter) - 2);
            }
            $key = md5("Kojoruq1999789po");
            $iv = "dasdREWTRB0098gt";

            $AES = new AES_Encryption($key, $iv);
            $encapsulado = $AES->decrypt($char);
        $dom = new DOMDocument;
        $dom->loadXML($encapsulado);
        $xml_desencapsulado = simplexml_import_dom($dom);

        return $xml_desencapsulado;
        } else return $xml;
    }

    private function encapsular($xml){
        $pos = strpos($xml, "<datos>") + 7;
        $pos1 = strpos($xml, "</datos>");
        $textAEncapsular = substr($xml, $pos, $pos1 - $pos);

        $key = md5("RoKoPoADS897");
        $iv = "dasdREWTRB5454gt";
        $AES = new AES_Encryption($key, $iv);
        $encapsulado = $AES->encrypt($textAEncapsular);
        $char = '';
        for ($i = 0; $i < strlen($encapsulado); $i++){
            $caracter = "00".dechex(ord(substr($encapsulado, $i, 1)));
            $char .= substr($caracter, strlen($caracter) - 2);
        }
        $xml = substr_replace($xml, "$char", $pos, $pos1 - $pos);
        return $xml;
    }


    private function generarValidacionXML($xml, $version = 2){
        $version = $version == null ? 2 : $version;
        $pos = strrpos($xml, "</");

        $xml1 .= "<validacion>";
        $xml1 .= "<version>$version</version>";
        $xml1 .= "</validacion>";
        $xml = substr_replace($xml, $xml1, $pos, 0);

        $key = md5("RoKoPo999ADS897");
        $iv = "dasdREWTRB5454gt";
        $AES = new AES_Encryption($key, $iv);
        $validacionTag = $AES->encrypt($xml);
        $char = '';
        for ($i = 0; $i < strlen($validacionTag); $i++){
            $caracter = "00".dechex(ord(substr($validacionTag, $i, 1)));
            $char .= substr($caracter, strlen($caracter) - 2);
        }
        $pos = strpos($xml, "</validacion>");
        $xml = substr_replace($xml, "<codigo>$char</codigo>", $pos, 0);
        return $xml;
    }


    private function getVersion($function){
        switch ($function) {
            case "JSON_getAsuntosMailsconsultas":
                $version = 2;
                break;
            case "JSON_getCursosConCupo":
                $version = 2;
                break;
            case "JSON_getCotizaciones":
                $version = 2;
                break;
            case "JSON_getCursos":
                $version = 2;
                break;
            case "JSON_getCursosSubcategorias":
                $version = 2;
                break;
            case "JSON_getCursosCategorias":
                $version = 2;
                break;
            case "JSON_getFiliales":
                $version = 2;
                break;
            case "JSON_getCiudades":
                $version = 2;
                break;
            case "JSON_getProvincias":
                $version = 2;
                break;
            case "JSON_getPaises":
                $version = 2;
                break;

            case "XML_guardarConsultaCurso":
                $version = 3;
                break;
            case "XML_guardarConsultaReserva":
                $version = 3;
                break;
            case "XML_reservarInscripcion":
                $version = 3;
                break;

            default:
                $version = 1;
                break;
        }

        return $version;
    }

    
    private function formarXMLEnvio($nombreLLamada, $arrParametros){
        $version = $this->getVersion($nombreLLamada);
        $xml = "<?xml version='1.0' encoding='UTF-8' ?>";
        $xml .= "<l1>";
        $xml .= "<version_controlador>1</version_controlador>";
        $xml .= "<datos>";
        $xml .= "<procedimiento>$nombreLLamada</procedimiento>";
        $xml .= "<parametros>";
        foreach ($arrParametros as $parametro){
            $xml .= "<parametro>$parametro</parametro>";
        }
        $xml .= "</parametros>";
        $xml .= "</datos>";
        $xml .= "</l1>";

        $xml = $this->generarValidacionXML($xml, $version);
        $xml = $this->encapsular($xml);
        return $xml;
    }

}
?>