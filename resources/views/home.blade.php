<?php 

    use \App\Pertanyaan_Tag; 

?>

@extends('layouts.app')

@section('navbar')
    <li class="nav-item mr-2">
        <a href="{{url('/user/pertanyaan/buat')}}"><button class="btn btn-secondary">Berikan Pertanyaan</button></a>
    </li>
    <li class="nav-item">
        <a href=""><button class="btn btn-secondary">Berikan Jawaban</button></a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pertanyaan Terpopuler</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($data_tanya as $item)
                    <div class="card">
                        <div class="card-header">
                            Dari {{$item->name}}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$item->judul}}</h5>
                            <p p class="card-text">{!!$item->isi!!}</p>
                            
                            <?php
                                
                                $tag = Pertanyaan_Tag::where('pertanyaan_id', $item->id)
                                                        ->get();
                                dd($tag);

                            ?>
                            
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
