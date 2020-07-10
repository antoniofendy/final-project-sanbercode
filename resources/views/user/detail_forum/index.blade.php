<?php 

    use Illuminate\Support\Facades\Auth;
    use \App\Pertanyaan_Tag; 
    use \App\Tag;
    use \App\User;
    use \App\Vote_Pertanyaan;
    use \App\Pertanyaan;
    use \App\Jawaban;
    use \App\Komen_Tanya;
    use Illuminate\Support\Facades\DB;

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
                        <div class="card-header"></div>
                        
                        <div class="card-body">
                            {{-- @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif --}}
                            <div class="card mb-2">
                                <div class="card-header bg-warning">
                                    Dari : {{$data_user->name}}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 text-center">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="{{url('user/vote-tanya/' . $data_tanya->id . '/' . Auth::id() . '/up')}}" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-up"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="#" class="btn btn-secondary">
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
                                                            <a href="{{url('user/vote-tanya/' . $data_tanya->id . '/' . Auth::id() . '/down')}}" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-down"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-12">
                                            <h5 class="card-title" style="font-weight: bold">{{$data_tanya->judul}}</h5>
        
                                            <p p class="card-text">{!!$data_tanya->isi!!}</p>
                                            <div class="tag">
                                                <?php
                                                
                                                    $tag = Pertanyaan_Tag::where('pertanyaan_id', $data_tanya->id)
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
                                    
                                    <a href="{{url('/jawab/'. $data_tanya->id)}}" class="btn btn-success mt-3 mr-2" style="float: right"><i class="fa fa-reply"></i> Jawab</a>
                                    <a href="{{url('/komentar-tanya/'. $data_tanya->id)}}" class="btn btn-success mt-3 mr-2" style="float: right"><i class="fa fa-comment"></i> Komentar</a>
                                </div>
                            </div>

                            {{-- Komentar Tanya --}}
                            <?php

                                $data_komen = Komen_Tanya::whereIn('pertanyaan_id', [$data_tanya->id])->get();
                                // {{dd($data_komen);}}
                            ?>

                            @foreach ($data_komen as $item) 
                                
                                <?php
                                    $user = User::find($item->user_id);
                                ?>

                                <div class="card mb-2 ml-5">
                                    <div class="card-header bg-success">
                                        Komentar Dari : {{$user->name}}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center">
                                                <div class="card border-0">
                                                    <div class="card-body">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-10 col-sm-12">
                                                <p p class="card-text">{!!$item->isi!!}</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>  

                           @endforeach 
                           {{-- End Komentar Tanya --}}


                            <!-- Bagian Jawaban -->
                            <?php
                                $data_jawab = Pertanyaan::find($data_tanya->id)->jawab;
                            ?>

                            @foreach ($data_jawab as $item)
                                
                                <?php
                                    $user = User::find($item->user_id);
                                ?>

                            <div class="card mb-2">
                                <div class="card-header bg-info">
                                    Dari : {{$user->name}}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 text-center">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="{{url('user/vote-jawab/' . $item->id . '/' . Auth::id() . '/up')}}" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-up"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <a href="#" class="btn btn-secondary">
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
                                                            <a href="{{url('user/vote-jawab/' . $item->id . '/' . Auth::id() . '/down')}}" class="btn btn-secondary">
                                                                <i class="fa fa-arrow-down"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-12">
                                            <h5 class="card-title" style="font-weight: bold">{{$item->judul}}</h5>
                                            <p p class="card-text">{!!$item->description!!}</p>
                                        </div>
                                    </div>
                                    
                                    <a href="{{url('/komentar-tanya/'. $item->id)}}" class="btn btn-success mt-3 mr-2" style="float: right"><i class="fa fa-comment"></i> Komentar</a>
                                </div>
                            </div>
                                
                            @endforeach
                            <!-- Bagian akhir jawaban -->
                            
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
