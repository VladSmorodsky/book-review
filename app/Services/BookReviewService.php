<?php

namespace App\Services;

use App\Models\Book;

class BookReviewService
{
    public function createReview(Book $book, string $reviewText, int $rating): Book
    {
        $book->reviews()->create([
            'review' => $reviewText,
            'rating' => $rating,
        ]);

        return $book;
    }
}
