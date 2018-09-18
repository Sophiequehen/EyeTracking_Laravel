@extends('layout.app')

@section('title')
Utilisateurs
@endsection

@section('content')

@if ($message = Session::get('update'))
<div class="alert alert-success alert-dismissible" role="alert">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

<div class="container index-users">
    <div class="row justify-content-center">
        <div class="home_connect card">
            <section class="page-titles">
                <h2>Utilisateurs</h2>
                <p>/</p>
            </section>
            <div class="card-body">
                <div class="container modify users">
                    @csrf
                    @foreach($users as $user)
                    <div class="card-body users responsive">
                        @foreach($roles as $role)
                        @if($user->fk_role_id === $role->role_id)
                        <p>{{ $user->name }} / <span>{{ $role->role_rolename }}</span></p>
                        @endif
                        @endforeach
                        <a href="{{ route('update-user', $user->id) }}"><i class="material-icons">edit</i></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
