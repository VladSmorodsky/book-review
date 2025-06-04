<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    private const CACHE_BOOKS_KEY = 'books';
    private const CACHE_SINGLE_BOOK_KEY = 'book';
    private const CACHE_BOOKS_EXPIRATION = 3600;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        $books = Book::when(
            $title,
            fn($query, $title) => $query->title($title)
        );
        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_six_months' => $books->popularLastSixMonths(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_six_months' => $books->highestRatedLastSixMonths(),
            default => $books->latest(),
        };

        $cacheKey = self::CACHE_BOOKS_KEY . ':' . $filter . ':' . $title; //TODO: move cache key generating into separate service

        $books = cache()->remember(
            $cacheKey,
            self::CACHE_BOOKS_EXPIRATION,
            fn() => $books->get()
        );

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $cacheKey = self::CACHE_SINGLE_BOOK_KEY . ':' . $book->id;

        $book = cache()->remember($cacheKey, self::CACHE_BOOKS_EXPIRATION, fn() => $book->load([
            'reviews' => fn($query) => $query->latest(),
        ]));

        return view(
            'books.show',
            ['book' => $book]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
