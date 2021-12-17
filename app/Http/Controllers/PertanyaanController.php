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

class PertanyaanController extends Controller
{
    //FUNCTION KE FORM PERTANYAAN
    public function buat_pertanyaan(){
        return view('user.pertanyaan.buat');
    }

    //FUNCTION KE SIMPAN PERTANYAAN
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

    //FUNCTION INDEX PERTANYAAN
    public function list_pertanyaan($user_id){
        $data_tanya = Pertanyaan::where('user_id', $user_id)->get();
        return view('user.pertanyaan.index', compact('data_tanya'));
    }

    //FUNCTION HAPUS PERTANYAAN
    public function hapus_pertanyaan($pertanyaan_id){

        $user = Pertanyaan::where('id', $pertanyaan_id)->first();
        $user_id = $user->user_id;
        if(Auth::id() == $user_id){
            
            // UPDATE REPUTASI PEMILIK PERTANYAAN
                // Mendapatkan data vote pertanyaan
                $vote_pertanyaan = Vote_Pertanyaan::where('pertanyaan_id', $pertanyaan_id)->count();

                // Mendapatkan data jumlah reputasi pemilik pertanyaan
                $data_reputasi_user = User::where('id', $user_id)->select('reputasi')->first();
                $data_reputasi_user = $data_reputasi_user['reputasi'];
                
                // Mengurangi data reputasi user dengan jumlah vote yang ia dapatkan dari pertanyaan tersebut.
                $data_reputasi_baru = $data_reputasi_user - ($vote_pertanyaan * 10);
                
                //Mengupdate data reputasi user di database
                User::where('id', $user_id)->update(['reputasi' => $data_reputasi_baru]);

            // UPDATE REPUTASI PENJAWAB DENGAN JAWABAN TERVERIFIKASI
                $jawaban_terverifikasi = Pertanyaan::where("pertanyaan_id", $pertanyaan_id)->join('jawaban', 'jawaban_id', '=', 'jawaban.id')->select("jawaban_id", "jawaban.user_id")->first();
                if (!empty($jawaban_terverifikasi['user_id']))
                {
                    // Mengurangi data reputasi user dengan 15.
                    $data_reputasi_user = User::where('id', $jawaban_terverifikasi['user_id'])->select('reputasi')->first();
                    $data_reputasi_user = $data_reputasi_user['reputasi'];
                    $data_reputasi_baru = $data_reputasi_user - 15;
                    //Mengupdate data reputasi user di database
                    User::where('id', $jawaban_terverifikasi['user_id'])->update(['reputasi' => $data_reputasi_baru]);
                }
                
            // UPDATE REPUTASI SETIAP PENJAWAB PERTANYAAN
                $list_jawaban_dari_pertanyaan = Jawaban::where("pertanyaan_id", $pertanyaan_id)->select("id", "user_id")->get();
                if(!empty($list_jawaban_dari_pertanyaan[0]))
                {
                    foreach ($list_jawaban_dari_pertanyaan as $jawaban) {
                        // Mencari tahu apakah jawaban sudah tervote atau belum
                        $id_jawaban = $jawaban['id'];
                        $id_penjawab = $jawaban['user_id'];
                        $data_vote = Vote_Jawaban::where("jawaban_id", $id_jawaban)->count();
                        
                        // Mengurangi data reputasi user dengan jumlah vote jawabannya.
                        $data_reputasi_user = User::where('id', $id_penjawab)->select('reputasi')->first();
                        $data_reputasi_user = $data_reputasi_user['reputasi'];
                        $data_reputasi_baru = $data_reputasi_user - $data_vote * 10;
                        //Mengupdate data reputasi user di database
                        User::where('id', $id_penjawab)->update(['reputasi' => $data_reputasi_baru]);
                    }
                }

            //Menghapus pertanyaan 
            $info = Pertanyaan::where('id', $pertanyaan_id)->delete();

            if($info == true){
                Alert::success('Berhasil', 'Berhasil menghapus pertanyaan');
            }
            else{
                Alert::error('Gagal', 'Gagal menghapus pertanyaan');
            }

            return redirect('/home');
        }
        else{
            Alert::error('Gagal', 'Tidak boleh menghapus pertanyaan pengguna lain');
        }

        return redirect('/home');
    }

    //FUNCTION EDIT PERTANYAAN
    public function form_edit_pertanyaan($pertanyaan_id){

        $user = Pertanyaan::where('id', $pertanyaan_id)->first();
        $user_id = $user->user_id;
        if(Auth::id() == $user_id){

            //mendapatkan data pertanyaan
            $data_tanya = Pertanyaan::find($pertanyaan_id);

            //mendapatkan data tag
            $tanya_tag = DB::table('pertanyaan_tag')
                        ->select('pertanyaan_tag.*', 'tag.nama_tag')
                        ->join('tag', 'pertanyaan_tag.tag_id', '=', 'tag.id')
                        ->where('pertanyaan_id', $pertanyaan_id)
                        ->get()
                        ;
            $data_tag = "";
            $tanya_tag = end($tanya_tag);
            foreach ($tanya_tag as $value) {
                if($value != end($tanya_tag)){
                    $data_tag .= $value->nama_tag . ",";
                }
                else{
                    $data_tag .= $value->nama_tag;
                }
            }

            //mendapatkan data user
            $user = User::find($data_tanya->user_id)->value('name');
            
            return view('user.pertanyaan.edit', 
                [
                    'data_tanya' => $data_tanya,
                    'data_tag' => $data_tag,
                    'data_user' => $user
                ]
            );
        }
        else{
            Alert::error('Gagal', 'Tidak boleh mengedit pertanyaan pengguna lain');
        }
        return redirect('/home');
    }

    public function store_edit_pertanyaan(Request $request){
        //Mengupdate data tabel pertanyaan
        $pertanyaan = Pertanyaan::find($request->pertanyaan_id);
        $pertanyaan->update([
            'updated_at' => $request->updated_at,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        $tag_arr = explode(',', $request->tag);
        
        foreach ($tag_arr as $item) {
            $tag_arr_assoc['nama_tag'] = $item;
            $tag_multi[] = $tag_arr_assoc;
        }        

        $tag_upd = [];
        foreach ($tag_multi as $tag_in) {
            $tag = Tag::firstOrCreate($tag_in);
            array_push($tag_upd, $tag->id);
        }

        $pertanyaan->tag()->sync($tag_upd);

        Alert::success('Berhasil', 'Berhasil mengedit pertanyaan');

        return redirect('/pertanyaan/' . Auth::id());
        
    }

}
