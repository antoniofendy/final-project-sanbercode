<?php 

    use Illuminate\Support\Facades\Auth;
    use \App\Pertanyaan_Tag; 
    use \App\Tag;
    use \App\Vote_Pertanyaan;
    use \App\Pertanyaan;
    use Illuminate\Support\Facades\DB;
    use \App\User;
?>

@extends('layouts.app')

<style>

    .card.main{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

</style>

@section('content')
<div class="row p-2">

    <div class="col-md-2 mb-2">
        @include('layouts.partials.leftbar')
    </div>

    <div class="col-md-8 mb-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                    <div class="h3 mb-3">Jawaban Anda</div>
                    
                        {{-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif --}}
                        
                        @if (empty(end($data_jawab)))
                            <p class="card-text">Maaf, Anda belum pernah memberikan jawaban.</p>
                        @else
                            @foreach ($data_jawab as $item)
                            <div class="card mb-2">
                                <div class="card-header bg-primary">
                                    <a href="{{url('/hapus-jawaban/'. $item->id)}}" style="float: right; display:inline; color:#f4f6ff;"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
                                    <a href="{{url('/edit-jawaban/'. $item->id)}}" class="mr-3" style="float: right; display:inline; color:#f4f6ff;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                    <a href="{{url('/pertanyaan/'. $item->pertanyaan_id. '/detail')}}" class="mr-3" style="float: right; display:inline; color:#f4f6ff;"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                                </div>
                                <div class="card-body bg-secondary">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 text-center">
                                            <div class="card border-0 bg-secondary">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="{{url('user/vote-jawab/' . $item->id . '/' . Auth::id() . '/up')}}" class="btn btn-primary">
                                                                <i class="fa fa-arrow-up"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="#" class="btn btn-primary">
                                                                <?php
                                                                    
                                                                    $up_vote = DB::table('vote_jawaban')->where(['jawaban_id'=>$item->id, 'up_down'=>true])
                                                                            ->count();
                                                                    $down_vote = DB::table('vote_jawaban')->where(['jawaban_id'=>$item->id, 'up_down'=>false])
                                                                            ->count();
                                                                            
                                                                    echo $up_vote - $down_vote;
                                                                ?>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="{{url('user/vote-jawab/' . $item->id . '/' . Auth::id() . '/down')}}" class="btn btn-primary">
                                                                <i class="fa fa-arrow-down"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-12">
                                            <h5 class="card-title" style="font-weight: bold">{{$item->judul}}</h5>
                                            <span class="badge badge-pill badge-primary">
                                                {{$item->created_at->diffForHumans()}}
                                            </span>
                                            <hr>
                                            <p class="card-text">{!!$item->description!!}</p>  
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        
            </div>
        </div>
        </div>
        
        <div class="col-md-2 mb-2">
            <div class="card main">
                <div class="card-body">
                    @include('layouts.partials.rightbar')
                </div>
            </div>
        </div>

</div>

@endsection
