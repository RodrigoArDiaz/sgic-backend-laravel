<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class AlumnosController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function resultado(Request $request)
    {
    $variable = DB::select('CALL BuscarUsuario (?,?,?,?,?,?,?,?)',array( $request->pUs,$request->pMail,
    $request->pDoc, $request->pNom, $request->pAp, $request->piB, $request->pOffset, $request->pLimite));


return 
 response()->json([
    'res'=> $variable
    ],200);     
}
}
