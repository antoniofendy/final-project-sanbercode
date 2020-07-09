<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    
    protected $table = "jawaban";
    protected $guarded = [];

    public function komen_jawab(){
        return $this->hasMany('App\Komen_Jawab');
    }

}
