<?php

namespace App\Http\Controllers;

use App\Tables\Roles;
use Spatie\Permission\Models\Role;
use ProtoneMedia\Splade\SpladeForm;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Roles::class
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $form = SpladeForm::make()
        //     ->action(route('admin.roles.store'))
        //     ->fields([
        //         Input::make('name')->label('Name'),
        //         Submit::make()->label('Save')
        //     ])->class('space-y-4 bg-white rounded p-4');

        return view('admin.roles.create', [
            // 'form' => $form
            'permissions' => Permission::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());

        $role->syncPermissions($request->permissions);

        Splade::toast('Role created')->autoDismiss(3);

        return to_route('admin.roles.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // $form = SpladeForm::make()
        //     ->action(route('admin.roles.update', $role))
        //     ->method('PUT')
        //     ->fields([
        //         Input::make('name')->label('Name'),
        //         Submit::make()->label('Update')
        //     ])
        //     ->fill($role)
        //     ->class('space-y-4 bg-white rounded p-4');

        return view('admin.roles.edit', [
            // 'form' => $form
            'role' => $role,
            'permissions' => Permission::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $role->syncPermissions($request->permissions);
        Splade::toast('Role updated')->autoDismiss(3);

        return to_route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        Splade::toast('Role deleted')->autoDismiss(3);
        return back();
    }
}
