<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('reviews')->paginate(10);

        return response()->json([
            'message' => 'List of books retrieved successfully',
            'data' => $books,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'message' => 'Book detail retrieved',
            'data' => $book,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|integer|min:0',
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book,
        ], 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
        ], 200);
    }
}
