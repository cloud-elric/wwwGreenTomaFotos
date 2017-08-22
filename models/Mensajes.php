<?php
namespace app\models;

use Yii;

class Mensajes{
    
    public function mandarMensage($mensaje, $numeroDestino){
        /**  ENVIO DE UN SOLO MENSAJE  **/
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => "http://smsmasivos.com.mx/sms/api.envio.new.php",
            //HTTPS
            //CURLOPT_URL => "https://smsmasivos.com.mx/sms/api.envio.new.php",
            //CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POSTFIELDS => array(
                    "apikey" => "67f669a02ff48fcbd1a526cffb68b5fa884e220a",//API KEY DE CUENTA 
                    "mensaje" => $mensaje,
                    "numcelular" => $numeroDestino,
                    "numregion" => "52"
                )
        ));
        
        $respuesta=curl_exec($ch);
        $respuestaDecode=json_decode($respuesta);
        return $respuestaDecode;
        /*if($respuestaDecode->estatus == "ok"){
            curl_close($ch);
            return $respuestaDecode;            
        }else{
            return false;
        }*/
        //echo $respuesta->mensaje;
    }
}

?>