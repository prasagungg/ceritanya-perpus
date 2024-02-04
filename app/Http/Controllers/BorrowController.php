<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrows = Borrow::with(['user', 'book'])->get();

        return view('borrowing.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $book = Book::where('status', 'active')
        ->get();
        $user = User::get();
        return view('borrowing.create')
        ->with('books', $book)
        ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $year = 2024; // You can replace this with your variable
        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'book_id' => 'required',
                'borrow_start' => 'required|date|after_or_equal:'
                    . $year . '-01-01|before_or_equal:' . $year . '-12-31',
                'borrow_end' => 'required|date|after_or_equal:'
                    . $year . '-01-01|before_or_equal:' . $year . '-12-31',
            ]);

            if ($validator->fails()) {
                return redirect()->route('borrow')->with(
                    'error',
                    'Validation error: ' . $validator->errors()->first()
                );
            }

            Book::where('id', $request->book_id)->update(['status' => 'inactive' ]);

            # add id customize
            $request->merge(['no_transaction' => Borrow::generateCustomId($request->book_id)]);

            Borrow::create($request->all());
            return redirect()->route('borrow')
            ->with('success','Berhasil Menambahkan Peminjaman');
        } catch (Exception $e) {
            return redirect()->route('borrow')->with('error', 'Error creating peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $borrows = Borrow::findOrFail($id);

        return view('borrowing.edit', compact('borrows'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'return_on' => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->route('editBorrow', $id)->with(
                    'error',
                    'Validation error: ' . $validator->errors()->first()
                );
            }

            $borrow = Borrow::findOrFail($id);

            Book::where('id', $borrow->book_id)->update(['status' => 'active']);

            # add id customize
            $borrow->no_transaction = Borrow::generateCustomId($borrow->book_id);
            $borrow->return_on = $request->return_on; // Perbarui kolom return_on
            $borrow->update();

            return redirect()->route('borrow')
                ->with('success','Berhasil Mengubah Peminjaman');
        } catch (Exception $e) {
            return redirect()->route('editBorrow', $id)->with('error', 'Error updating peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter(Request $request)
    {
        try {
            $start = Carbon::parse($request->borrow_start);
            $end = Carbon::parse($request->borrow_end);

            $borrows = Borrow::whereDate('borrow_start', '>=', $start)
                ->whereDate('borrow_end', '<=', $end)
                ->get();

            return view('borrowing.index', compact('borrows'));
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, redirect with an error message, etc.)
            return redirect()->back()->with(
                'error', 'Error when: ' . $e->getMessage()
            );
        }
    }
}
