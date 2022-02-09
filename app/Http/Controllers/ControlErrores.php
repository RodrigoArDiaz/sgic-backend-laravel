<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Login;
use App\Http\Requests\PassRequest;
use App\Http\Requests\RegistroRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;


class ControlErrores extends Controller
{


public static function ControlErr($respuesta)
    {

 
        
if (count($respuesta)===1 && ($respuesta[0]->Tipo==='Mensaje'))
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje
    // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
],200);

if (count($respuesta)===1)
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje
    // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
],404);

      
if (count($respuesta)===2)
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
    $respuesta[1]->Tipo=>$respuesta[1]->Mensaje
    // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
],404);

if (count($respuesta)===3)
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
    $respuesta[1]->Tipo=>$respuesta[1]->Mensaje,
    $respuesta[2]->Tipo=>$respuesta[2]->Mensaje
    ],404);

    if (count($respuesta)===4)
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
    $respuesta[1]->Tipo=>$respuesta[1]->Mensaje,
    $respuesta[2]->Tipo=>$respuesta[2]->Mensaje,
    $respuesta[3]->Tipo=>$respuesta[3]->Mensaje
    ],404);

    if (count($respuesta)===5)
    return response()->json([
        $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
        $respuesta[1]->Tipo=>$respuesta[1]->Mensaje,
        $respuesta[2]->Tipo=>$respuesta[2]->Mensaje,
        $respuesta[3]->Tipo=>$respuesta[3]->Mensaje,
        $respuesta[4]->Tipo=>$respuesta[4]->Mensaje
        ],404);
    


        if (count($respuesta)===6)
        return response()->json([
            $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
            $respuesta[1]->Tipo=>$respuesta[1]->Mensaje,
            $respuesta[2]->Tipo=>$respuesta[2]->Mensaje,
            $respuesta[3]->Tipo=>$respuesta[3]->Mensaje,
            $respuesta[4]->Tipo=>$respuesta[4]->Mensaje,
            $respuesta[5]->Tipo=>$respuesta[5]->Mensaje
            ],404);
        

            if (count($respuesta)===7)
            return response()->json([
                $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
                $respuesta[1]->Tipo=>$respuesta[1]->Mensaje,
                $respuesta[2]->Tipo=>$respuesta[2]->Mensaje,
                $respuesta[3]->Tipo=>$respuesta[3]->Mensaje,
                $respuesta[4]->Tipo=>$respuesta[4]->Mensaje,
                $respuesta[5]->Tipo=>$respuesta[5]->Mensaje,
                $respuesta[6]->Tipo=>$respuesta[6]->Mensaje
                ],404);
            

                if (count($respuesta)===8)
            return response()->json([
                $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
                $respuesta[1]->Tipo=>$respuesta[1]->Mensaje,
                $respuesta[2]->Tipo=>$respuesta[2]->Mensaje,
                $respuesta[3]->Tipo=>$respuesta[3]->Mensaje,
                $respuesta[4]->Tipo=>$respuesta[4]->Mensaje,
                $respuesta[5]->Tipo=>$respuesta[5]->Mensaje,
                $respuesta[6]->Tipo=>$respuesta[6]->Mensaje,
                $respuesta[7]->Tipo=>$respuesta[7]->Mensaje
                ],404);

    }



}