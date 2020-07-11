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

include('ForumController.php');

class UserController extends Controller
{
    
    public function buat_pertanyaan(){
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

        Alert::info('Berhasil', 'Pertanyaan berhasil dikirim');


        return redirect('/home');
    }

    public function vote_tanya($pertanyaan_id, $user_id, $vote){

        $cek_vote = Vote_Pertanyaan::where(['pertanyaan_id' => $pertanyaan_id,'user_id'=>$user_id])->first();
        $get_user_id = DB::table('pertanyaan')->where('id', $pertanyaan_id)->value('user_id');

        if(Auth::check() && $get_user_id != $user_id){

            if($vote == 'up'){

                $vote = true;
                
                if(empty($cek_vote) ){
                    $current_date_time = Carbon::now()->toDateTimeString();
                    
                    $simpan = new Vote_Pertanyaan;
                        $simpan->up_down = true;
                        $simpan->user_id = $user_id;
                        $simpan->pertanyaan_id = $pertanyaan_id;
                    $simpan->save();

                    //menambah reputasi si pembuat pertanyaan
                    $get_user = User::find($get_user_id);
                    $incr_point = $get_user->reputasi + 10;
                    $get_user->update(['reputasi' => $incr_point]);
                    
                }
                else{
                    
                    if($cek_vote->up_down == false){
                        $cek_vote->update(['up_down' => true]);

                        //menambah reputasi si pembuat pertanyaan
                        $get_user = User::find($get_user_id);
                        $incr_point = $get_user->reputasi + 10;
                        $get_user->update(['reputasi' => $incr_point]);
                    }

                }

            }
            else{
                $voter = User::find($user_id);
                $reputasi_voter = $voter->reputasi;
                if($reputasi_voter >= 15){
                    $vote = false;

                    if(empty($cek_vote)){
                        $current_date_time = Carbon::now()->toDateTimeString();
                        
                        $simpan = new Vote_Pertanyaan;
                            $simpan->up_down = false;
                            $simpan->user_id = $user_id;
                            $simpan->pertanyaan_id = $pertanyaan_id;
                        $simpan->save();

                        //mengurangi reputasi si pemberi vote
                        $get_user = User::find($user_id);
                        $incr_point = $get_user->reputasi - 1;
                        $get_user->update(['reputasi' => $incr_point]);
                        
                    }
                    else{
                        
                        if($cek_vote->up_down == true){
                            $cek_vote->update(['up_down' => false]);
                            
                            //mengurangi reputasi si pemberi vote
                            $get_user = User::find($user_id);
                            $incr_point = $get_user->reputasi - 1;
                            $get_user->update(['reputasi' => $incr_point]);
                        }

                    }
                }
            }


        }
        else{
            Alert::error('Gagal', 'Tidak boleh vote pada pertanyaan sendiri');
        }
        return redirect('/pertanyaan/'. $pertanyaan_id . '/detail');
    }
    
    public function vote_jawab($jawaban_id, $user_id, $vote){
        $cek_vote = Vote_Jawaban::where(['jawaban_id' => $jawaban_id,'user_id'=>$user_id])->first();
        $get_user_id = DB::table('jawaban')->where('id', $jawaban_id)->value('user_id');

        if(Auth::check() && $get_user_id != $user_id){

            if($vote == 'up'){

                $vote = true;
                
                if(empty($cek_vote) ){
                    $current_date_time = Carbon::now()->toDateTimeString();
                    
                    $simpan = new Vote_Jawaban;
                        $simpan->up_down = true;
                        $simpan->user_id = $user_id;
                        $simpan->jawaban_id = $jawaban_id;
                    $simpan->save();

                    //menambah reputasi si pembuat jawaban
                    $get_user = User::find($get_user_id);
                    $incr_point = $get_user->reputasi + 10;
                    $get_user->update(['reputasi' => $incr_point]);
                    
                }
                else{
                    
                    if($cek_vote->up_down == false){
                        $cek_vote->update(['up_down' => true]);

                        //menambah reputasi si pembuat jawaban
                        $get_user = User::find($get_user_id);
                        $incr_point = $get_user->reputasi + 10;
                        $get_user->update(['reputasi' => $incr_point]);
                    }

                }

            }
            else{
                $voter = User::find($user_id);
                $reputasi_voter = $voter->reputasi;
                if($reputasi_voter >= 15){
                    $vote = false;

                    if(empty($cek_vote)){
                        $current_date_time = Carbon::now()->toDateTimeString();
                        
                        $simpan = new Vote_Jawaban;
                            $simpan->up_down = false;
                            $simpan->user_id = $user_id;
                            $simpan->jawaban_id = $jawaban_id;
                        $simpan->save();

                        //mengurangi reputasi si pemberi vote
                        $get_user = User::find($user_id);
                        $incr_point = $get_user->reputasi - 1;
                        $get_user->update(['reputasi' => $incr_point]);
                        
                    }
                    else{
                        
                        if($cek_vote->up_down == true){
                            $cek_vote->update(['up_down' => false]);
                            
                            //mengurangi reputasi si pemberi vote
                            $get_user = User::find($user_id);
                            $incr_point = $get_user->reputasi - 1;
                            $get_user->update(['reputasi' => $incr_point]);
                        }

                    }
                }
                else {
                    Alert::error('Gagal', 'Minimal point reputasi vote down adalah 15');
                }
            }


        }
        else{
            Alert::error('Gagal', 'Tidak boleh vote pada jawaban sendiri');
        }
        $jwb = Jawaban::find($jawaban_id);
        return redirect('/pertanyaan/' . $jwb->pertanyaan_id . "/detail");
    }

    public function list_pertanyaan($user_id){
        $data_tanya = Pertanyaan::where('user_id', $user_id)->get();
        return view('user.pertanyaan.index', compact('data_tanya'));
    }


    //FUNCTION HAPUS PERTANYAAN
    public function hapus_pertanyaan($pertanyaan_id){

        $user = Pertanyaan::where('id', $pertanyaan_id)->first();
        $user_id = $user->user_id;
        if(Auth::id() == $user_id){
            $info = Pertanyaan::where('id', $pertanyaan_id)->delete();

            if($info == true){
                Alert::success('Berhasil', 'Berhasil menghapus pertanyaan');
            }
            else{
                Alert::error('Gagal', 'Gagal menghapus pertanyaan');
            }

            $data_tanya = Pertanyaan::where('user_id', $user_id)->get();
            return view('user.pertanyaan.index', compact('data_tanya'));
        }
        else{
            Alert::error('Gagal', 'Tidak boleh menghapus pertanyaan pengguna lain');
        }

        return redirect('/home');
    }

    //FUNCTION EDIT PERTANYAAN
    public function form_edit_pertanyaan($pertanyaan_id){

        //mendapatkan data pertanyaan
        $data_tanya = Pertanyaan::find($pertanyaan_id);

        //mendapatkan data tag
        $tanya_tag = DB::table('pertanyaan_tag')
                    ->select('pertanyaan_tag.*', 'tag.nama_tag')
                    ->join('tag', 'pertanyaan_tag.tag_id', '=', 'tag.id')
                    ->where('pertanyaan_id', $pertanyaan_id)
                    ->get()
                    ;
        
        $user = User::find($data_tanya->user_id)->value('name');
        
        return view('user.pertanyaan.edit', compact('data_tanya', 'tanya_tag', 'user'));
        
    }

    //Bagian untuk CRUD JAWABAN - MAS SANI

}
