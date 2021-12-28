<?php 

    use Illuminate\Support\Facades\Auth;
    use \App\Pertanyaan_Tag; 
    use \App\Tag;
    use \App\User;
    use \App\Vote_Pertanyaan;
    use \App\Pertanyaan;
    use \App\Jawaban;
    use \App\Komen_Tanya;
    use \App\Komen_Jawab;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

?>

<?php

    function tgl_indonesia($tgl){
        $tanggal = substr($tgl, 8,2);
        $nama_bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $bulan = $nama_bulan[(substr($tgl, 5,2)-1)];
        $tahun = substr($tgl, 0,4);

        return ($tanggal." ".$bulan." ".$tahun);
    }

?>


@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-light">
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>
@endsection


<style>
    .card.main {
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

                {{-- @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif --}}

                <!-- BAGIAN PERTANYAAN -->
                <div class="card mb-2">
                    <div class="card-header bg-primary text-white">
                        <p style="display: inline-block;">Pertanyaan dari : {{$data_user->name}}</p>
                        @if ($data_tanya->user_id == Auth::id())
                        <a href="{{url('/pertanyaan/'. $data_tanya->id. '/hapus')}}"
                            style="float: right; display:inline; color:white;"><i class="fa fa-trash"
                                aria-hidden="true"></i> Hapus</a>
                        <a href="{{url('/pertanyaan/'. $data_tanya->id. '/edit')}}" class="mr-3"
                            style="float: right; display:inline; color:white;"><i class="fa fa-pencil"
                                aria-hidden="true"></i> Edit</a>
                        @endif
                    </div>
                    <div class="card-body  bg-secondary">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 text-center">
                                <div class="card border-0 bg-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{url('user/vote-tanya/' . $data_tanya->id . '/' . Auth::id() . '/up')}}"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-arrow-up"></i>
                                                </a>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <a href="#" class="btn btn-primary">
                                                    <?php
                                                                    $up_vote = DB::table('vote_pertanyaan')->where(['pertanyaan_id'=>$data_tanya->id, 'up_down'=>true])
                                                                            ->count();
                                                                    $down_vote = DB::table('vote_pertanyaan')->where(['pertanyaan_id'=>$data_tanya->id, 'up_down'=>false])
                                                                            ->count();
                                                                            
                                                                    echo $up_vote - $down_vote;

                                                                ?>
                                                </a>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <a href="{{url('user/vote-tanya/' . $data_tanya->id . '/' . Auth::id() . '/down')}}"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-arrow-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-12">
                                <h5 class="card-title" style="font-weight: bold">{{$data_tanya->judul}}</h5>
                                <span class="badge badge-pill badge-primary">
                                    Created : {{$data_tanya->created_at->diffForHumans()}}
                                </span>
                                <span class="badge badge-pill badge-primary">
                                    Updated : {{$data_tanya->updated_at->diffForHumans()}}
                                </span>
                                <hr>
                                <p p class="card-text">{!!$data_tanya->isi!!}</p>
                                <div class="tag">
                                    <?php
                                                
                                                    $tag = Pertanyaan_Tag::where('pertanyaan_id', $data_tanya->id)
                                                                            ->get();
                                                                            
                                                ?>
                                    @foreach ($tag as $tag_id)
                                    <?php
                                                    $tag_name = Tag::find($tag_id->tag_id);
                                            ?>
                                    <a href="{{url('/search/'.trim($tag_name->nama_tag))}}"
                                        class="btn btn-info">{{$tag_name->nama_tag}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <a href="{{url('/jawab/'. $data_tanya->id)}}" class="btn btn-success mt-3 mr-2"
                            style="float: right"><i class="fa fa-reply"></i> Jawab</a>
                        <a href="{{url('/komen-tanya/'. $data_tanya->id)}}" class="btn btn-success mt-3 mr-2"
                            style="float: right"><i class="fa fa-comment"></i> Komentar</a>
                    </div>
                </div>
                <!-- Bagian Akhir pertanyaan -->

                <!-- Bagian komen pertanyaan -->
                <?php
                                $data_komen_tanya = Komen_Tanya::whereIn('pertanyaan_id', [$data_tanya->id])->get();
                                
                            ?>

                @foreach ($data_komen_tanya as $item)

                <?php
                                    $user = User::find($item->user_id);
                                ?>

                <div class="card mb-2 ml-5">
                    <div class="card-header bg-primary text-white">
                        Komentar dari : {{$user->name}}
                    </div>
                    <div class="card-body bg-secondary">
                        <div class="row">
                            <div class="col-md-10 col-sm-12">
                                <span class="badge badge-pill badge-primary">
                                    {{$item->created_at->diffForHumans()}}
                                </span>
                                <p p class="card-text">{!!$item->isi!!}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
                <!-- Bagian akhir komen pertanyaan -->


                <!-- Bagian Jawaban -->
                <?php
                                $data_jawab = Pertanyaan::find($data_tanya->id)->jawab;
                            ?>

                @foreach ($data_jawab as $item)

                <?php
                            $user = User::find($item->user_id);
                        ?>

                <div class="card mb-2">
                    <div class="card-header bg-primary text-white">
                        <p style="display: inline-block;" class="">Jawaban dari : {{$user->name}}</p>
                        @if ($item->user_id == Auth::id())
                        <a href="{{url('/hapus-jawaban/'. $item->id)}}"
                            style="float: right; display:inline; color:#f4f6ff;"><i class="fa fa-trash"
                                aria-hidden="true"></i> Hapus</a>
                        <a href="{{url('/edit-jawaban/'. $item->id)}}" class="mr-3"
                            style="float: right; display:inline; color:#f4f6ff;"><i class="fa fa-pencil"
                                aria-hidden="true"></i> Edit</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 text-center">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{url('user/vote-jawab/' . $item->id . '/' . Auth::id() . '/up')}}"
                                                    class="btn btn-primary">
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
                                                <a href="{{url('user/vote-jawab/' . $item->id . '/' . Auth::id() . '/down')}}"
                                                    class="btn btn-primary">
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
                                <p class="card-text">{!!$item->description!!}</p>
                            </div>

                        </div>
                        <a href="{{url('/komen-jawab/'. $item->id)}}" class="btn btn-success mt-3 mr-2"
                            style="float: right"><i class="fa fa-comment"></i> Komentar</a>
                        {{-- <a href="{{url('/komen-tanya/'. $item->id)}}" class="btn btn-success mt-3 mr-2"
                            style="float: right"><i class="fa fa-comment"></i> Komentar</a> --}}
                        @if (Auth::id() == $data_tanya->user_id)
                        @if (empty($data_tanya->jawaban_id))
                        <a href="{{url('/jawaban-tepat/'. $item->id)}}" class="btn btn-success mt-3 mr-2"
                            style="float: right"><i class="fa fa-star"></i> Jawaban Tepat</a>
                        @else
                        @if ($data_tanya->jawaban_id == $item->id)
                        <a href="#" class="btn btn-primary mt-3 mr-2" style="float: right"><i
                                class="fa fa-check-square"></i> Jawaban Terverikasi</a>
                        @endif
                        @endif
                        @else
                        @if ($data_tanya->jawaban_id == $item->id)
                        <a href="#" class="btn btn-primary mt-3 mr-2 disabled" style="float: right"><i
                                class="fa fa-check-square"></i> Jawaban Terverikasi</a>
                        @endif
                        @endif
                    </div>
                </div>

                <!-- BAGIAN KOMENTAR JAWABAN -->
                <?php
                                $komen_jawab = Jawaban::find($item->id)->komen_jawab;
                            ?>

                @foreach ($komen_jawab as $komen_jwb)
                <?php
                                        $user = User::find($komen_jwb->user_id);

                                        // {{dd($user);}}

                                    ?>
                <div class="card mb-2 ml-5">
                    <div class="card-header bg-success">
                        Komentar Dari : {{$user->name}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 col-sm-12">
                                <span class="badge badge-pill badge-primary">
                                    {{$komen_jwb->created_at->diffForHumans()}}
                                </span>
                                <p p class="card-text">{!!$komen_jwb->isi!!}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach

                @endforeach

                <!-- Bagian akhir jawaban -->


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