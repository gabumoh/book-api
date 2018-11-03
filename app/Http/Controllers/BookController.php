<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Book;
use Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique|max:50',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 417);
        }

        $book = Book::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique|max:50',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 417);
        }

        $book->update($request->only(['name', 'description']));

        return new BookResource($book)
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json('Book Deleted Successfully', 200);
    }
}
