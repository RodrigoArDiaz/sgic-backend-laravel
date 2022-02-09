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
use App\Http\Controllers\ControlErrores;

class AuthCatedrasController extends Controller
{
//use Mail;
   /*
    /* 
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','me']]);
    }
*/
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function login()
    {
        $credentials = request(['password','Usuario' ]);

        if (! $token = auth()->attempt($credentials)) {

              return response()->json(['error' => 'No existe el usuario o la contraseña'], 401);
        }

        return $this->respondWithToken($token);
    }
*/
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
  /*  public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
  /*  public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
*/
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }*/

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }




    protected function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'Usuario'=>'required',
            'Email'=>'required|string|email|max:100|unique:Usuarios',
            'password'=>'required|string|min:6',

        ]);
    if($validator->fails()){

        return response()->json($validator->errors()->toJson(),400);
    }
    
  
  $user= Usuarios::insert (

    [
        'Usuario' => $request->Usuario , 
        'password' => bcrypt($request->password),
    'Email' => $request->Email, 'Estado' =>'A',
    'Nombres' => $request->Nombres,
    'Apellidos' => $request->Apellidos,
    'Documento' => $request->Documento,
    'EsSuperAdministrador' => 'N',
    ]

  );
     
  /*$user= Usuarios::create(array_merge(
        $validator->validate(),['password'=>bcrypt($request->password)]

    ));
    */
    /*return response()->json([
        'message'=>'Usuario registrado con éxito',
        'user'=> $user
    ],201);   


    }
*/






public function login(Login $request)
    {
       /* if($request->Tipo !=='A' && $request->Tipo !=='D' && $request->Tipo !=='S'){
            return response()->json(['res'=> 'Tipo inválido'
        ],500); 
        }
*/



       if(!$usuario = Usuarios::where('Usuario',$request->Usuario)->first()){ 
        
       if(!$usuario = Usuarios::where('Email',$request->Usuario)->first()){
            return response()->json([
                'res'=> 'Usuario o Email inexistentes'
                ],401); 
                
                      }}
       
        if(!$usuario = Usuarios::where('Usuario',$request->Usuario)->first()){
            $usuario = Usuarios::where('Email',$request->Usuario)->first();
        }

/*if(!$usuario = Usuarios::where('Usuario',$request->Usuario)->first()){
            throw ValidationException::withMessages([
                'msg'=>['Usuario o contrasena incorrectos'],
            ]);
        }
  */    
    // $usuario = Usuarios::where('Usuario',$request->Usuario)->first();
        
    
    if(!$usuario||!Hash::check($request->Contrasena, $usuario->Contrasena) ){

  /*          throw ValidationException::withMessages([
                'msg'=>['Usuario o Contrasena incorrecta'],
            ]);
*/

$valor = $request->authenticate();
/*return response()->json([
    'res'=> 'Contraseña inválida'
    ],401);  */
    return $valor;
}
if($request->SuperaIntentos()){
    $valor = $request->authenticate();
    return $valor;  
}

$request->valido();

//if($usuario->EsSuperAdministrador==='S' && $request->Tipo==='S'){}

if($usuario->Estado==='P'){
    
    return response()->json([
        'res'=> 'Debe activar su usuario a través del enlace de activación enviado a su correo',
        
        ],401);  
}


if($usuario->Estado==='B'){
    
    return response()->json([
        'res'=> 'Su usuario está dado de baja. Consulte al administrador para activarlo',
        
        ],401);  
}

  $token=$usuario->createToken($request->Usuario)->plainTextToken;

  return response()->json([
'res'=> true,
'token'=>$token
],200);

}





public function logout(Request $request)
    {
       

$request->user()->currentAccessToken()->delete();

  return response()->json([
'res'=> true,
'msg'=>'Sesión cerrada'
],200);

}

public function me(Request $request)
    {
       
  return response()->json([
'res'=> true,
'Usuario'=>$request->user()
],200);


}



/*
------------------------------REGISTRO------------------------
*/
public function registro(RegistroRequest $request)
    {


        //DB::select('CALL ComprobarPendientes ()');

        $pass= bcrypt($request->Contrasena);
        $variable = DB::select('CALL CrearUsuario (?,?,?,?,?,?,?)',array( $pass,
        $pass,
        $request->Usuario, $request->Email, $request->Documento, $request->Nombres, 
        $request->Apellidos));
    
        $user= DB::table('Usuarios')->select ('*')->where('Documento','=',$request->Documento)->first();

$codigo=Str::random(30);
        DB::select('CALL InsertarRegistro (?,?)',array($codigo ,$user->IdUsuario));
        
        
    $info = ['name' => $request->Nombres];
    $info = Arr::add($info, 'mail', $request->Email);
    $info = Arr::add($info, 'codigo', $codigo);

    Mail::send('emails.confirmation_code', $info, function($message) use ($info) {
        $message->to($info['mail'], $info['name'])->subject('Por favor confirma tu correo');
    });
//$variable=DB::select('CALL ComprobarPendientes ()');

  return response()->json([
'res'=> true,
'Mensaje'=>'Debe verificar el correo a través del enlace enviado'
],200);

}
    

/*

public function EnviarMailRegistro (Request $request){
    
    $info = ['name' => $request->Nombres];
    $info = Arr::add($info, 'mail', $request->Email);
    $info = Arr::add($info, 'codigo', $request->Codigo);

    Mail::send('emails.confirmation_code', $info, function($message) use ($info) {
        $message->to($info['mail'], $info['name'])->subject('Por favor confirma tu correo');
    });
}
*/

