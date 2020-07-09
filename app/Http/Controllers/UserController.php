<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Pertanyaan;
use \App\Tag;

class UserController extends Controller
{
    public function buat_pertanyaan(){
        return view('user.pertanyaan.buat');
    }

    public function simpan_pertanyaan (Request $request){
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

        foreach($tag_multi as $tag_in){
            $tag = Tag::firstOrCreate($tag_in);
            $tanya->tag()->attach($tag->id);
        }

        return redirect('/home');

    }

}
