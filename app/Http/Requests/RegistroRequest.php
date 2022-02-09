<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        DB::select('CALL ComprobarPendientes ()');
        return [
            'Usuario' =>'required|unique:Usuarios,Usuario',
            'Contrasena' =>'required|min:8|max:16',
            'Contrasena_confirmation' =>'required|same:Contrasena',
            'Documento' =>'required|min:8|unique:Usuarios,Documento',
            'Apellidos' =>'required',
            'Nombres' =>'required',
            'Email' =>'required|email|unique:Usuarios,Email'
            // |email|unique:Usuarios, Email'
            //'ConfContrasena' =>'required|min:8|max:16',
            
            //'Tipo' =>'required| max:1'

        ];
    }



}
