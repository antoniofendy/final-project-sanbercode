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
    public function buat_komen() // comment
    {
        return view('user.komentar.comment');
    }
    public function buat_komen1() // ke hal comment
    {
        return view('user.komentar.hal');
    }

    

    public function vote_tanya(Request $request, $pertanyaan_id, $user_id, $vote){

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
                else{
                    Alert::error('Gagal', 'Minimal point reputasi vote down adalah 15');
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
}
