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

    // FUNCTION UNTUK PENCARIAN DAN PAGINATION PENCARIAN HALAMAN SATU KE HALAMAN DUA DST
    public function search(Request $request)
    {
        $hasil_pencarian = Pertanyaan::where([
            ["judul", "like", "%" . $request->keyword . "%"],
            ["isi", "like", "%" . $request->keyword . "%"]
        ])->paginate(5);
        
        $hasil_pencarian->withPath('search/' . $request->keyword);

        $data_pencarian = [$request->keyword, $hasil_pencarian];

        return view('search', compact('data_pencarian', 'data_pencarian'));
    }

    // FUNCTION UNTUK PENCARIAN DAN PAGINATION PENCARIAN DARI HALAMAN DUA DST KE HALAMAN SATU
    public function searchpaginate($keyword)
    {
        $hasil_pencarian = Pertanyaan::where([
            ["judul", "like", "%" . $keyword . "%"],
            ["isi", "like", "%" . $keyword . "%"]
        ])->paginate(5);
        
        $hasil_pencarian->withPath($keyword);

        $data_pencarian = [$keyword, $hasil_pencarian];

        return view('search', compact('data_pencarian', 'data_pencarian'));
    }
}
