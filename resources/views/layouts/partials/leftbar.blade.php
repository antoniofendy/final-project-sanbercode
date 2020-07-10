<?php

    use Illuminate\Support\Facades\Auth;

?>

<div class="card main">
    <div class="card-body">
        <h5 class="card-title">Menu</h5>
        <div class="btn-group-vertical">
            <a href="{{url('/user/pertanyaan/buat')}}" class="mb-2"><button class="btn btn-secondary">Berikan Pertanyaan</button></a>
            <a href="" class="mb-2"><button class="btn btn-secondary">Berikan Jawaban</button></a>
            <a href="{{url('/pertanyaan/'. Auth::id())}}" class="mb-2"><button class="btn btn-secondary">Pertanyaan Anda</button></a>
        </div>
    </div>
</div>