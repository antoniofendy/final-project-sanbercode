<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = "pertanyaan";

    protected $guarded = [];

    public function tag(){
        return $this->belongsToMany('\App\Tag', 'pertanyaan_tag', 'pertanyaan_id', 'tag_id');
    }

    public function jawab(){
        return $this->hasMany('App\Jawaban', 'pertanyaan_id');
    }

    public function komen_tanya(){
        return $this->hasMany('App\Komen_Tanya');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
