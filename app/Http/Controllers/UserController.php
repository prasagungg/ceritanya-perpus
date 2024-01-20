<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        // Paginate the filtered data
        $users = User::paginate(10);
        return view('users.index', [
            'users' => $users,
        ]);
    }
}
