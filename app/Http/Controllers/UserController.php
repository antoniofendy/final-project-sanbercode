<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use \App\Pertanyaan;
use \App\Tag;
use \App\Vote_Pertanyaan;
use \App\User;

use Carbon\Carbon; 


class UserController extends Controller
{
    public function buat_pertanyaan()
    {
    

    public function buat_pertanyaan(){
>>>>>>> 64c6bd020c62401922f038ce1ad4d55d2805ed4d
        return view('user.pertanyaan.buat');
    }
    public function buat_komen() // comment
    {
        return view('user.komentar.comment');
    }
    public function buat_komen1() // ke hal comment
    {
        return view('user.komentar.hal');
    }

    public function simpan_pertanyaan(Request $request)
    {
        $isi = $request->all();
        unset($isi['_token']);

        $tanya = Pertanyaan::create([
            'judul' => $isi['judul'],
            'isi' => $isi['isi'],
            'user_id' => $isi['user_id'],
            'created_at' => $isi['created_at'],
            'updated_at' => $isi['updated_at']
        ]);

        $tag_arr = explode(',', $isi['tag']);

        foreach ($tag_arr as $item) {
            $tag_arr_assoc['nama_tag'] = $item;
            $tag_multi[] = $tag_arr_assoc;
        }

        foreach ($tag_multi as $tag_in) {
            $tag = Tag::firstOrCreate($tag_in);
            $tanya->tag()->attach($tag->id);
        }

        return redirect('/home');
    }
}
