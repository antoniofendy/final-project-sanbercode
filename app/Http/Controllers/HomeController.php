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
        $tanya = Pertanyaan::orderBy('created_at', 'DESC')->paginate(5);

        return view('home', ['data_tanya' => $tanya]);
    }

    public function search(Request $request)
    {
        $hasil_pencarian = Pertanyaan::where([
            ["judul", "like", "%" . $request->keyword . "%"],
            ["isi", "like", "%" . $request->keyword . "%"]
        ])->get();
        
        $data_pencarian = [$request->keyword, $hasil_pencarian];

        return view('search', compact('data_pencarian', 'data_pencarian'));
    }
}
