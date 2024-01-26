<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'return_on' => 'required|date',
        ]);

        $borrow = Borrow::findOrFail($id);

        Book::where('id', $borrow->book_id)->update(['status' => 'active']);

        $borrow->return_on = $request->return_on; // Perbarui kolom return_on
        $borrow->update();

        return redirect()->route('borrow')
        ->with('success','Berhasil Mengubah Peminjaman');
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
        $start = $request->borrow_start;
        $end = $request->borrow_end;

        $borrows = Borrow::whereDate('borrow_start', '>=', $start)
        ->whereDate('borrow_start', '<=', $end)->get();

        return view('borrowing.index', compact('borrows'));
    }
}
