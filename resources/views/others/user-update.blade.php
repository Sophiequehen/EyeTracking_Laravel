@extends('layout.app')

@section('title')
Inscription
@endsection

@section('content')
<div class="container add-user">
    <div class="row justify-content-center">
        <div class="home_connect card">
            <section class="page-titles">
                <h2>Modifier un utilisateur</h2>
                <p>/</p>
            </section>
            <div class="card-body">
                <div class="container modify user">
                    <form method="POST" enctype="multipart/form-data" action="{{ action('UserController@update', [$user->id]) }}">
                        @csrf

                        <label for="name">{{ __('Nom') }}</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>
                        @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif


                        <label for="role">Rôle</label>
                        <select name="role" required>
                            <option value="{{ $roleUser->role_id }}" selected>{{ $roleUser->role_rolename }}</option>
                            @foreach($roles as $role)
                            @if($role->role_id !== $roleUser->role_id)
                            <option value="{{ $role->role_id }}">{{ $role->role_rolename }}</option>
                            @endif
                            @endforeach
                        </select>  

                        <label for="email" >{{ __('Adresse E-Mail') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif

                        <button type="submit" class="btn-outline add" id="btn-register">
                            {{ __("Modifier") }}
                        </button>
                    </form>
                    <a href="{{ route('index-users') }}" class="btn-outline cancel-user responsive">{{ __("Annuler") }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
