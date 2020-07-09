<?php

    use Illuminate\Support\Facades\Auth;
    
    use Carbon\Carbon;
    $current_date_time = Carbon::now()->toDateTimeString(); 

?>

@extends('layouts.app')

@section('title', 'Buat Pertanyaan')

@section('content')

    <form method="post" action="{{url('/user/pertanyaan/buat')}}">
        @csrf
        <input type="hidden" name="created_at" value="{{$current_date_time}}">
        <input type="hidden" name="updated_at" value="{{$current_date_time}}">
        <input type="hidden" name="user_id" value="{{Auth::id()}}">
        <div class="form-group">
            <label for="judul"><b>Judul Pertanyaan</b></label>
            <input type="text" name="judul" class="form-control" placeholder="ex: Cara menggunakan Laravel" size="20" required>
        </div>
        <div class="form-group">
            <label for="isi"><b>Isi Pertanyaan</b></label>
            <textarea name="isi" class="form-control my-editor">{!! old('isi', $isi ?? '') !!}</textarea>
        </div>
        <div class="form-group">
            <label for="judul"><b>Tag</b></label>
            <input type="text" name="tag" class="form-control" placeholder="ex: javascript,laravel,..." size="20" required>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-primary">Buat Pertanyaan</button>
        </div>
    </form>


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