<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class Login extends FormRequest
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
        return [
            'Usuario' =>'required',
            'Contrasena' =>'required',
            //'Tipo' =>'required| max:1'

        ];
    }



    public function valido()
    {
        
        RateLimiter::clear($this->throttleKey());
        return;
    }
    
public function SuperaIntentos(){

    return RateLimiter::tooManyAttempts($this->throttleKey(), 5);

    }




    public function authenticate()
    {
        $valor=$this->ensureIsNotRateLimited();

        return $valor ;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            RateLimiter::hit($this->throttleKey());
            return response()->json([
                'res'=> 'Contraseña inválida',
                ],401);;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());


        
        return response()->json([
            'res'=> 'Puede volver a intentar dentro de '.$seconds,
            ],401);
        /*throw ValidationException::withMessages([
            'Usuario' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);*/
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->Usuario).'|'.$this->ip();
        //return 'cadena';
    }



}
