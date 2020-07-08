<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function buat_pertanyaan(){
        return view('user.pertanyaan.buat');
    }

    public function simpan_pertanyaan (Request $request){

        dd($request->all());

    }

}
