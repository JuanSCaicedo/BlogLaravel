<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        $selectedRoles = $user->roles->pluck('id')->toArray(); // Obtener los ID de las etiquetas del post

        return view('admin.users.edit', compact('user', 'roles', 'selectedRoles'));
    }

    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.edit', $user)->with('info', 'Actualizado correctamente');
    }
}
