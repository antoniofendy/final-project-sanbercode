<?php

    use Illuminate\Support\Facades\Auth;

    use Carbon\Carbon;
    $current_date_time = Carbon::now()->toDateTimeString(); 

?>

@extends('layouts.app')

@section('content')
<div class="ml-2 ">
    
    <div class="row justify-content-center">
             <div class="col-md-9 ml-4">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>ID</th>
                <th>Judul Pertanyaan</th>
                <th>Isi Pertanyaan</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <td></td> 
                <td></td>   
                <td></td>  
                <td>
                    <a href='/user/komentar/hal'><button class="btn btn-secondary">comment</button></a>
                </td>
            </tbody>
                </table>
</div>               
@endsection
