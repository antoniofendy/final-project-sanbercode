@extends('adminlte.master')

@section('title', 'Home')

@section('konten')
    <div class="container mb-3">
        <a href="{{url('/pertanyaan/create')}}"><button type="button" class="btn btn-warning btn-lg">Buat Pertanyaan</button></a>
        <a href="{{url('/beri-jawaban')}}"><button type="button" class="btn btn-info btn-lg">Berikan Jawaban</button></a>
    </div>
    <div class="container">
        <div class="card">
            <h5 class="card-header">Pertanyaan Terpopuler</h5>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($tanya as $item)
                        <a href="{{url('/jawaban/'. $item->id)}}">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$item->judul}}
                                <span class="badge badge-primary badge-pill">{{$item->jml_jawaban}}</span>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

