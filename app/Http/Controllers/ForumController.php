<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Pertanyaan;

class ForumController extends Controller
{
    
    public function index($pertanyaan_id){

        $data_tanya = Pertanyaan::find($pertanyaan_id);

        dd($data_tanya);

        return view('user.detail_forum.index');

    }

}
