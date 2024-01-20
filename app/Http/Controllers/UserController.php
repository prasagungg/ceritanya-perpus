<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $user_roles = User::getRolesList();

        // Apply role filter if provided
        $roleFilter = $request->input('role');
        $usersQuery = User::when($roleFilter, function ($query) use ($roleFilter) {
            return $query->where('role', $roleFilter);
        });

        // Paginate the filtered data
        $users = $usersQuery->paginate(10);
        return view('users.index', [
            'users' => $users,
            'user_roles' => $user_roles,
        ]);
    }
}
