<?php

namespace App\Http\Controllers;

use App\Tables\Permissions;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\Facades\Splade;
use Spatie\Permission\Models\Permission;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.permissions.index', [
            'permissions' => Permissions::class
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $form = SpladeForm::make()
        //     ->action(route('admin.permissions.store'))
        //     ->fields([
        //         Input::make('name')->label('Name'),
        //         Submit::make()->label('Save')
        //     ])->class('space-y-4 bg-white rounded p-4');

        return view('admin.permissions.create', [
            // 'form' => $form
            'roles' => Role::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->validated());

        $permission->syncRoles($request->roles);

        Splade::toast('Permission created')->autoDismiss(3);

        return to_route('admin.permissions.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        // $form = SpladeForm::make()
        //     ->action(route('admin.permissions.update', $permission))
        //     ->method('PUT')
        //     ->fields([
        //         Input::make('name')->label('Name'),
        //         Submit::make()->label('Update')
        //     ])
        //     ->fill($permission)
        //     ->class('space-y-4 bg-white rounded p-4');

        return view('admin.permissions.edit', [
            // 'form' => $form
            'permission' => $permission,
            'roles' => Role::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        $permission->syncRoles($request->roles);

        Splade::toast('Role updated')->autoDismiss(3);

        return to_route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        Splade::toast('Permission deleted')->autoDismiss(3);
        return back();
    }
}
