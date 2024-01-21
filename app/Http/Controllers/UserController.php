<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\TransactionBorrow;

class UserController extends Controller
{
    public function index(Request $request){
        $user_roles = User::getRolesList();

        // Apply role filter if provided
        $roleFilter = $request->input('role');
        $nameFilter = $request->input('name');

        $usersQuery = User::when($roleFilter, function ($query) use ($roleFilter) {
            return $query->where('role', $roleFilter);
        })->when($nameFilter, function ($query) use ($nameFilter) {
            return $query->where('name', 'like', '%'.$nameFilter.'%');
        });

        // Paginate the filtered data
        $users = $usersQuery->paginate(10);
        return view('users.index', [
            'page_title' => 'peminjam',
            'users' => $users,
            'user_roles' => $user_roles,
        ]);
    }

    public function create()
    {
        $user_roles = User::getRolesList();
        return view('users.create', [
            'page_title' => 'peminjam',
            'user_roles' => $user_roles
        ]);
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
                'nim' => $isMasyarakatUmum ? 'nullable|numeric|unique:users' : 'required|numeric|unique:users',
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

    public function show($id)
    {
        $user = User::findOrFail($id);
        $trx_with_books = TransactionBorrow::join('books', 'transaction_borrow.book_id', '=', 'books.id')
            ->where('transaction_borrow.user_id', $user->id)
            ->orderBy('transaction_borrow.borrow_start', 'desc')
            ->paginate(10);

        return view('users.show', [
            'page_title' => 'peminjam',
            'user' => $user,
            'trx_with_books' => $trx_with_books,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_roles = User::getRolesList();
        return view('users.edit', [
            'page_title' => 'peminjam',
            'user' => $user,
            'user_roles' => $user_roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        try {
            // Special logic for mahasiswa
            $isMasyarakatUmum = $request->role == User::ROLE_MASYARAKAT_UMUM;

            $validator = Validator::make($request->all(), [
                'role' => ['required', User::getRolesList()],
                'name' => 'required',
                'email' => $isMasyarakatUmum ?
                    'nullable|email|unique:users,email,' . $user->id :
                    'required|email|unique:users,email,' . $user->id,
                'nim' => $isMasyarakatUmum ?
                    'nullable|numeric|unique:users,nim,' . $user->id :
                    'required|numeric|unique:users,nim,' . $user->id,
                'contact' => 'required|numeric',
                // Add other validation rules as needed
            ]);

            if ($validator->fails()) {
                return redirect()->route('users.edit', $user->id)->withInput()->with(
                    'error',
                    'Validation error: ' . $validator->errors()->first()
                );
            }

            $user->update($request->all());
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, redirect with an error message, etc.)
            return redirect()->route('users.edit', $user->id)->with(
                'error', 'Error updating user: ' . $e->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
