<?php

namespace App\Http\Controllers;

use App\Models\FilialModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function registro_user(){
        $filiais = DB::table('filiais')-> orderby('filCodigo') ->get();
        return view('auth.register', compact('filiais'));

    }

    function teste(){


    }
}


