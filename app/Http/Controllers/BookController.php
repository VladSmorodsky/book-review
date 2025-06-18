<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\CacheService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private readonly CacheService $cacheService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        $page = $request->input('page', 1);

        $books = Book::when(
            $title,
            fn($query, $title) => $query->title($title)
        );
        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_six_months' => $books->popularLastSixMonths(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_six_months' => $books->highestRatedLastSixMonths(),
            default => $books->latest()->withAvgRating()->withReviewsCount(),
        };

        $books = cache()->remember(
            $this->cacheService->getBooksKey($title, $filter, $page),
            CacheService::CACHE_EXPIRATION,
            fn() => $books->paginate()
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
    public function show(Request $request, int $id): View
    {
        $page = $request->input('page', 1);

        $book = cache()->remember(
            $this->cacheService->getSingleBooksKey($id),
            CacheService::CACHE_EXPIRATION,
            fn() => Book::withAvgRating()->withReviewsCount()->findOrFail($id)
        );

        $reviews = cache()->remember(
            $this->cacheService->getReviewsKey($id, $page),
            CacheService::CACHE_EXPIRATION,
            fn() => $book->reviews()->latest()->paginate()
        );
        return view(
            'books.show',
            ['book' => $book, 'reviews' => $reviews]
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
