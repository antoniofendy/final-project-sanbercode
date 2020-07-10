<?php

    use Illuminate\Support\Facades\Auth;

?>

<div class="card main">
    <div class="card-body">
        <h5 class="card-title">Menu</h5>
        <div class="list-group">
            <a href="{{url('/')}}" class="list-group-item list-group-item-action">Home</a>
            <a href="{{url('/user/pertanyaan/buat')}}" class="list-group-item list-group-item-action">Buat Pertanyaan</a>
            <a href="{{url('/pertanyaan/'. Auth::id())}}" class="list-group-item list-group-item-action">Pertanyaan Anda</a>
            <a href="#" class="list-group-item list-group-item-action">Profil</a>
        </div>
    </div>
</div>