<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
class PermisoLoginDocente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $user1=DB::table('Usuarios')
        ->join('UsuariosCatedra','Usuarios.IdUsuario','=','UsuariosCatedra.idDocente')

        ->select('Usuarios.*')
        ->where('Usuarios.Usuario','=',$request->Usuario)
        ->get();

        $user2=DB::table('Usuarios')
        ->join('UsuariosCatedra','Usuarios.IdUsuario','=','UsuariosCatedra.idDocente')

        ->select('Usuarios.*')
        ->where('Usuarios.Email','=',$request->Usuario)
        ->get();




        $user3=DB::table('Usuarios')
        
        ->select('Usuarios.*')
        ->where('Usuario','=',$request->Usuario)
        ->get();

        $user4=DB::table('Usuarios')
                ->select('Usuarios.*')
        ->where('Email','=',$request->Usuario)
        ->get();


        if($user3->isEmpty() && $user4->isEmpty()){
            
            return $next($request);
        }

        if($user1->isEmpty() && $user2->isEmpty()){
            
            return route ('login');
        }



        return $next($request);

    }
}
