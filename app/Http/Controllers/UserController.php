<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\CanResetPassword;

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
    public function index() // comment
    {
        $data = User::find(Auth::id());
        return view('user.profil.index', compact('data'));
    }

    public function update(Request $request) // comment
    {
        $user = User::find(Auth::id());
        // JIKA PENGGUNA TIDAK MENGUBAH PASSWORD
        if(empty($request->old_password))
        {
            $user->update([
                "name" => $request->name,
                "email" => $request->email,
                "telepon" => $request->telepon,
                "alamat" => $request->alamat
            ]);

            Alert::success('Berhasil', 'Berhasil memperbarui data profil.');
            $user = User::find(Auth::id());
            return redirect('/profil');
        }
        // JIKA PENGGUNA MENGUBAH PASSWORD
        else
        {
            if(Hash::check($request->old_password, $user->password))
            {
                // JIKA PASSWORD BARU DAN PASSWORD KONFIRMASI SAMA
                if($request->new_password == $request->confirm_password)
                {
                    $user->update([
                        "name" => $request->name,
                        "email" => $request->email,
                        "password" => Hash::make($request->new_password),
                        "telepon" => $request->telepon,
                        "alamat" => $request->alamat
                    ]);

                    Alert::success('Berhasil', 'Berhasil memperbarui data profil.');
                    $user = User::find(Auth::id());
                    return redirect('/profil');
                }
                // JIKA PASSWORD BARU DAN PASSWORD KONFIRMASI BERBEDA
                else
                {
                    Alert::error('Gagal', 'Password baru dengan password konfirmasi berbeda.');
                    return redirect('/profil');
                }
            }
            Alert::error('Gagal', 'Password lama tidak sesuai.');
            return redirect('/profil');
        }
    }
    
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
                    Alert::error('Gagal', 'Minimal point reputasi downvote adalah 15.');
                }
            }


        }
        else{
            Alert::error('Gagal', 'Tidak dapat vote topik sendiri.');
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
                    Alert::error('Gagal', 'Minimal point reputasi downvote adalah 15.');
                }
            }

        }
        else{
            Alert::error('Gagal', 'Tidak dapat vote topik sendiri.');
        }
        $jwb = Jawaban::find($jawaban_id);
        return redirect('/pertanyaan/' . $jwb->pertanyaan_id . "/detail");
    }
}
