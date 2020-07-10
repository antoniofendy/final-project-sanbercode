<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Pertanyaan;
use \App\User;
use \App\Jawaban;
use \App\Komen_Tanya;

class ForumController extends Controller
{
    
    public function index($pertanyaan_id){

        $data_tanya = Pertanyaan::find($pertanyaan_id);
        $data_user = User::find($data_tanya['user_id']);
        return view('user.detail_forum.index', [
            'data_tanya'=> $data_tanya,
            'data_user' => $data_user
        ]);

    }

    public function jawab($pertanyaan_id){

        $data_tanya = Pertanyaan::find($pertanyaan_id);
        $data_user = User::find($data_tanya['user_id']);
        return view('user.detail_forum.jawab', [
            'data_tanya' => $data_tanya,
            'data_user' => $data_user
        ]);

    }

    public function jawabcreate(Request $request){
        $isi = $request->all();
        unset($isi['_token']);
        $jawab = Jawaban::create($isi);

        return redirect('/pertanyaan/'. $isi['pertanyaan_id'] . '/detail');
    }

    public function jawab_tepat(Request $request){

        $jawaban = Jawaban::find($request->jawaban_id);

        //mengisi id jawaban tepat dari pertanyaan di tabel pertanyaan
        $pertanyaan = Pertanyaan::find($jawaban->pertanyaan_id);
        $pertanyaan->update(['jawaban_id' => $jawaban->id]);

        //menambahkan point reputasi ke pembuar jawaban
        $user = User::find($jawaban->user_id);
        $user->increment('reputasi', 15);

        return $this->index($pertanyaan->id); 

    }

    public function komentar_pertanyaan($pertanyaan_id) {
        $data_tanya = Pertanyaan::find($pertanyaan_id);
        $data_user = User::find($data_tanya['user_id']);
        return view('user.detail_forum.komentar', [
            'data_tanya' => $data_tanya,
            'data_user' => $data_user
        ]);
    }

    public function komentar_tanya_create(Request $request){
        $isi = $request->all();
        unset($isi['_token']);
         
        $komen_tanya = Komen_Tanya::create($isi);

        return redirect('/pertanyaan/'. $isi['pertanyaan_id'] . '/detail');
        
    }

}