/*
------------------------------REGISTRO------------------------
*/



public function ReenviarLinkActivacion(Request $request)
    {

//comprobar que no haya vencidos
$respuesta=DB::select('CALL ComprobarPendientesActivacion()');
$codigo=Str::random(30);
$respuesta= DB::select('CALL InsertarRegistro (?,?)',array( $codigo,$request->IdUsuario));
        
$user= DB::table('Usuarios')->select ('Nombres, Email')->where('IdUsuario','=',$request->IdUsuario)->first();

$info = ['name' => $user->Nombres];
    $info = Arr::add($info, 'mail', $user->Email);
    $info = Arr::add($info, 'codigo', $request->codigo);

    Mail::send('emails.confirmation_code_reenvio', $info, function($message) use ($info) {
        $message->to($info['mail'], $info['name'])->subject('Por favor confirma tu correo');
    });


//$variable=DB::select('CALL ComprobarPendientes ()');

  return response()->json([
'res'=> true,
'Mensaje'=>$respuesta
],200);

}




public function restablecerContrasena(Request $request)
    {

        $respuesta=DB::select('CALL ComprobarPendientesReestablecer()');
        
        $codigo= Str::random(30);
        $respuesta= DB::select('CALL InsertarRegistroReestablecer (?,?)',array($codigo ,$request->pCorreo));
                

        
        $user= DB::table('Usuarios')->select ('Nombres')->where('Email','=',$request->pCorreo)->first();

        $info = ['name' => $user->Nombres];
            $info = Arr::add($info, 'mail', $request->pCorreo);
            $info = Arr::add($info, 'codigo', $codigo);
        
            Mail::send('emails.confirmation_code_resetpass', $info, function($message) use ($info) {
                $message->to($info['mail'], $info['name'])->subject('Por favor confirma tu correo');
            });
        


        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
          return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        
}




public function ActivarCuenta($codigo)
    {

        
        $respuesta= DB::select('CALL ActivarCuenta (?)',array( $codigo));
                
        
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
          return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        
}






public function CambiarPass(PassRequest $request)
    {

        
        $respuesta= DB::select('CALL CambiarPass (?,?)',array( $request->pCodigo,
         bcrypt($request->Contrasena)));
                
        
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
          return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        
}







public function ModificarUsuario(Request $request)
    {

        

        $respuesta= DB::select('CALL ModificarUsuario (?,?,?,?,?,?)',array( $request->pUs,
        $request->pMail, $request->pDoc, $request->pNom, $request->pAp,
        $request->user()->IdUsuario));
                

        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
       /* $r= response()->json([
            $respuesta
            ],200);

          return response()->json([
            $r->original[0][0]->Tipo=>$r->original[0][0]->Mensaje
            // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
        ],200);
        */
/*
if (count($respuesta)===1)
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje
    // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
],200);

      
if (count($respuesta)===2)
return response()->json([
    $respuesta[0]->Tipo=>$respuesta[0]->Mensaje,
    $respuesta[1]->Tipo=>$respuesta[1]->Mensaje
    // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
],200);



return response()->json([
            $respuesta[0]->Tipo=>$respuesta[0]->Mensaje
            // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
        ],200);
*/


}







public function verifymail(Request $request)
    {

        
        $respuesta= DB::select('CALL VerificarMail (?)',array( $request->Email));
                
        
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}


public function verifylib(Request $request)
    {

        
        $respuesta= DB::select('CALL VerificarLibreta (?)',array( $request->Libreta));
                
        
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}



public function verifydni(Request $request)
    {

        
        $respuesta= DB::select('CALL VerificarDocumento (?)',array( $request->Documento));
                
        
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}


public function BuscarCatedras(Request $request)
    {

        
        $respuesta= DB::select('CALL BuscarCatedras (?,?,?,?)',array( $request->Catedra,$request->Bajas,
    $request->Offset,$request->Limite));
                
        
        return response()->json([
            'res'=>$respuesta
            // $r->Mensaje->Tipo=>$r->Mensaje->Mensaje
        ],200);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}





public function AltaCatedra(Request $request)
    {

        
        $respuesta= DB::select('CALL AltaCatedra (?)',array( $request->IdCatedra));
                
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}



public function BajaCatedra(Request $request)
    {

        
        $respuesta= DB::select('CALL BajaCatedra (?)',array( $request->IdCatedra));
                
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}





public function BorrarCatedra(Request $request)
    {

        
        $respuesta= DB::select('CALL BorrarCatedra (?)',array( $request->IdCatedra));
                
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}



public function verifycat(Request $request)
    {

        
        $respuesta= DB::select('CALL VerificarCatedra (?,?)',array( $request->Catedra,$request->IdCatedra));
                
        
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}



public function ModificarCatedra(Request $request)
    {

        
        $respuesta= DB::select('CALL ModificarCatedra (?,?)',array( $request->IdCatedra,$request->Catedra));
                
        
        return ControlErrores::ControlErr($respuesta);
        
        //$variable=DB::select('CALL ComprobarPendientes ()');
        
         /* return response()->json([
        'res'=> true,
        'Mensaje'=>$respuesta
        ],200);
        */
}




}