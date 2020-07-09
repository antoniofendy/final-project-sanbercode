<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \App\Pertanyaan;
use \App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tanya = DB::table('pertanyaan')
                    ->select('pertanyaan.*', 'users.name')
                    ->join('users', 'pertanyaan.id', '=' ,'users.id')
                    ->get();

        $tag = DB::table('pertanyaan_tag')
                    ->select('tag_');

        return view('home', ['data_tanya' => $tanya]);
    }
}
