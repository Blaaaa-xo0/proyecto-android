<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index() 
    {
        return view('admin.users.index');
    }

    public function filter(Request $request)
    {
        $query = User::query();

        if ($request->has('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('name', 'like', "%{$nombre}%");
        }

        $users = $query->get();


        return view('admin.users.partials.filter-users', ['users' => $users])->render();
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function assignRole(User $user, Request $request)
    {
        $user->roles()->sync($request->role, $user->id);

        return redirect()->back();
    }

    public function deleteRole(User $user, Request $request)
    {
        $user->removeRole($request->role);

        return redirect()->back();
    }


}
