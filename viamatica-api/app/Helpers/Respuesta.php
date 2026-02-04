<?php

namespace App\Helpers;

class Respuesta
{
    public static $codRespuesta="";
    public static $data="";
    public static $mensaje='';


    public static function retornarRespuesta(){
        $datos["codRespuesta"] = Respuesta::$codRespuesta;
        $datos["data"] = Respuesta::$data;
        $datos["mensaje"] = Respuesta::$mensaje;
        $httpCode = (Respuesta::$codRespuesta === '200' || Respuesta::$codRespuesta === '201') ? 200 : 500;//codigo de respiesta 201 para creacion exitosa
        return response()->json($datos, $httpCode);
    }
}
