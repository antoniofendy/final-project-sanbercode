<?php 

    use Illuminate\Support\Facades\Auth;
    use \App\Pertanyaan_Tag; 
    use \App\Tag;
    use \App\Vote_Pertanyaan;
    use \App\Pertanyaan;
    use Illuminate\Support\Facades\DB;
    use \App\User;
    use Carbon\Carbon;
?>

@extends('layouts.app')

<style>
    .card.main {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .pagination {
        margin: 0 auto;

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

                <div class="h3 mb-3">Profil Anda</div>
                <form method="POST" action="{{url('/profil/update')}}">
                    @csrf
                    <?php 
                        date_default_timezone_set('Asia/Jakarta');
                        $time = date('Y-m-d H:i:s');
                    ?>
                    <input type="hidden" name="updated_at" value="{{$time}}">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ $data['name'] }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                            }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $data['email'] }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="old-password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
                            }}</label>

                        <div class="col-md-6">
                            <input id="old-password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="old_password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new-password" class="col-md-4 col-form-label text-md-right">{{ __('New
                            Password') }}</label>

                        <div class="col-md-6">
                            <input id="new-password" type="password" class="form-control" name="new_password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirm-password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm
                            Password') }}</label>

                        <div class="col-md-6">
                            <input id="confirm-password" type="password" class="form-control" name="confirm_password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="telepon" class="col-md-4 col-form-label text-md-right">Phone</label>

                        <div class="col-md-6">
                            <input id="telepon" type="number" class="form-control" name="telepon"
                                value="{{$data['telepon']}}" required>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Address</label>

                        <div class="col-md-6">
                            <textarea name="alamat" class="form-control" cols="30" rows="5"
                                required>{{$data['alamat']}}</textarea>
                        </div>

                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
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