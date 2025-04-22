<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Fasilitas;

class HomeController extends Controller
{
    public function index()
    {
        $kamars = Kamar::all();
        $fasilitass = Fasilitas::all();



        return view('users.home', compact('kamars', 'fasilitass'));
    }
}
