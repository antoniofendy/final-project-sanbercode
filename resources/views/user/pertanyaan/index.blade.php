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
                <div class="card main">
                    <div class="card-header">Pertanyaan Anda</div>
                    <div class="card-body">
                        {{-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif --}}
                        
                        @if (empty(end($data_tanya)))
                            <p class="card-text">Maaf, anda belum memiliki pertanyaan</p>
                        @else
                            @foreach ($data_tanya as $item)
                            <div class="card mb-2">
                                <div class="card-header bg-warning">
                                    <a href="{{url('/pertanyaan/'. $item->id. '/hapus')}}" style="float: right; display:inline;"><i class="fa fa-trash" aria-hidden="true"></i><b> Hapus</b></a>
                                    <a href="{{url('/pertanyaan/'. $item->id. '/edit')}}" class="mr-3" style="float: right; display:inline;"><i class="fa fa-pencil" aria-hidden="true"></i><b> Edit</b></a>
                                    <a href="{{url('/pertanyaan/'. $item->id. '/detail')}}" class="mr-3" style="float: right; display:inline;"><i class="fa fa-eye" aria-hidden="true"></i><b> Detail</b></a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 text-center">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="{{url('user/vote-tanya/' . $item->id . '/' . Auth::id() . '/up')}}" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-up"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="#" class="btn btn-secondary">
                                                                <?php
                                                                    
                                                                    $up_vote = DB::table('vote_pertanyaan')->where(['pertanyaan_id'=>$item->id, 'up_down'=>true])
                                                                            ->count();
                                                                    $down_vote = DB::table('vote_pertanyaan')->where(['pertanyaan_id'=>$item->id, 'up_down'=>false])
                                                                            ->count();
                                                                            
                                                                    echo $up_vote - $down_vote;

                                                                ?>
                                                            </a>
                                                        </div>
                                                        
                                                        <div class="col-12 mt-3">
                                                            <a href="{{url('user/vote-tanya/' . $item->id . '/' . Auth::id() . '/down')}}" class="btn btn-secondary">
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
                                                Created : {{$item->created_at->diffForHumans()}}
                                            </span>
                                            <span class="badge badge-pill badge-primary">
                                                Updated : {{$item->updated_at->diffForHumans()}}
                                            </span>
                                            <p p class="card-text">{!!$item->isi!!}</p>
                                            <div class="tag">
                                                <?php
                                                    
                                                    $tag = Pertanyaan_Tag::where('pertanyaan_id', $item->id)
                                                                            ->get();
                                                                            
                                                ?>
                                                @foreach ($tag as $tag_id)
                                                    <?php
                                                        $tag_name = Tag::find($tag_id->tag_id);
                                                    ?>
                                                        <button type="button" class="btn btn-info">{{$tag_name->nama_tag}}</button>
                                                    
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        
                    </div>
                </div>
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
