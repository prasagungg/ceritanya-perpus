<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(10);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'no_catalog' => 'required|string|unique:books,no_catalog',
                'no_isbn' => 'required|string|max:13|unique:books,no_isbn',
                // Add other validation rules as needed
            ]);

            if ($validator->fails()) {
                return redirect()->route('books.create')->withInput()->with(
                    'error',
                    'Validation error: ' . $validator->errors()->first()
                );
            }

            Book::create($request->except('_token'));

            return redirect()->route('books.index')->with("success", "Buku Berhasil Ditambah");
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, redirect with an error message, etc.)
            return redirect()->route('books.create')->with('error', 'Error creating book: ' . $e->getMessage());
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
        $book = Book::findOrFail($id);

        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'no_catalog' => 'required|string|unique:books,no_catalog,' . $book->id,
                'no_isbn' => 'required|string|max:13|unique:books,no_isbn,' . $book->id,
                // Add other validation rules as needed
            ]);

            if ($validator->fails()) {
                return redirect()->route('books.edit', $book->id)->withInput()->with(
                    'error',
                    'Validation error: ' . $validator->errors()->first()
                );
            }

            $book->update($request->except('_token'));

            return redirect()->route('books.index')->with("success", "Buku Berhasil Diperbarui");

        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, redirect with an error message, etc.)
            return redirect()->route('books.edit', $book->id)->with(
                'error', 'Error updating book: ' . $e->getMessage()
            );
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
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku Berhasil di delete');
    }
}
