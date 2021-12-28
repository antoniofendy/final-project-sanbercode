<?php 

    use Illuminate\Support\Facades\Auth;
    $user = Auth::user(); 

?>

<h3 class="card-title">{{$user->name}}</h3>
<hr>
<h6 class="card-subtitle mb-2 text-muted"></h6>
<p class="card-text text-center">Point reputasimu saat ini : </p>
<h2 class="text-center" style="color: darkslateblue"><b>{{$user->reputasi}}</b></h2>
<hr>
{{-- <a href="#" class="card-link">Card link</a>
<a href="#" class="card-link">Another link</a> --}}