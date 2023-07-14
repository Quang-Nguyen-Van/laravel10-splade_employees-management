<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tables\Users;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use ProtoneMedia\Splade\Facades\Splade;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => Users::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create', [
            'roles' => Role::pluck('name', 'id')->toArray(),
            'permissions' => Permission::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $user = User::create($request->validated());
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        Splade::toast('User Created')->autoDismiss(3);

        return to_route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name', 'id')->toArray(),
            'permissions' => Permission::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($request->only([
            'username',
            'first_name',
            'last_name',
            'email',
        ]));

        // $user->update($request->validated());

        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        Splade::toast('User updated')->autoDismiss(3);

        return to_route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        Splade::toast('User Deleted')->autoDismiss(3);

        return to_route('admin.users.index');
    }
}
