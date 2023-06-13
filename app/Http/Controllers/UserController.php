<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
}
