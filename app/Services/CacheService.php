<?php

namespace App\Services;

class CacheService
{
    public const int CACHE_EXPIRATION = 3600; // Move value into .env file
    private const string CACHE_BOOKS_KEY = 'books';
    private const string CACHE_SINGLE_BOOK_KEY = 'book';
    private const string CACHE_REVIEWS_KEY = 'reviews';

    public function getBooksKey(?string $title = '', ?string $filter = '', ?int $page = 1): string
    {
        return self::CACHE_BOOKS_KEY . ':' . $filter . ':' . $title . ':' . $page;
    }

    public function getSingleBooksKey(int $id): string
    {
        return self::CACHE_SINGLE_BOOK_KEY . ':' . $id;
    }

    public function getReviewsKey(int $bookId, ?int $page = 1): string
    {
        return self::CACHE_REVIEWS_KEY . ':' . $bookId . ':' . $page;
    }
}
