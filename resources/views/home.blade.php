<?php 

    use \App\Pertanyaan_Tag; 
    use \App\Tag;
    use Illuminate\Support\Facades\DB;

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


<style>

    .card.main{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

</style>

@section('content')
<div class="row p-2">

    <div class="col-md-2 mb-2">
        <div class="card main bg-warning">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-2">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card main">
                        <div class="card-header">Pertanyaan Terpopuler</div>
        
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
        
                            @foreach ($data_tanya as $item)
                            <div class="card mb-2">
                                <div class="card-header">
                                    Dari {{$item->name}}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 text-center">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-up"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="" class="btn btn-secondary">
                                                                15
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-down"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-12">
                                            <h5 class="card-title">{{$item->judul}}</h5>
        
                                            <p p class="card-text">{!!$item->isi!!}</p>
                                            <div class="tag">
                                                <?php
                                                
                                                    $tag = Pertanyaan_Tag::where('pertanyaan_id', $item->id)
                                                                            ->get();
                                                ?>
                                                @foreach ($tag as $tag_id)
                                                    <?php
                                                        $tag_name = DB::table('tag')
                                                                ->select(DB::raw('nama_tag'))
                                                                ->where('id', $tag_id->id)->get();
                                                    ?>
                                                    <button type="button" class="btn btn-info">{{$tag_name[0]->nama_tag}}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="#" class="btn btn-success mt-3" style="float: right"><i class="fa fa-eye"></i> Detail</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-2">
            <div class="card main bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        </div>

</div>

@endsection
