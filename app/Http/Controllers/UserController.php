<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function create()
    {
        $user_roles = User::getRolesList();
        return view('users.create', ['user_roles' => $user_roles]);
    }

    public function store(Request $request)
    {
        try {
            // special logic for mahasiswa
            $isMasyarakatUmum = $request->role == User::ROLE_MASYARAKAT_UMUM;

            $validator = Validator::make($request->all(), [
                'role' => ['required', User::getRolesList()],
                'name' => 'required',
                'email' => $isMasyarakatUmum ? 'nullable|email|unique:users' : 'required|email|unique:users',
                'nim' => $isMasyarakatUmum ? 'nullable|numeric' : 'required|numeric',
                'contact' => 'required|numeric',
                // Add other validation rules as needed
            ]);

            if ($validator->fails()) {
                return redirect()->route('users.create')->withInput()->with(
                    'error',
                    'Validation error: ' . $validator->errors()->first()
                );
            }

            User::create($request->all());
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, redirect with an error message, etc.)
            return redirect()->route('users.create')->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }
}
