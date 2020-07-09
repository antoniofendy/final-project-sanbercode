@extends('layouts.app')

@section('navbar')
    <li class="nav-item mr-2">
        <a href="{{url('/user/pertanyaan/buat')}}"><button class="btn btn-secondary">Berikan Pertanyaan</button></a>
    </li>
    <li class="nav-item mr-2">
        <a href=""><button class="btn btn-secondary">Berikan Jawaban</button></a>
    </li>
    <li class="nav-item mr-2">
        <a href='/user/komentar/comment'><button class="btn btn-secondary">Berikan Komentar</button></a>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
