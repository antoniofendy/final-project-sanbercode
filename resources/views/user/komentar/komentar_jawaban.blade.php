<?php 

    use Illuminate\Support\Facades\Auth;
    use \App\Jawaban; 
    use Illuminate\Support\Facades\DB;
    use \App\User;

    use Carbon\Carbon;
    $current_date_time = Carbon::now()->toDateTimeString(); 

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

<!DOCTYPE HTML>
@extends('layouts.app')
< @section('navbar') <nav class="navbar navbar-light">
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
    <div class="row p-2 m-0">

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
                    <div class="card mb-2">
                        <div class="card-header bg-primary text-white">
                            Dari: {{$data_user->name}}  <span class="badge bg-white text-primary">Reputasi: {{$data_user->reputasi}}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 col-sm-12">

                                    <p p class="card-text">{!!$data_jawab->description!!}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header bg-primary text-white">
                    Komentar Kamu
                </div>
                <div class="card-body">
                    <form method="post" action="{{url('/komen-jawab')}}">
                        @csrf
                        <?php
                                $user = User::find(Auth::id());
                            ?>
                        <input type="hidden" name="created_at" value="{{$current_date_time}}">
                        <input type="hidden" name="updated_at" value="{{$current_date_time}}">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="jawaban_id" value="{{$data_jawab->id}}">
                        <input type="hidden" name="pertanyaan_id" value="{{$data_jawab->pertanyaan_id}}">
                        <div class="form-group">
                            <label for="isi"><b>Isi Komentar</b></label>
                            <textarea style="height: 200px" name="isi"
                                class="form-control my-editor">{!! old('isi', $isi ?? '') !!}</textarea>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-outline-success">Submit komentar</button>
                        </div>
                    </form>
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

    @push('scripts')

    <script>
        var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    plugins: [
    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen",
    "insertdatetime media nonbreaking save table contextmenu directionality",
    "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
    if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
    } else {
        cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
    });
    }
};

tinymce.init(editor_config);
    </script>

    @endpush