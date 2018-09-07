@extends('layout.app')

@section('title')
Inscription
@endsection

@section('content')
<div class="container add-user">
    <div class="row justify-content-center">
        <div class="home_connect card">
            <section class="page-titles">
                <h2>Ajouter un utilisateur</h2>
                <p>/</p>
            </section>
            <div class="card-body">
                <div class="container modify">
                    <form method="POST" enctype="multipart/form-data" action="{{ action('UserController@store') }}">
                        @csrf

                        <label for="name">{{ __('Nom') }}</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif


                        <label for="name">Rôle</label>
                        <select name="role" required>
                            <option selected disabled>Sélectionner un rôle</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->role_id }}">{{ $role->role_rolename }}</option>
                            @endforeach
                        </select>                               


                        <label for="email" >{{ __('Adresse E-Mail') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif

                        <label for="password">{{ __('Mot de passe') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif

                        <label for="password-confirm">{{ __('Confirmez le mot de Passe') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        <button type="submit" class="btn-outline add" id="btn-register">
                            {{ __("Inscription") }}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
