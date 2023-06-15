<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ver-rol'])->only('index');
        $this->middleware(['permission:editar-rol'])->only('editRole', 'UpdateRole');
    }

    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('permissions', 'role', 'rolePermissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $selected_permissions = $request->input('permissions');
        $role->syncPermissions($selected_permissions);

        // Redirige a la página de edición del rol con un mensaje de éxito
        return redirect()->back()->with('success', 'Permisos actualizados');
    }
}
