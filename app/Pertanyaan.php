<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = "pertanyaan";

    protected $guarded = [];

    public function tag(){
        return $this->belongsToMany('\App\Tag', 'pertanyaan_tag', 'user_id', 'tag_id');
    }

}
