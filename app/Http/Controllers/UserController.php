<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('others.users_index', ['users' => $users, 'roles' => $roles]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user-> name = request('name');
        $user-> fk_role_id = request('role');
        $user-> email = request('email');
        $user-> password = Hash::make(request('password'));
        $user->save();
        return redirect()->back()->with('add','Utilisateur correctement ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::all()->where('id', $id)->first();
        $roleUser = Role::all()->where('role_id', $user->fk_role_id)->first();
        $roles = Role::all();

        return view('others.user-update', ['user' => $user, 'roleUser' => $roleUser, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $user = User::where('id', $id)->first();
        $user-> name = request('name');
        $user-> email = request('email');
        $user-> fk_role_id = request('role');
        $user->save();

        return redirect()->route('index-users')->with('update','Utilisateur mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
