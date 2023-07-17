<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FullCalenderController extends Controller
{
    public function index (Request $request)
    {
        return view ('full-calender');
    }
}
