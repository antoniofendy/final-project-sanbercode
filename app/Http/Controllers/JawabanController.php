<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use \App\Pertanyaan;
use \App\Tag;
use \App\Vote_Pertanyaan;
use \App\Vote_Jawaban;
use \App\Jawaban;
use \App\User;
use \App\Pertanyaan_Tag;

use Carbon\Carbon; 

class JawabanController extends Controller
{
    
    //FUNCTION INDEX JAWABAN
    public function list_jawaban($user_id){

        $data_jawab = Jawaban::where('user_id', $user_id)->get();
        
        return view('user.jawaban.index', compact('data_jawab'));

    }

    public function jawab($pertanyaan_id){

        $data_tanya = Pertanyaan::find($pertanyaan_id);
        $data_user = User::find($data_tanya['user_id']);
        return view('user.jawaban.jawab', [
            'data_tanya' => $data_tanya,
            'data_user' => $data_user
        ]);

    }

    public function jawabcreate(Request $request){
        $isi = $request->all();
        unset($isi['_token']);
        $jawab = Jawaban::create($isi);

        Alert::info('Berhasil', 'Jawaban anda telah terkirim');


        return redirect('/pertanyaan/'. $isi['pertanyaan_id'] . '/detail');
    }

    //Bagian untuk CRUD JAWABAN - MAS SANI

    // edit jawaban
    public function form_edit_jawaban($jawaban_id){

        //mendapatkan data pertanyaan
        $data_jawab = Jawaban::find($jawaban_id);
        
        $user = User::find($data_jawab->user_id)->value('name');
        
        return view('user.jawaban.edit', compact('data_jawab', 'user'));
        
    }

    public function update_jawaban(Request $request) {

        $request->request->remove('_token');

        if(Auth::id() == $request->user_id){

            $info = Jawaban::whereId($request->id)->update($request->all());

            if($info == true){
                Alert::success('Berhasil', 'Berhasil update jawaban');
            }
            else{
                Alert::error('Gagal', 'Gagal update jawaban');
            }

            $data_tanya = Pertanyaan::where('user_id', $request->user_id)->get();
            return redirect('/jawaban/' . Auth::id());
        }
        else{
            Alert::error('Gagal', 'Tidak boleh update jawaban pengguna lain');
        }

        return redirect('/home');
    }

    // Function Hapus Jawaban
    public function hapus_jawaban($jawaban_id){

        $data_jawab = Jawaban::where('id', $jawaban_id)->first();

        $user_id = $data_jawab->user_id;

        if(Auth::id() == $user_id){

            $info = Jawaban::where('id', $jawaban_id)->delete();
            
            if($info == true){
                Alert::success('Berhasil', 'Berhasil menghapus jawaban');
            }
            else{
                Alert::error('Gagal', 'Gagal menghapus jawaban');
            }
        }
        else{
            Alert::error('Gagal', 'Tidak boleh menghapus jawaban pengguna lain');
        }

        return redirect('/home');
    
    }

}
