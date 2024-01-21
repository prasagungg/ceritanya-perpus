<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\User;
use App\Models\TransactionBorrow;

class DashboardController extends Controller
{
    public function index(){

        $total_book_active = Book::where('status', 'active')->count();
        $total_book_inactive = Book::where('status', 'inactive')->count();
        $total_user = User::count();

        $top_five_mahasiswa_itbs_often_borrow = User::where('role', User::ROLE_MAHASISWA_ITBS)
            ->withCount('borrows')
            ->orderByDesc('borrows_count')
            ->limit(5)
            ->get();

        $top_five_mahasiswa_luar_often_borrow = User::where('role', User::ROLE_MAHASISWA_LUAR)
            ->withCount('borrows')
            ->orderByDesc('borrows_count')
            ->limit(5)
            ->get();

        $top_five_masyarakat_umum_often_borrow = User::where('role', User::ROLE_MASYARAKAT_UMUM)
            ->withCount('borrows')
            ->orderByDesc('borrows_count')
            ->limit(5)
            ->get();

        $user_group_by_role  = User::leftJoin('transaction_borrow', 'users.id', '=', 'transaction_borrow.user_id')
            ->groupBy('users.role')
            ->orderBy('users.role')
            ->selectRaw('users.role, COUNT(transaction_borrow.transaction_borrow_id) as borrows_count')
            ->get();

        $transaction_borrow_group_by_borrow_start  = TransactionBorrow::groupBy(DB::raw('DATE(borrow_start)'))
            ->orderBy(DB::raw('DATE(borrow_start)'))
            ->selectRaw('
                DATE(borrow_start) as borrow_date,
                COUNT(transaction_borrow.transaction_borrow_id) as borrows_count')
            ->get();

        return view('dashboard', compact(
            'total_book_active',
            'total_book_inactive',
            'total_user',
            'top_five_mahasiswa_itbs_often_borrow',
            'top_five_mahasiswa_luar_often_borrow',
            'top_five_masyarakat_umum_often_borrow',
            'user_group_by_role',
            'transaction_borrow_group_by_borrow_start',
        ));
    }
}
